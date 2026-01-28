<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>@yield('title', 'Event Manager')</title>
</head>

<body>
    @include('partials._navbar')
    @if (session('success'))
        <div style="color: green; background: #e6fffa; padding: 10px;">{{ session('success') }}</div>
    @endif

    @if (session('failure'))
        <div style="color: red; background: #fff5f5; padding: 10px;">{{ session('failure') }}</div>
    @endif

    <main>
        @yield('content') </main>
</body>

</html>