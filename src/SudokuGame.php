<?php
include_once 'SudokuMatrix.php';

class SudokuGame
{
    private $gameHistory;
    private $currentGame;

    function __construct($matrix = null)
    {
        $this->gameHistory = [];
        $this->currentGame = new sudokuMatrix($matrix);
    }

    public function solveSudoku()
    {
        $this->gameHistory[] = new sudokuMatrix($this->currentGame->getMatrix());
        $index = 1;
        do {
            $this->currentGame->setValues();
            $this->currentGame->eliminatePossibilities();
            $this->currentGame->verifyNumbers();
            $this->currentGame->eliminatePossibilities();
            $this->gameHistory[] = new sudokuMatrix($this->currentGame->getMatrix());

            echo "\n\n\n Current Iteration: $index\n";
            //$game->display();
            $index++;
        } while ($this->currentGame->compare($this->gameHistory[count($this->gameHistory) - 2]) == false);

        echo "\n\n ~~~~~~~~~~~~~~~~~~ Solution: or something bad:";
        $this->currentGame->display();
    }
}