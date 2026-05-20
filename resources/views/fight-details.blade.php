<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Fight Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css'])

</head>
<body class="inner-page">

@include('partials.header')

<div class="container py-5 fight-details-page">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="history-title">Fight #{{ $fight->id }}</h1>

        <a href="{{ route('history') }}"
           class="btn history-button">

            Back

        </a>

    </div>

    <div class="card shadow fight-details-card">

        <div class="card-body">

            <h4 class="mb-4 fight-details-matchup">

                {{ $fight->player_a }}
                VS
                {{ $fight->player_b }}

            </h4>

            @foreach($logs as $log)

                <div class="fight-detail-log py-2">

                    <strong>Turn {{ $log->turn_number }}</strong>

                    <br>

                    {{ $log->description }}

                </div>

            @endforeach

        </div>

    </div>

</div>

</body>
</html>
