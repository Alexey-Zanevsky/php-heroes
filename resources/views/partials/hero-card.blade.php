@php
    $battleResult = $battleResult ?? null;
@endphp

<div class="hero-card shadow {{ $battleResult ? 'hero-card-' . $battleResult : '' }}">
    <div class="hero-card-header">
        {{ $player['name'] }}
    </div>

    <div class="hero-card-image">
        <img src="{{ asset($player['image'] ?? 'images/heroes/hero-1.jpg') }}" alt="{{ $player['name'] }}">
    </div>

    <div class="hero-card-content">
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-icon">
                    <img src="{{ asset('images/heart-2.png') }}" alt="Health">
                </div>
                <div class="hero-stat-value">{{ $player['hp'] }}</div>
            </div>

            <div class="hero-stat">
                <div class="hero-stat-icon">
                    <img src="{{ asset('images/sword.png') }}" alt="Strength">
                </div>
                <div class="hero-stat-value">{{ $player['strength'] }}</div>
            </div>

            <div class="hero-stat">
                <div class="hero-stat-icon">
                    <img src="{{ asset('images/shield.png') }}" alt="Defense">
                </div>
                <div class="hero-stat-value">{{ $player['defense'] }}</div>
            </div>
        </div>

        <div class="hero-spell">
            <h4>{{ $player['spell'] }}</h4>
            <p>{{ $spellDescription }}</p>
        </div>
    </div>

    @if($battleResult === 'winner')
        <div class="hero-card-result hero-card-result-winner">
            Winner
        </div>
    @elseif($battleResult === 'loser')
        <div class="hero-card-result hero-card-result-loser" aria-label="Defeated"></div>
    @endif
</div>
