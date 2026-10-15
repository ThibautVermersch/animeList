<!DOCTYPE html>
<html lang="fr">
<head>
    @include('partials.head')
</head>
<body>
<div id="top"></div>
@include('partials.header')

<main>
    @yield('content')
</main>

@include('partials.footer')
</body>
</html>
