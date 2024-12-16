<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Footer Section</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}" type="text/css">
</head>
<body>
<main>
        </main>
<footer class="footer bg-pink-500 text-white py-4 mt-10 w-full">
    <div class="max-w-none text-center">
        <p>&copy; {{ date('Y') }} Kendy Corner. All rights reserved.</p>
        <p>123 Fake Street, Fake City, FC 12345</p>
        <p>
            <a href="mailto:contact@kendyscorner.com" class="text-pink-100">contact@kendyscorner.com</a>
        </p>
        <p>
            <a href="{{ url()->current() }}" class="text-pink-100">Privacy Policy</a> |
            <a href="{{ url()->current() }}" class="text-pink-100">Terms of Service</a>
        </p>
    </div>
</footer>

</body>
</html>
