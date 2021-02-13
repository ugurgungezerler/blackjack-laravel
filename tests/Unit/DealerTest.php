<?php

namespace Tests\Unit;

use App\Games\Blackjack\Models\Game;
use PHPUnit\Framework\TestCase;

class DealerTest extends TestCase
{
    /**
     * Test dealer hit action
     *
     * @return void
     */
    public function test_dealer_hit()
    {
        $game = new Game('Player', now());
        $game->start();
        $game->dealer->hitDealer();

        $this->assertTrue(count($game->dealerHand->getCards()) === 3);
    }
}
