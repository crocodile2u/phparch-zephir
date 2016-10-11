<?php

class Matrix {
    const ERR_ARG_EMPTY = 1;
    const ERR_ROW_NOT_ARRAY = 2;
    const ERR_ROW_EMPTY = 3;
    const ERR_ROW_LENGTH_DIFFERS = 4;
    const ERR_NOT_A_NUMBER = 5;
    const ERR_NOT_MULTIPLIABLE = 6;
    static function multiply(array $a, array $b)
    {
        $ret = [];
        $aDimensions = self::getDimensions($a);
        $bDimensions = self::getDimensions($b);
        if ($aDimensions[1] != $bDimensions[0]) {
            throw new \InvalidArgumentException("The number of columns on matrix A is not the same as the number of rows of matrix B", self::ERR_NOT_MULTIPLIABLE);
        }
        foreach ($a as $i => $aRow) {
            for ($j = 0; $j < $bDimensions[1]; $j++) {
                $ij = 0;
                foreach ($aRow as $k => $aCell) {
                    $ij += $aCell * $b[$k][$j];
                }
                $ret[$i][$j] = $ij;
            }
        }
        return $ret;
    }
    // @return [int rowCount, int columnCount]
    public static function getDimensions(array $input)
    {
        $rowCount = count($input);
        if (0 == $rowCount) {
            throw new \InvalidArgumentException("Argument is empty", self::ERR_ARG_EMPTY);
        }
        $columnCount = null;
        foreach ($input as $i => $row) {
            if (!is_array($row)) {
                throw new \InvalidArgumentException("Row " . $i . " is not an array", self::ERR_ROW_NOT_ARRAY);
            }
            $rowColumnCount = count($row);
            if (null === $columnCount) {
                $columnCount = $rowColumnCount;
            }
            if (0 == $rowColumnCount) {
                throw new \InvalidArgumentException("Row " . $i . " is empty", self::ERR_ROW_EMPTY);
            }
            if ($rowColumnCount != $columnCount) {
                throw new \InvalidArgumentException("Row " . $i . " length differs from " . $rowColumnCount, self::ERR_ROW_LENGTH_DIFFERS);
            }
            foreach ($row as $j => $col) {
                if (!is_numeric($col)) {
                    throw new \InvalidArgumentException("Element at row " . $i . ", column " . $j . " is not a number", self::ERR_NOT_A_NUMBER);
                }
            }
        }
        return [$rowCount, $columnCount];
    }
    static function dump(array $a)
    {
        $m = null;
        foreach ($a as $row) {
            $rowMax = max($row);
            if ((null === $m) || $rowMax > $m) {
                $m = $rowMax;
            }
        }
        $mlen = strlen($m);
        foreach ($a as $row) {
            foreach ($row as $col) {
                printf("% {$mlen}d  ", $col);
            }
            echo "\n";
        }
    }
}