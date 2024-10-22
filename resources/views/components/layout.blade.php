<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $name }}様スクショ提供ページ</title>
    @vite(['resources/scss/app_c.scss', 'resources/js/app_c.js'])
</head>
<body>
    <header data-bs-theme="dark">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <div class="navbar-brand">{{ $name }}様のページ</div>
            </div>
        </nav>
    </header>
    <main>
        {{ $content }}
    </main>
</body>
</html>
