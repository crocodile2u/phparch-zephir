namespace Phparch;

class Matrix
{
    const ERR_ARG_EMPTY = 1;
    const ERR_ROW_NOT_ARRAY = 2;
    const ERR_ROW_EMPTY = 3;
    const ERR_ROW_LENGTH_DIFFERS = 4;
    const ERR_NOT_A_NUMBER = 5;
    const ERR_NOT_MULTIPLIABLE = 6;
    public static function multiply(array a, array b) -> array {
        var ret, aDimensions, bDimensions;
        let ret = [];
        let aDimensions = self::getDimensions(a);
        let bDimensions = self::getDimensions(b);
        if aDimensions[1] != bDimensions[0] {
            throw new \InvalidArgumentException("The number of columns on matrix A is not the same as the number of rows of matrix B", Matrix::ERR_NOT_MULTIPLIABLE);
        }
        var i, aRow;
        for i, aRow in a {
            var j;
            let j = 0;
            while j < bDimensions[1] {
                var k, ij, aCell;
                let ij = 0;
                for k, aCell in aRow {
                    let ij += aCell * b[k][j];
                }
                let ret[i][j] = ij;
                let j += 1;
            }
        }
        return ret;
    }
    // @param int[][] input
    // @return [int rowCount, int columnCount]
    public static function getDimensions(array input) -> array
    {
        var rowCount;
        let rowCount = count(input);
        if 0 == rowCount {
            throw new \InvalidArgumentException("Argument is empty", Matrix::ERR_ARG_EMPTY);
        }

        var row, columnCount, rowColumnCount, i;
        let columnCount = null;
        for i, row in input {
            if !is_array(row) {
                throw new \InvalidArgumentException("Row " . i . " is not an array", Matrix::ERR_ROW_NOT_ARRAY);
            }

            let rowColumnCount = count(row);
            if null === columnCount {
                // First row. All the other rows will have to be of this length.
                let columnCount = rowColumnCount;
            }

            if 0 == rowColumnCount {
                throw new \InvalidArgumentException("Row " . i . " is empty", Matrix::ERR_ROW_EMPTY);
            }

            if rowColumnCount != columnCount {
                throw new \InvalidArgumentException("Row " . i . " length differs from " . rowColumnCount, Matrix::ERR_ROW_LENGTH_DIFFERS);
            }

            var col, j;
            for j, col in row {
                if !is_numeric(col) {
                    throw new \InvalidArgumentException("Element at row " . i . ", column " . j . " is not a number", Matrix::ERR_NOT_A_NUMBER);
                }
            }
        }
        return [rowCount, columnCount];
    }
}