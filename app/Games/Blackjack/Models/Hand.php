<?php

namespace App\Games\Blackjack\Models;


class Hand
{
    const ACE_MIN_VALUE = 1;
    const ACE_MAX_VALUE = 11;

    /**
     * @var Card[]
     */
    private $cards;

    public function addCard(Card $card, $facingDown = false): void
    {
        if ($facingDown) {
            $card->setFacingDown($facingDown);
        }
        $this->cards[] = $card;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function values(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            if (!$card->getFacingDown()) {
                $values[] = $card->getValue();
            }
        }
        return $values;
    }

    public function currentScore(): int
    {
        $values = collect($this->values());

        //Sum without aces
        $sum = $values
            ->filter(function ($value) {
                return $value !== self::ACE_MAX_VALUE;
            })
            ->flatten()
            ->sum();

        //Count aces
        $aceCount = $values->filter(function ($value) {
            return $value === self::ACE_MAX_VALUE;
        })->count();

        if (!$aceCount) {
            return $sum;
        } elseif ($aceCount >= 2) {
            // if there is a lot of ace, count them as min value
            return $sum + self::ACE_MIN_VALUE * 2;
        } elseif ($sum < self::ACE_MAX_VALUE) {
            return $sum + self::ACE_MAX_VALUE;
        } else {
            return $sum + self::ACE_MIN_VALUE;
        }
    }

    public function faceUpCard()
    {
        $this->cards[0]->setFacingDown(false);
    }
}
