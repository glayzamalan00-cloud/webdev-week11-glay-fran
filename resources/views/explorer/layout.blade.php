<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            background: #f1f5f9;
            color: #1e293b;
            font-size: 16px;
        }
        nav {
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            padding: 14px 28px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 15px;
            background: rgba(255, 255, 255, 0.15);
        }
        nav a:hover { background: rgba(255, 255, 255, 0.3); }
        main {
            max-width: 900px;
            margin: 28px auto;
            padding: 0 20px;
        }
        h1 { margin: 0 0 12px; color: #312e81; font-size: 28px; }
        h3 { margin: 24px 0 6px; color: #4f46e5; }
        .badge {
            display: inline-block;
            background: #10b981;
            color: #fff;
            padding: 8px 18px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 18px;
            margin: 0 0 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        th {
            background: #4f46e5;
            color: #fff;
            text-align: left;
            padding: 12px 14px;
        }
        td { padding: 10px 14px; border-bottom: 1px solid #e2e8f0; }
        tr:nth-child(even) td { background: #f8fafc; }
        tr:hover td { background: #e0e7ff; }
        code {
            display: block;
            background: #1e293b;
            color: #a5f3fc;
            padding: 12px 14px;
            border-radius: 8px;
            margin: 6px 0;
            font-family: Consolas, monospace;
            font-size: 14px;
            overflow-x: auto;
        }
        p { margin: 8px 0; }
        form { margin-bottom: 16px; display: flex; gap: 8px; }
        input[type=text] {
            padding: 10px 14px;
            border: 2px solid #c7d2fe;
            border-radius: 8px;
            font-size: 16px;
            width: 260px;
        }
        button {
            background: #4f46e5;
            color: #fff;
            border: 0;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        button:hover { background: #4338ca; }
    </style>
</head>
<body>
    <nav>
        <a href="/events">Events (fixed)</a>
        <a href="/events/naive">Events (naive)</a>
        <a href="/events/filter?dress_code=costume">JSONB filter</a>
        <a href="/events/search?q=lantern">Search</a>
    </nav>
    <main>
        <h1>@yield('title')</h1>
        @isset($queryCount)
            <div class="badge">Queries sent: {{ $queryCount }}</div>
        @endisset
        @yield('content')
    </main>
</body>
</html>