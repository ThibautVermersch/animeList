<header>
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="logo-img">
        </a>
        <h1 class="site-name">AnimeBox</h1>
    </div>

    <div class="search-bar">
        <form action="{{ route('animes.index') }}" method="GET" role="search" class="search-form">
            <input
                type="search"
                name="search"
                id="bar"
                placeholder="Rechercher un animé..."
                value="{{ request('search') }}"
                autocomplete="off"
                required
            >
            <button type="submit" class="button-search" aria-label="Rechercher">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </form>
    </div>

    <div class="profile">
        <img src="{{ asset('images/profile.png') }}" alt="profile" class="profile-logo">
    </div>
</header>
