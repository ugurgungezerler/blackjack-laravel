<?php

namespace App\Games\Blackjack\Models;


class Card
{
    const TYPES = ['Hearts', 'Spades', 'Clubs', 'Diamonds'];
    const CARDS = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
    const CARD_VALUES = [
        'A' => 11,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'Jack' => 10,
        'Queen' => 10,
        'King' => 10,
    ];

    private $type;
    private $card;
    private $facingDown = false;

    /**
     * Card constructor.
     *
     * @param string $type
     * @param string $card
     */
    public function __construct(string $type, string $card)
    {
        $this->card = $card;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return self::CARD_VALUES[$this->card];
    }

    public function getShortName(): string
    {
        if ($this->facingDown) {
            return "?";
        }

        if (is_numeric($this->card)) {
            return $this->card;
        } else {
            return substr($this->card, 0, 1);
        }
    }

    public function getType(): string
    {
        if ($this->facingDown) {
            return "?";
        }

        return $this->type;
    }

    public function setFacingDown(bool $facing)
    {
        $this->facingDown = $facing;
    }

    public function getFacingDown(): bool
    {
        return $this->facingDown;
    }
}
