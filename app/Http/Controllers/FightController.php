<?php

namespace App\Http\Controllers;

use App\Models\Fight;
use App\Models\FightLog;
use App\Services\FightService;
use App\Services\SpellService;
use Illuminate\Http\Request;

class FightController extends Controller
{
    protected FightService $fightService;

    protected SpellService $spellService;

    public function __construct(FightService $fightService, SpellService $spellService)
    {
        $this->fightService = $fightService;
        $this->spellService = $spellService;
    }

    public function index()
    {
        $gameStarted = session('game_started', false);

        return view('game', [
            'playerA' => $gameStarted ? session('playerA') : null,
            'playerB' => $gameStarted ? session('playerB') : null,
            'logs' => $gameStarted ? session('logs', []) : [],
            'gameOver' => session('game_over', false),
            'currentAttacker' => session('current_attacker'),
            'winner' => session('winner'),
            'loser' => session('loser'),
        ]);
    }

    public function startGame(Request $request)
    {
        $playerA = $this->fightService->createPlayer();
        $playerB = $this->fightService->createPlayer();

        // $fight = Fight::create([
        //     'player_a' => $playerA['name'],
        //     'player_b' => $playerB['name'],
        // ]);

        session([
            'playerA' => $playerA,
            'playerB' => $playerB,
            'logs' => [],
            'turn' => 1,
            // 'fight_id' => $fight->id,
            'current_attacker' => rand(0, 1) === 0 ? 'A' : 'B',
            'game_over' => false,
            'game_started' => true,
            'winner' => null,
            'loser' => null,
        ]);

        $viewData = [
            'playerA' => $playerA,
            'playerB' => $playerB,
            'logs' => [],
            'gameOver' => false,
            'currentAttacker' => session('current_attacker'),
            'winner' => null,
            'loser' => null,
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('partials.battle-screen', $viewData)->render(),
            ]);
        }

        return redirect('/');
    }

    public function fightTurn(Request $request)
    {
        $playerA = session('playerA');
        $playerB = session('playerB');
        $logs = session('logs', []);
        $turn = session('turn', 1);

        if (! session()->has('fight_id')) {

            $fight = Fight::create([
                'player_a' => $playerA['name'],
                'player_b' => $playerB['name'],
            ]);

            session([
                'fight_id' => $fight->id,
            ]);
        }

        $currentAttacker = session('current_attacker');

        if ($currentAttacker === 'A') {

            $attacker = &$playerA;
            $defender = &$playerB;

        } else {

            $attacker = &$playerB;
            $defender = &$playerA;
        }
        $temporaryDefense = $defender['defense'];

        if ($defender['aura_active']) {

            $temporaryDefense += 5;

            $defender['aura_active'] = false;

            $logs[] =
                "{$defender['name']} gained +5 temporary defense from Aura!";
        }
        $damage = max(
            0,
            $attacker['strength'] - $temporaryDefense
        );

        $defender['hp'] -= $damage;

        // ---- spells
        $this->spellService->processSpell(
            $attacker,
            $defender,
            $logs,
            $turn
        );

        $logs[] =
            "Turn {$turn}: {$attacker['name']} attacks {$defender['name']} for {$damage} damage.";

        FightLog::create([
            'fight_id' => session('fight_id'),
            'turn_number' => $turn,
            'description' => "{$attacker['name']} attacks {$defender['name']} for {$damage} damage.",
        ]);

        if ($defender['hp'] <= 0) {

            $logs[] =
                "{$attacker['name']} wins the battle!";

            $fight = Fight::find(session('fight_id'));

            $fight->update([
                'winner' => $attacker['name'],
                'loser' => $defender['name'],
                'winner_hp' => $attacker['hp'],
            ]);

            session([
                'playerA' => $playerA,
                'playerB' => $playerB,
                'logs' => $logs,
                'game_over' => true,
                'winner' => $attacker['name'],
                'loser' => $defender['name'],
            ]);

            if ($request->expectsJson()) {
                return $this->battleScreenResponse();
            }

            return redirect('/');
        }

        session([
            'playerA' => $playerA,
            'playerB' => $playerB,
            'logs' => $logs,
            'turn' => $turn + 1,
            'current_attacker' => session('rage_active') ? $currentAttacker : ($currentAttacker === 'A' ? 'B' : 'A'),
        ]);

        session()->forget('rage_active');

        if ($request->expectsJson()) {
            return $this->battleScreenResponse();
        }

        return redirect('/');
    }

    public function resetGame(Request $request)
    {
        session()->forget([
            'playerA',
            'playerB',
            'logs',
            'turn',
            'fight_id',
            'current_attacker',
            'game_over',
            'game_started',
            'winner',
            'loser',
            'rage_active',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('partials.start-screen')->render(),
            ]);
        }

        return redirect('/');
    }

    private function battleScreenResponse()
    {
        return response()->json([
            'html' => view('partials.battle-screen', [
                'playerA' => session('playerA'),
                'playerB' => session('playerB'),
                'logs' => session('logs', []),
                'gameOver' => session('game_over', false),
                'currentAttacker' => session('current_attacker'),
                'winner' => session('winner'),
                'loser' => session('loser'),
            ])->render(),
        ]);
    }

    public function history()
    {
        $fights = Fight::latest()->get();

        return view('history', compact('fights'));
    }

    public function showFight($id)
    {
        $fight = Fight::findOrFail($id);

        $logs = FightLog::where('fight_id', $id)
            ->orderBy('turn_number')
            ->get();

        return view('fight-details', compact('fight', 'logs'));
    }
}
