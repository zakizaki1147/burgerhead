<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In | Burgerhead - Cashier App</title>
    <link rel="shortcut icon" href="/images/burgerhead-logo.png" type="image/x-icon">
    @vite('resources/css/app.css')
</head>
<body class="h-screen bg-red-main flex justify-center items-center">
    <div class="bg-white-main p-8 flex flex-col justify-center items-center rounded-3xl gap-6">
        <img src="/images/burgerhead-logo.png" alt="Burgerhead" class="w-54 mb-2">
        <h1 class="font-koulen text-2xl text-black-main">Log in to your account</h1>
        <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div class="flex flex-col">
                <label for="username" class="font-bold text-sm w-fit">Username</label>
                <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" required
                class="w-90 p-2 text-sm bg-white border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="password" class="font-bold text-sm w-fit">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required
                class="w-90 p-2 text-sm bg-white border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <x-primary-button color='yellow-main' type="submit">Log In</x-primary-button>
        </form>
    </div>
</body>
</html>