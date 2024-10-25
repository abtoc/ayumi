<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:site_name" content="{{ $name }}様のページ">
    <meta property="og:url" content="{{ route('client', ['client' => $id]) }}">
    <meta property="og:title" content="{{ $name }}様のページ">
    <meta property="og:description" content="Ayumi枠の相互のスクショを確認頂くページになります">
    <meta property="og:image" content="{{ asset('/img/Ayumi_256.png') }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="app">
    <meta name="twitter:domain" content="system.ayumi.bar">
    <meta name="twitter:site" content="@ebi_ayu_01">
    <meta name="twitter:title" content="Ayumi枠の相互のスクショを確認頂くページになります">
    <meta name="twitter:description" content="Ayumi枠の相互のスクショを確認頂くページになります">
    <meta name="twitter:image" content="{{ asset('/img/Ayumi_256.png') }}">
    <meta name="twitter:app:country" content="JP">
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
