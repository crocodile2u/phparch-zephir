<?php

use Phparch\Matrix;

class MatrixTest extends \PHPUnit_Framework_TestCase {
    /**
     * @expectedException \TypeError
     */
    function testMultiplyThrowsWhenArgumentsAreNotArrays()
    {
        Matrix::multiply(1, 2);
    }
}