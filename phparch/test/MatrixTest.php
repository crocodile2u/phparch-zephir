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