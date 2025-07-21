<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>403 | Burgerhead - Cashier App</title>
    <link rel="shortcut icon" href="/images/burgerhead-logo.png" type="image/x-icon">
    @vite('resources/css/app.css')
</head>
<body class="bg-red-main w-full h-screen flex justify-center items-center">
    <div class="p-8 flex flex-col justify-center items-center gap-6 bg-white-main rounded-3xl ">
        <x-lucide-alert-circle class="w-40 text-red-main"></x-lucide-circle>
        <p class="font-bold text-2xl text-red-main">403 | Access forbidden!</p>
        <div class="w-36 bg-white-main">
            <x-secondary-button color="red-main" onclick="handleBack()">Back</x-secondary-button>
        </div>
    </div>
    <script>
        function handleBack() {
            if (document.referrer) {
                window.history.back();
            } else {
                window.location.href = '{{ route('dashboard') }}';
            }
        }
    </script>
</body>
</html>