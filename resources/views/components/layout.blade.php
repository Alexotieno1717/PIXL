<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="dark" />
    <title>pixel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pixel-dark text-pixel-light flex gap-16 px-4 h-dvh overflow-clip">

    {{ $slot }}

</body>
</html>
