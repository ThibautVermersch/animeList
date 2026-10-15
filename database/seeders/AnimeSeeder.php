<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anime;
use Carbon\Carbon;

class AnimeSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path("Data.csv");

        if (!file_exists($filePath)) {
            $this->command->error("Fichier Data.csv introuvable.");
            return;
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            // Lecture des en-têtes avec séparateur ';'
            $header = fgetcsv($handle, 1000, ';');

            // Nettoyage UTF-8 / espaces sur les en-têtes
            $header = array_map(fn($col) => trim($col, " \t\n\r\0\x0B\xEF\xBB\xBF"), $header);

            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                if (count($header) !== count($row)) {
                    continue;
                }

                $data = array_combine($header, $row);

                // Récupération de la colonne 'Sortie' (au format 2024-10-03 dans ton CSV)
                $rawDate = trim($data['Sortie'] ?? '');
                $releaseDate = !empty($rawDate) ? $rawDate : null;

                Anime::create([
                    'title'         => trim($data['Anime'] ?? ''),
                    'genre'         => trim($data['Genre'] ?? '') ?: null,
                    'studio'        => trim($data['Studio'] ?? '') ?: null,
                    'seasons_count' => !empty($data['NB_Saisons']) ? (int) $data['NB_Saisons'] : 1,
                    'release_date'  => $releaseDate,
                    'status'        => trim($data['Statut'] ?? '') ?: null,
                ]);
            }

            fclose($handle);
            $this->command->info("Data.csv importé avec succès !");
        }
    }
}
