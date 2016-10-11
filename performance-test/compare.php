<?php

$cycleCount = 1000;

$aRowCount = 10;
$aColCount = 12;
$bRowCount = 12;
$bColCount = 10;

function random_matrix($rowCount, $colCount) {
    $ret = [];
    for ($i = 0; $i < $rowCount; $i++) {
        for ($j = 0; $j < $colCount; $j++) {
            $ret[$i][$j] = rand(0, 100);
        }
    }
    return $ret;
}

$a = random_matrix($aRowCount, $aColCount);
$b = random_matrix($bRowCount, $bColCount);

function accept_input($name) {
    echo "Enter matrix $name:\n";
    $ret = [];
    while ($line = fgets(STDIN)) {
        if (!trim($line)) {
            return $ret;
        }
        $ret[] = array_map("intval", explode(" ", $line));
    }
}

//$a = accept_input("A");
//$b = accept_input("B");

$start = microtime(true);
for ($i = 0; $i < $cycleCount; $i++) $resultZephir = \Phparch\Matrix::multiply($a, $b);
$end = microtime(true);
$elapsedZephir = ceil(($end - $start) * 1000);

echo "\n";
echo "ZEPHIR: $elapsedZephir ms elapsed\n";

require_once __DIR__ . "/Matrix.php";

$start = microtime(true);
for ($i = 0; $i < $cycleCount; $i++) $resultPhp = \Matrix::multiply($a, $b);
$end = microtime(true);
$elapsedPhp = ceil(($end - $start) * 1000);
echo "PHP: $elapsedPhp ms elapsed\n";

echo "PHP implementation is " . round($elapsedPhp / $elapsedZephir, 2) . " times slower than Zephir\n";

if (!getopt("i")) exit;

echo "\n";
echo "Inputs and results:\n";

echo "Input A:\n";
\Matrix::dump($a);

echo "Input B:\n";
\Matrix::dump($b);

echo "Zephir:\n";
\Matrix::dump($resultZephir);

echo "PHP:\n";
\Matrix::dump($resultPhp);
