<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <style>
        body { font-family: sans-serif; margin: 24px; }
        table { border-collapse: collapse; }
        td, th { border: 1px solid #ccc; padding: 6px 10px; }
        code { background: #f3f3f3; padding: 4px 6px; display: block; margin: 6px 0; }
    </style>
</head>
<body>
    <nav>
        <a href="/events">Events (fixed)</a> |
        <a href="/events/naive">Events (naive)</a> |
        <a href="/events/filter?dress_code=costume">JSONB filter</a> |
        <a href="/events/search?q=lantern">Search</a>
    </nav>
    <h1>@yield('title')</h1>
    @isset($queryCount)
        <p><strong>Queries sent: {{ $queryCount }}</strong></p>
    @endisset
    @yield('content')
</body>
</html>