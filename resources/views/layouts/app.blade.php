<!DOCTYPE html>
<html lang="fr">
<head>
    @include('partials.head')
</head>
<body>
@include('partials.header')

<main>
    @yield('content')
</main>

@include('partials.footer')
</body>
</html>
