<?php

/**
 * Created by PhpStorm.
 * User: Tanita
 * Date: 21-May-16
 * Time: 12:51
 */
class sudokuMatrix
{
    const DETAIL_LEVEL_LOW = "low";
    const DETAIL_LEVEL_MEDIUM = "med";
    const DETAIL_LEVEL_HIGH = "high";

    private $matrix;

    function __construct($matrix = null)
    {
        $this->initMatrix();

        foreach ($matrix as $rowKey => $row) {
            foreach ($row as $cellKey => $cell) {
                if (($cell != 0) || ($cell != "")) {
                    $this->matrix[$rowKey][$cellKey] = $cell;
                }
            }
        }
    }

    private function initMatrix()
    {
        $initArray = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $this->matrix[$i][$j] = $initArray;
            }
        }
    }

    public function getMatrix()
    {
        return $this->matrix;
    }

    public function setValues()
    {
        for ($row = 0; $row < 9; $row++) {
            for ($column = 0; $column < 9; $column++) {
                if (is_array($this->matrix[$row][$column])) {
                    if (count($this->matrix[$row][$column]) == 1) {
                        $this->matrix[$row][$column] = array_pop($this->matrix[$row][$column]);
                    }
                }
            }
        }
        return $this;
    }

    public function display($detailLevel = self::DETAIL_LEVEL_LOW)
    {
        $this->displayMatrix($this->matrix, $detailLevel);
    }

    private function displayMatrix($matrix, $detailLevel = self::DETAIL_LEVEL_LOW)
    {
        foreach ($matrix as $cellKey => $cell) {
            echo "\n $cellKey => \t";
            if (is_array($cell)) {
                echo "[";
                foreach ($cell as $cellMember) {
                    if (is_array($cellMember)) {
                        switch ($detailLevel) {
                            case self::DETAIL_LEVEL_HIGH:
                                echo "\t(" . count($cellMember) . " => ";
                                foreach ($cellMember as $cellPosibility) {
                                    echo " $cellPosibility, ";
                                }
                                echo ")";
                                break;
                            case self::DETAIL_LEVEL_MEDIUM:
                                echo "\t(" . count($cellMember) . ")";
                                break;
                            case self::DETAIL_LEVEL_LOW:
                                echo "\t()";
                                break;
                        }


                    } else {
                        echo "\t $cellMember";
                    }
                }
                echo "\t]";
            } else {
                echo $cell;
            }
        }
    }

    public function getValueAt($row, $column)
    {
        return $this->matrix[$row][$column];
    }

    public function compare($otherSudokuMatrix)
    {
        foreach ($this->matrix as $rowKey => $row) {
            foreach ($row as $cellKey => $cell) {
                if (is_array($cell)) {
                    ;
                    if (count(array_diff($cell, $otherSudokuMatrix->getValueAt($rowKey, $cellKey))) != 0) {
                        return false;
                    }
                } else {
                    if ($cell != $otherSudokuMatrix->getValueAt($rowKey, $cellKey)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function verifyNumbers()
    {
        for ($i = 1; $i < 10; $i++) {
            $this->verifyRowWithNumber($i);
            $this->eliminatePossibilities();
            $this->verifyColumnWithNumber($i);
            $this->eliminatePossibilities();
        }
    }

    private function verifyRowWithNumber($number)
    {
        foreach ($this->matrix as $rowKey => $row) {
            $result = $this->verifyArrayWithNumber($number, $row);
            if ($result[0] == 1) {
                $this->matrix[$rowKey][$result[1]] = $number;
                echo "\n stuff happened";
            }
        }
    }

    private function verifyArrayWithNumber($number, $array)
    {
        $possiblePlacesForNumber = -1;
        $singleOccurrence = 0;
        foreach ($array as $cellKey => $cell) {
            if (is_array($cell)) {
                if (in_array($number, $cell) == true) {
                    $possiblePlacesForNumber = $cellKey;
                    $singleOccurrence++;
                }
            }
        }
        return [$singleOccurrence, $possiblePlacesForNumber];
    }

    public function eliminatePossibilities()
    {
        $this->eliminatePossibilitiesFromRows();
        $this->eliminatePossibilitiesFromColumns();
        $this->eliminatePosibilitiesFromSquares();
    }

    private function eliminatePossibilitiesFromRows()
    {
        foreach ($this->matrix as &$row) {
            $row = $this->doEliminationWork($row);
        }
    }

    private function eliminatePossibilitiesFromColumns()
    {
        $array = [];
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $array[] = $this->matrix[$j][$i];
            }
            $result = $this->doEliminationWork($array);

            for ($j = 0; $j < 9; $j++) {
                $this->matrix[$j][$i] = $result[$j];
            }
            $array = null;
        }
    }

    private function eliminatePosibilitiesFromSquares()
    {
        for ($row = 0; $row < 3; $row++) {
            for ($column = 0; $column < 3; $column++) {
                $arrayToProcess = $this->getArrayFromSquare($row, $column);
                $result = $this->doEliminationWork($arrayToProcess);
                $this->putArrayToSquare($row, $column, $result);
            }
        }
    }

    private function doEliminationWork($array)
    {
        $solidValues = [];
        foreach ($array as $cell) {
            if (is_array($cell) == false) {
                $solidValues[] = $cell;
            }
        }
        foreach ($array as &$cell) {
            if (is_array($cell)) {
                $cell = array_diff($cell, $solidValues);
            }
        }

        return $array;
    }

    private function getArrayFromSquare($squareRow, $squareColumn)
    {
        $array = [];
        for ($row = 0; $row < 3; $row++) {
            for ($column = 0; $column < 3; $column++) {
                $array[] = $this->matrix[$row + (3 * $squareRow)][$column + (3 * $squareColumn)];
            }
        }
        return $array;
    }

    private function putArrayToSquare($squareRow, $squareColumn, $array)
    {
        $index = 0;
        for ($row = 0; $row < 3; $row++) {
            for ($column = 0; $column < 3; $column++) {
                $this->matrix[$row + (3 * $squareRow)][$column + (3 * $squareColumn)] = $array[$index];
                $index++;
            }
        }
    }

    private function verifyColumnWithNumber($number)
    {
        $array = [];
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $array[] = $this->matrix[$j][$i];
            }
            $result = $this->verifyArrayWithNumber($number, $array);
            if ($result[0] == 1) {
                echo "\n column issue $number";
                echo "\n\t i=$i and result=" . $result[1];
                $this->matrix[$result[1]][$i] = $number;
            }
            $array = null;
        }

    }


}