<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;

class FetchAnimeImages extends Command
{
    protected $signature = 'animes:fetch-images';
    protected $description = 'Récupère les pochettes d\'animés via l\'API AniList';

    public function handle(): void
    {
        $animes = Anime::whereNull('image_url')->get();

        $this->info("Début de la récupération pour " . $animes->count() . " animés via AniList...");

        $query = '
            query ($search: String) {
                Media (search: $search, type: ANIME) {
                    coverImage {
                        extraLarge
                        large
                    }
                }
            }
        ';

        foreach ($animes as $anime) {
            try {
                $response = Http::withoutVerifying()
                    ->withHeaders([
                        'User-Agent'   => 'AnimeBox-App/1.0',
                        'Accept'       => 'application/json',
                        'Content-Type' => 'application/json',
                    ])
                    ->timeout(10)
                    ->post('https://graphql.anilist.co', [
                        'query'     => $query,
                        'variables' => ['search' => $anime->title],
                    ]);

                // 1. Si on prend un 429 (Trop de requêtes), on attend avant de continuer
                if ($response->status() === 429) {
                    $retryAfter = (int) ($response->header('Retry-After') ?? 60);
                    $this->warn("Limite de requêtes atteinte (429) sur {$anime->title}. Pause de {$retryAfter} secondes...");
                    sleep($retryAfter);
                    continue;
                }

                if ($response->successful()) {
                    $cover = $response->json('data.Media.coverImage');
                    $imageUrl = $cover['extraLarge'] ?? $cover['large'] ?? null;

                    if ($imageUrl) {
                        $anime->update(['image_url' => $imageUrl]);
                        $this->line("<info>OK :</info> {$anime->title}");
                    } else {
                        $this->warn("Pas d'image trouvée pour : {$anime->title}");
                    }
                } else {
                    $this->warn("Échec sur {$anime->title} (Code : " . $response->status() . ")");
                }

                // 2. Pause de sécurité (1 seconde) entre chaque requête
                sleep(1);

            } catch (\Exception $e) {
                $this->error("Erreur sur {$anime->title} : " . $e->getMessage());
            }
        }

        $this->info("Récupération terminée !");
    }
}
