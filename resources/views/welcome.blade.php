<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/custom.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <title>Expressway Transport (Pvt) Ltd</title>
</head>
<body>
    <div class="main-container">
        <h1 class="text-center">Expressway Transport (Pvt) Ltd</h1>
        @guest
            <a href="/login"><button type="button" class="btn btn-primary expressway-btn-medium">Login</button></a>
        @else
            <a href="/account"><button type="button" class="btn btn-primary expressway-btn-medium">Account</button></a>
        @endguest
    </div>    
</body>
</html>