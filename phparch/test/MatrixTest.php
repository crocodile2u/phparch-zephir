<?php

use Phparch\Matrix;

class MatrixTest extends \PHPUnit_Framework_TestCase {
    /**
     * @expectedException \TypeError
     */
    function testMultiplyThrowsWhenArgumentsAreNotArrays()
    {
        Matrix::multiply(1, [2]);
    }

    function testMutiplyThrowsWhenIncompatibleMatrices()
    {
        $this->setExpectedException(\InvalidArgumentException::class, "", Matrix::ERR_NOT_MULTIPLIABLE);
        $a = [
            [1, 2],
        ];
        $b = [
            [1]
        ];
        Matrix::multiply($a, $b);
    }

    /**
     * @param int[][] $a
     * @param int[][] $b
     * @param int[][] $expected
     * @dataProvider providerTestMultiplicationWhenInputCorrect
     */
    function testMultiplicationWhenInputCorrect($a, $b, $expected)
    {
        $result = Matrix::multiply($a, $b);
        $this->assertEquals($result, $expected);
    }

    function providerTestMultiplicationWhenInputCorrect()
    {
        return [
            "1x1 * 1x1" => [
                [
                    [1],
                ],
                [
                    [1],
                ],
                [
                    [1],
                ],
            ],
            "2x2 * 2x2" => [
                [
                    [1, 1],
                    [1, 1],
                ],
                [
                    [1, 1],
                    [1, 1],
                ],
                [
                    [2, 2],
                    [2, 2],
                ],
            ],
            "2x2 * 2x2, more complicated" => [
                [
                    [1, 2],
                    [3, 4],
                ],
                [
                    [5, 6],
                    [7, 8],
                ],
                [
                    [19, 22],
                    [43, 50],
                ],
            ],
            "2x3 * 3x4" => [
                [
                    [1, 2, 3],
                    [4, 5, 6],
                ],
                [
                    [7, 8, 9, 10],
                    [11, 12, 13, 14],
                    [15, 16, 17, 18],
                ],
                [
                    [74, 80, 86, 92],
                    [173, 188, 203, 218],
                ],
            ],
        ];
    }

    function testGetDimensionsThrowsWhenArgumentIsEmpty()
    {
        $this->setExpectedException(\InvalidArgumentException::class, "", Matrix::ERR_ARG_EMPTY);
        Matrix::getDimensions([]);
    }

    function testGetDimensionsThrowsWhenARowIsNotArray()
    {
        $this->setExpectedException(\InvalidArgumentException::class, "", Matrix::ERR_ROW_NOT_ARRAY);
        Matrix::getDimensions([1]);
    }

    function testGetDimensionsThrowsWhenARowIsEmpty()
    {
        $this->setExpectedException(\InvalidArgumentException::class, "", Matrix::ERR_ROW_EMPTY);
        Matrix::getDimensions([[]]);
    }

    function testGetDimensionsThrowsWhenRowsHaveDifferentLength()
    {
        $this->setExpectedException(\InvalidArgumentException::class, "", Matrix::ERR_ROW_LENGTH_DIFFERS);
        Matrix::getDimensions([[1], [1, 2]]);
    }

    function testGetDimensionsThrowsWhenElementIsNotNumeric()
    {
        $this->setExpectedException(\InvalidArgumentException::class, "", Matrix::ERR_NOT_A_NUMBER);
        Matrix::getDimensions([[1], ["non a number"]]);
    }

    /**
     * @param int[][] $input
     * @param int[] $expectation
     * @dataProvider providerTestGetDimensionsOnValidInput
     */
    function testGetDimensionsOnValidInput($input, $expectation)
    {
        $result = Matrix::getDimensions($input);
        $this->assertEquals($expectation, $result);
    }

    function providerTestGetDimensionsOnValidInput()
    {
        return [
            "1x1" => [
                [
                    [60],
                ],
                [1, 1]
            ],
            "2x3" => [
                [
                    [66, 66, 66],
                    [67, 67, 67],
                ],
                [2, 3]
            ],
        ];
    }
}