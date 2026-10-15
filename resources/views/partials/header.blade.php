<header>
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="logo-img">
        </a>
        <h1 class="site-name">AnimeBox</h1>
    </div>

    <div class="search-bar">
        <form role="search" action="{{ url('/search') }}" method="GET">
            <input type="search" id="bar" name="q" placeholder="Rechercher" required>
            <button type="submit" class="button-search" role="button">🔎</button>
        </form>
    </div>

    <div class="profile">
        <img src="{{ asset('images/profile.png') }}" alt="profile" class="profile-logo">
    </div>
</header>
