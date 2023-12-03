<?php
$fp = fopen('input', 'r');
$aAll = [];
$bAll = [];

while (false !== ($line = fgets($fp))) {
    $newLine = str_replace(['one', 'two', 'three', 'four', 'five',
    'six', 'seven', 'eight', 'nine'],
    ['one1one', 'two2two', 'three3three', 'four4four', 'five5five', 'six6six', 'seven7seven', 'eight8eight', 'nine9nine'], trim($line));

    $aNumbers = preg_replace('/[\D]/', '', trim($line));
    $bNumbers = preg_replace('/[\D]/', '', $newLine);

    $aNumbers = $aNumbers[0] . $aNumbers[strlen($aNumbers) - 1];
    $bNumbers = $bNumbers[0] . $bNumbers[strlen($bNumbers) - 1];

    $aAll[] = $aNumbers;
    $bAll[] = $bNumbers;
}

$aAll = array_sum($aAll);
$bAll = array_sum($bAll);

echo "By only counting the numbers, the calibration values is {$aAll}. But, by chaning the spelled out numbers into numbers the calibration values is {$bAll}" . "\n";

