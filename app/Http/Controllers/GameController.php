<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private $game;

    public function __construct()
    {
        $this->game = session()->get('game');
    }

    public function startGame()
    {
        $this->game = new Game(session());
    }

    private function responseGame()
    {
        $this->game = session()->set('game', $this->game);

        return view('home', ['game' => $this->game]);
    }
}
