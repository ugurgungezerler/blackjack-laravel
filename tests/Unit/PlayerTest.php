<?php

namespace Tests\Unit;

use App\Games\Blackjack\Models\Game;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{

    /**
     * Check player hit action
     *
     * @return void
     */
    public function test_player_hit()
    {
        $game = new Game('Player', now());
        $game->start();
        $game->dealer->hitPlayer();

        $this->assertTrue(count($game->playerHand->getCards()) === 3);
    }

    /**
     * Check player stay action
     *
     * @return void
     */
    public function test_player_stay_action()
    {
        $game = new Game('Player', now());
        $game->start();
        $game->dealer->hitDealerUntilToEnd();

        $this->assertTrue($game->status === Game::GAME_ENDED);
    }

    /**
     * Check player stay action
     *
     * @return void
     */
    public function test_player_bust_action()
    {
        $game = new Game('Player', now());
        $game->start();
        $game->dealer->hitPlayer();
        $game->dealer->hitPlayer();
        $game->dealer->hitPlayer();
        $game->dealer->hitPlayer();
        $game->dealer->hitPlayer();
        $game->dealer->hitPlayer();
        $game->dealer->hitPlayer();
        $game->checkPlayerBust();

        $this->assertTrue($game->status === Game::GAME_ENDED);
    }
}


