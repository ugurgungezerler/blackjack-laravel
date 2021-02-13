<?php

namespace App\Games\Blackjack\Models;


class Dealer
{

    const DEALER_MAX_VALUE = 17;

    /* @var Game */
    private $game;

    public function __construct(Game &$game)
    {
        $this->game = $game;
    }

    public function hitPlayer()
    {
        $this->game->playerHand->addCard($this->game->deck->pop());
    }

    public function hitDealer(bool $facingDown = false)
    {
        $this->game->dealerHand->addCard($this->game->deck->pop(), $facingDown);
    }

    public function hitDealerUntilToEnd()
    {
        $this->game->dealerHand->faceUpCard();

        while ($this->game->dealerHand->currentScore() < self::DEALER_MAX_VALUE) {
            $this->hitDealer();
        }
        $this->game->calculateWinner();
    }
}
