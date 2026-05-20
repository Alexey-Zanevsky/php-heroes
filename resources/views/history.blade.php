<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Fight History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    @vite(['resources/css/app.css'])

</head>
<body class="inner-page">

@include('partials.header')

<div class="container py-5 history-page">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="history-title">Historical Fights</h1>

        <a href="/" class="btn history-button">
            Back to Game
        </a>

    </div>

    <table class="table table-striped data-table">

        <thead>

        <tr>
            <th>ID</th>
            <th>Player A</th>
            <th>Player B</th>
            <th>Winner</th>
            <th>Loser</th>
            <th>Winner HP</th>
            <th>Details</th>
        </tr>

        </thead>

        <tbody>

        @foreach($fights as $fight)

            <tr>

                <td>{{ $fight->id }}</td>

                <td>{{ $fight->player_a }}</td>

                <td>{{ $fight->player_b }}</td>

                <td>{{ $fight->winner }}</td>

                <td>{{ $fight->loser }}</td>

                <td>{{ $fight->winner_hp }}</td>

                <td>

                    <a href="{{ route('fight.details', $fight->id) }}"
                       class="btn btn-sm history-button history-button-sm">

                        Details

                    </a>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $('.data-table').DataTable();
</script>

</body>
</html>
