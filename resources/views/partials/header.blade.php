<header class="game-header" style="--header-background: url('{{ asset('images/header.png') }}');">
    <div class="container position-relative h-100 d-flex align-items-center justify-content-center">
        <a href="{{ route('reset.game') }}" class="game-title text-decoration-none" data-reset-game>
            PHP Heroes
        </a>

        <a href="{{ route('history') }}" class="btn btn-dark game-header-button">
            Historical Fights
        </a>
    </div>
</header>
