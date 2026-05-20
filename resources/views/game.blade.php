<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PHP Heroes</title>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="--page-background: url('{{ asset('images/woods.png') }}');">

@include('partials.header')

<div class="container py-5" id="game-content">

    @empty($playerA)
        @include('partials.start-screen')
    @endempty

    @isset($playerA)
        @include('partials.battle-screen')
    @endisset
</div>

</body>
</html>
