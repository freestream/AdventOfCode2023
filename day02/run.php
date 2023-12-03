<?php
$fp = fopen('input', 'r');
$a = [];
$b = [];

while (false !== ($line = fgets($fp))) {
    preg_match_all('/^Game\s(\d+)|(\d+)\s(\w+)+/m', trim($line), $matches, PREG_SET_ORDER, 0);

    $game = $matches[0][1];
    $cubes = [];

    unset($matches[0]);

    $control = [
        'red' => 12,
        'green' => 13,
        'blue' => 14
    ];

    foreach ($matches as $match) {
        $number = $match[2];
        $color = $match[3];

        if (!isset($cubes[$color])) {
            $cubes[$color] = 0;
        }

        $cubes[$color] = max($cubes[$color], $number);
    }

    $valid = true;

    foreach ($control as $c => $v) {
        if (isset($cubes[$c]) && $cubes[$c] > $v) {
            $valid = false;
        }
    }

    $b[] = array_product($cubes);

    if (true === $valid) {
        $a[] = $game;
    }
}

echo array_sum($a) . "\n";
echo array_sum($b) . "\n";
