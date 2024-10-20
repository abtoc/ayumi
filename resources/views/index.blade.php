<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayumi System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>
<body>
    <div id="app"></div>
</body>
</html>
