<?php

namespace App\Http\Controllers;

use App\Models\Anime;

class AnimeController extends Controller
{
    public function index()
    {
        $animes = Anime::orderBy('title', 'asc')->get();
        return view('animes.index', compact('animes'));
    }

    public function show(int $id)
    {
        // Récupère l'animé par son ID ou renvoie une erreur 404 s'il n'existe pas
        $anime = Anime::findOrFail($id);

        return view('animes.show', compact('anime'));
    }
}
