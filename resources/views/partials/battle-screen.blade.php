@php
    $spellDescriptions = [
        'Strong Strike' => 'Adds 5-10 extra damage when it triggers.',
        'Ice Projectile' => 'Hits the enemy for 8 bonus damage.',
        'Shield' => 'Raises the hero defense by 1-3 points.',
        'Aura' => 'Empowers the next defense with a +5 bonus.',
        'Critical Hit' => 'Has a small chance to instantly win the battle.',
        'Voice of Nature' => 'Has a small chance to restore full health.',
        'Rage' => 'May give the hero an immediate extra attack.',
        'Reincarnation' => 'Restores 5-10 health, up to the maximum.',
    ];

    $attackerDirection = $currentAttacker === 'B' ? 'left' : 'right';
    $winner = $winner ?? null;
@endphp

<div class="battle-layout game-screen">
    <div class="battle-arena">
        @include('partials.hero-card', [
            'player' => $playerA,
            'spellDescription' => $spellDescriptions[$playerA['spell']] ?? 'A mysterious spell with unknown power.',
            'battleResult' => $gameOver ? ($winner === $playerA['name'] ? 'winner' : 'loser') : null,
        ])

        <div class="fight-control">
            <div class="attack-arrow attack-arrow-{{ $attackerDirection }}" aria-label="Current attack direction">
                <span></span>
            </div>

            @if(!$gameOver)
                <form action="{{ route('fight.turn') }}" method="POST" data-game-form data-transition="none">
                    @csrf

                    <button class="btn fight-turn-button">
                        Fight Turn
                    </button>
                </form>
            @else
                <form action="{{ route('start.game') }}" method="POST" data-game-form data-transition="full">
                    @csrf

                    <button class="btn fight-turn-button new-game-button">
                        New Game
                    </button>
                </form>
            @endif
        </div>

        @include('partials.hero-card', [
            'player' => $playerB,
            'spellDescription' => $spellDescriptions[$playerB['spell']] ?? 'A mysterious spell with unknown power.',
            'battleResult' => $gameOver ? ($winner === $playerB['name'] ? 'winner' : 'loser') : null,
        ])
    </div>

    <aside class="battle-logs shadow">
        <h3>Battle Logs</h3>
        <div class="battle-logs-list">
            @forelse($logs as $log)
                <div class="battle-log-entry">
                    {{ $log }}
                </div>
            @empty
                <p class="battle-log-empty">No battle actions yet.</p>
            @endforelse
        </div>
    </aside>
</div>
