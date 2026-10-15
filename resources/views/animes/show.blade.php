@extends('layouts.app')

@section('title', $anime->title . ' - AnimeBox')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/card-preview.css') }}">
@endsection

@section('content')
    <div class="anime-container">

        <div class="poster-card">
            <img src="{{ $anime->image_url ?? asset('images/default.jpg') }}" alt="Affiche de {{ $anime->title }}">
        </div>

        <div class="info-card">
            <h1 class="anime-title">{{ $anime->title }}</h1>

            <div class="synopsis-section">
                <h3>Synopsis :</h3>
                <p>
                    {{ $anime->synopsis ?? 'Aucun synopsis disponible pour le moment.' }}
                </p>
            </div>

            @if($anime->genre)
                <div class="categories-section">
                    <h3>Catégorie :</h3>
                    <div class="tags-grid">
                        {{-- Sépare les genres par virgule si stockés sous forme "Action, Shonen, ..." --}}
                        @foreach(array_map('trim', explode(',', $anime->genre)) as $genre)
                            <span class="badge">{{ $genre }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="meta-section">
                <div class="meta-row">
                    <span class="meta-label">Studio d'animation :</span>
                    <span class="badge badge-wide">{{ $anime->studio ?? 'Non renseigné' }}</span>
                </div>

                <div class="meta-row">
                    <span class="meta-label">Saisons :</span>
                    <span class="badge badge-wide">{{ $anime->seasons_count ?? 1 }}</span>
                </div>

                <div class="meta-row">
                    <span class="meta-label">Date de sortie :</span>
                    <span class="badge badge-wide">{{ $anime->release_date ?? 'Non renseignée' }}</span>
                </div>

                <div class="meta-row">
                    <span class="meta-label">Statut :</span>
                    <span class="badge badge-wide">{{ $anime->status ?? 'Inconnu' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
