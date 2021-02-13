<?php

namespace Tests\Unit;

use App\Games\Blackjack\Models\Card;
use App\Games\Blackjack\Models\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * This will check the game starter
     *
     * @return void
     */
    public function test_game_starter()
    {
        $game = new Game('Player', now());
        $game->start();

        $this->assertTrue($game->status === Game::GAME_STARTED);
        $this->assertTrue($game->playerHand->currentScore() > 0);
        $this->assertTrue($game->dealerHand->currentScore() > 0);
    }

    public function test_ace_values_case_1()
    {
        $game = new Game('Player', now());
        $game->start();

        $playerHands = [
            new Card(Card::TYPE_DIAMONDS, 'A'),
            new Card(Card::TYPE_DIAMONDS, 'JACK')
        ];
        $game->playerHand->setCards($playerHands);

        $dealerHands = [
            new Card(Card::TYPE_CLUBS, 'A'),
            new Card(Card::TYPE_DIAMONDS, 'A'),
            new Card(Card::TYPE_DIAMONDS, 'JACK')
        ];
        $game->dealerHand->setCards($dealerHands);
        $game->calculateWinner();

        $this->assertTrue($game->winner === Game::PLAYER);
    }

    public function test_ace_values_case_2()
    {
        $game = new Game('Player', now());
        $game->start();

        $playerHands = [
            new Card(Card::TYPE_DIAMONDS, 'A'),
            new Card(Card::TYPE_DIAMONDS, '9')
        ];
        $game->playerHand->setCards($playerHands);

        $dealerHands = [
            new Card(Card::TYPE_DIAMONDS, 'A'),
            new Card(Card::TYPE_DIAMONDS, '10')
        ];
        $game->dealerHand->setCards($dealerHands);
        $game->calculateWinner();

        $this->assertTrue($game->winner === Game::DEALER);
    }

    public function test_ace_values_case_3()
    {
        $game = new Game('Player', now());
        $game->start();

        $playerHands = [
            new Card(Card::TYPE_DIAMONDS, 'A'),
            new Card(Card::TYPE_DIAMONDS, 'A'),
            new Card(Card::TYPE_DIAMONDS, 'A')
        ];
        $game->playerHand->setCards($playerHands);

        $dealerHands = [
            new Card(Card::TYPE_DIAMONDS, '4'),
        ];
        $game->dealerHand->setCards($dealerHands);
        $game->calculateWinner();

        $this->assertTrue($game->winner === Game::DEALER);
    }

}
