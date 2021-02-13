<?php

namespace App\Games\Blackjack\Models;

use Illuminate\Support\Collection;

class Deck
{
    /**
     * @var array
     */
    private $cards;

    /**
     * Deck constructor.
     */
    public function __construct()
    {
        foreach (Card::TYPES as $type) {
            foreach (Card::CARDS as $card) {
                $this->cards[] = new Card($type, $card);
            }
        }
        $this->cards = collect($this->cards)->shuffle()->all();
    }

    /**
     * Cards getter
     *
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Generate decks
     * @param int $count
     * @return Collection
     */
    public static function generate(int $count)
    {
        $cards = [];
        for ($i = 0; $i < $count; $i++) {
            $deck = new self();
            $cards[] = $deck->getCards();
        }
        return collect($cards)->flatten();
    }
}
