<section class="start-screen">
    <div class="start-panel shadow">
        <h1>Welcome to PHP Heroes</h1>

        <p>
            Two brave heroes enter the arena with random health, strength, defense, and a unique spell.
            Each turn one hero attacks the other, spells may trigger, and the battle continues until only one
            champion remains.
        </p>

        <p class="start-author">
            Created by Aliaksei Zaneuski
        </p>
    </div>

    <form action="{{ route('start.game') }}" method="POST" class="start-form" data-game-form data-transition="full">
        @csrf

        <button class="btn start-game-button">
            Start Game
        </button>
    </form>
</section>
