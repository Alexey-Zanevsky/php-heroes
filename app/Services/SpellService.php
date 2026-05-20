<?php

namespace App\Services;

class SpellService
{
    protected FightService $fightService;

    public function __construct(FightService $fightService)
    {
        $this->fightService = $fightService;
    }

    public function processSpell(
        array &$attacker,
        array &$defender,
        array &$logs,
        int $turn
    ): void {

        if (rand(1, 3) !== 1) {
            return;
        }

        switch ($attacker['spell']) {

            case 'Strong Strike':

                $extraDamage = rand(5, 10);

                $defender['hp'] -= $extraDamage;

                $description =
                    "{$attacker['name']} used Strong Strike for {$extraDamage} extra damage!";

                $logs[] = $description;

                $this->fightService->saveFightLog($turn, $description);
                break;

            case 'Ice Projectile':

                $defender['hp'] -= 8;

                $description =
                    "{$attacker['name']} used Ice Projectile for 8 damage!";

                $logs[] = $description;

                $this->fightService->saveFightLog($turn, $description);
                break;

            case 'Shield':

                $boost = rand(1, 3);

                $attacker['defense'] += $boost;

                $description =
                    "{$attacker['name']} used Shield and gained {$boost} defense!";

                $logs[] = $description;

                $this->fightService->saveFightLog($turn, $description);
                break;

            case 'Critical Hit':

                if (rand(1, 10) === 1) {

                    $defender['hp'] = 0;

                    $description =
                        "{$attacker['name']} used Critical Hit and instantly won the battle!";

                    $logs[] = $description;

                    $this->fightService->saveFightLog($turn, $description);
                }

                break;

            case 'Voice of Nature':

                if (rand(1, 10) === 1) {

                    $attacker['hp'] = 100;

                    $description =
                        "{$attacker['name']} restored full HP using Voice of Nature!";

                    $logs[] = $description;

                    $this->fightService->saveFightLog($turn, $description);
                }

                break;

            case 'Aura':

                $attacker['aura_active'] = true;

                $description =
                    "{$attacker['name']} activated Aura! Next defense gains +5.";

                $logs[] = $description;

                $this->fightService->saveFightLog($turn, $description);

                break;

            case 'Reincarnation':

                $heal = rand(5, 10);

                $attacker['hp'] += $heal;

                if ($attacker['hp'] > 100) {
                    $attacker['hp'] = 100;
                }

                $description =
                    "{$attacker['name']} healed {$heal} HP using Reincarnation!";

                $logs[] = $description;

                $this->fightService->saveFightLog($turn, $description);

                break;

            case 'Rage':

                if (rand(1, 5) === 1) {

                    session([
                        'rage_active' => true,
                    ]);

                    $description =
                        "{$attacker['name']} activated Rage and attacks again!";

                    $logs[] = $description;

                    $this->fightService->saveFightLog($turn, $description);
                }

                break;
        }
    }
}
