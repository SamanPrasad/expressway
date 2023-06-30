<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Scripts -->
    @vite(['resources/css/custom.css', 'resources/sass/app.scss', 'resources/js/app.js'])

    <title>Document</title>
</head>
<body class="test">
    <button type="button" class="btn btn-primary">Primary</button>
    @foreach($posts as $post)
    <h1>ID - {{$post->id}}</h1>
    <h1>Title - {{$post->title}}</h1>
    <h2>Body - {{$post->context}}</h2>
    <h3>Mins - {{$post->mins}}</h3>
    @endforeach
    <div class="test d-flex justify-content-center">
        {{$posts->links()}}
    </div>
</body>
</html>