<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} | Burgerhead - Cashier App </title>
    <link rel="shortcut icon" href="/images/burgerhead-logo.png" type="image/x-icon">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-white-main flex">
    <div class="w-70">
        <x-sidebar />
    </div>
    <main class="flex-1 bg-white-main flex flex-col gap-2 p-6">
        <x-breadcrumb>{{ $title }}</x-breadcrumb>
        {{ $slot }}
    </main>
</body>
</html>