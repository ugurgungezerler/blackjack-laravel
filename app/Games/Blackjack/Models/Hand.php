<?php

namespace App\Games\Blackjack\Models;

class Hand
{
    private const ACE_MIN_VALUE = 1;
    private const ACE_MAX_VALUE = 11;

    /**
     * @var Card[]
     */
    private $cards;

    /**
     * Add card to hand
     *
     * @param Card $card
     * @param bool $facing
     */
    public function addCard(Card $card, $facing = true): void
    {
        $card->setFacing($facing);
        $this->cards[] = $card;
    }

    /**
     * Cards getter
     *
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Cards setter
     *
     * @param array $cards
     */
    public function setCards(array $cards): void
    {
        $this->cards = $cards;
    }

    /**
     * Get card values
     *
     * @return array
     */
    public function values(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            if ($card->getFacing()) {
                $values[] = $card->getValue();
            }
        }
        return $values;
    }

    /**
     * Calculate current hand score
     *
     * @return int
     */
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

    /**
     *  Flip the card
     */
    public function faceUpCard()
    {
        $this->cards[0]->setFacing(true);
    }
}
