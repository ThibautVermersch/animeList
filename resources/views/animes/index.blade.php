@extends('layouts.app')

@section('title', 'AnimeBox - Accueil')

@section('content')
    <section class="anime-card-section">
        @foreach ($animes as $anime)
            <a href="{{ route('animes.show', $anime->id) }}" class="card-preview">
                <article class="anime-card">
                    <img
                        src="{{ $anime->image_url ?? asset('images/default.jpg') }}"
                        alt="{{ $anime->title }}"
                        class="anime-card-img"
                    >
                    <h3>{{ $anime->title }}</h3>
                </article>
            </a>
        @endforeach
    </section>
@endsection
