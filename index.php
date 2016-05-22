<?php

include_once 'src/SudokuGame.php';


$sudoku255Easy = [
    [1, 3, 0,   0, 0, 6,    0, 0, 0],
    [0, 7, 4,   0, 0, 2,    5, 8, 0],
    [0, 0, 0,   0, 5, 0,    3, 0, 0],

    [0, 8, 0,   0, 1, 0,    0, 0, 0],
    [0, 0, 0,   0, 6, 0,    0, 2, 9],
    [0, 0, 0,   0, 0, 0,    4, 3, 0],

    [0, 0, 0,   0, 3, 0,    0, 5, 0],
    [9, 0, 3,   0, 0, 0,    7, 0, 4],
    [0, 0, 0,   0, 7, 5,    8, 0, 0],
];

$sudoku251Medium = [
    [0, 0, 0,   6, 2, 0,    0, 0, 1],
    [4, 9, 0,   0, 0, 0,    0, 0, 0],
    [8, 0, 0,   0, 0, 7,    6, 0, 0],

    [0, 0, 4,   0, 0, 0,    0, 2, 3],
    [9, 0, 0,   2, 0, 6,    7, 5, 0],
    [7, 0, 0,   0, 8, 0,    9, 0, 0],

    [0, 0, 7,   0, 3, 0,    2, 4, 0],
    [0, 0, 0,   0, 0, 0,    0, 0, 5],
    [0, 0, 0,   0, 0, 0,    0, 0, 0],
];

$sudoku251Hard = [
    [0, 0, 0,   0, 0, 7,    0, 0, 0],
    [3, 0, 8,   0, 0, 0,    6, 0, 0],
    [0, 2, 0,   0, 0, 8,    0, 4, 7],

    [0, 0, 0,   0, 0, 0,    5, 0, 0],
    [0, 8, 4,   0, 6, 0,    0, 2, 0],
    [6, 0, 0,   3, 5, 0,    0, 0, 0],

    [0, 0, 0,   0, 0, 0,    9, 0, 0],
    [0, 9, 2,   0, 0, 0,    0, 6, 0],
    [0, 0, 0,   8, 2, 0,    0, 0, 0],
];

$incomplete = [
    [2, 0, 0,   0, 0, 0,    0, 0, 0],
    [0, 0, 0,   0, 0, 0,    0, 0, 0],
    [0, 0, 0,   0, 0, 0,    0, 0, 0],

    [0, 0, 0,   0, 0, 0,    0, 0, 0],
    [0, 0, 0,   0, 0, 0,    0, 0, 0],
    [0, 0, 0,   0, 0, 0,    0, 0, 0],

    [0, 0, 0,   0, 0, 0,    0, 0, 0],
    [0, 0, 0,   0, 0, 0,    0, 0, 0],
    [0, 0, 0,   0, 0, 0,    0, 0, 0],
];


$game1 = new SudokuGame($sudoku255Easy);
$game1->solveSudoku();

$game1 = new SudokuGame($sudoku251Medium);
$game1->solveSudoku();

$game1 = new SudokuGame($sudoku251Hard);
$game1->solveSudoku();

$game1 = new SudokuGame($incomplete);
$game1->solveSudoku();

// TODO:
/*
 * Add validations:
 *  - matricea de intrare trebuie sa aibe dimensiunile corecte
 *  - cifrele din interiorul matricei sa fie intre 1 si 9
 *  - datele de intrare sa fie valide dpdv. sudoku: sa nu se repete o cifra pe linii/coloane/squares
 *
 * Add logic for impossible sudokus:
 *  - in cazul in care in urma rularii algoritmului curent nu s-a ajuns la solutia finala,
 * datorita faptului ca sunt prea multe posibilitati intr-o celula, algoritmul sa genereze totusi o solutie
 * e.g. din matriecea $incomplete sa se afiseze 1 solutie corecta.
 *  - in cazul in care nu exista solutii pentru configuratia data, sa dea eroarea corespunzatoare.
 */