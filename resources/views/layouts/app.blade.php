<!DOCTYPE html>
<html lang="en">
<head>
    @include("layouts.head")
</head>
<body id="app-layout">
<header>
    @include("layouts.nav")
</header>

<main>
    <div class="container pt-3">
        @yield('content')
    </div>
</main>

<footer>
    @include("layouts.footer")
</footer>
@include("layouts.scripts")
</body>
</html>
