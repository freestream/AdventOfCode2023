<?php
$fp = fopen('input', 'r');
$a = 0;
$b = 0;
$bRows = [];

while (false !== ($line = fgets($fp))) {
    preg_match('/^\w+\s+(\d+):\s+(.*)\|\s(.*)$/', trim($line), $matches);
    $card = trim($matches[1]);
    $winners = explode(' ', str_replace('  ', ' ', trim($matches[2])));
    $numbers = explode(' ', str_replace('  ', ' ', trim($matches[3])));

    $winners = array_combine($winners, $winners);
    $numbers = array_combine($numbers, $numbers);
    $tickets = array_intersect_key($numbers, $winners);
    $score = 0;

    for ($i=1; $i <= count($tickets); $i++) {
        if (0 === $score) {
            $score = 1;
        } else {
            $score *= 2;
        }
    }

    $bRows[$card] = [
        'tickets' => count($tickets),
        'copies' => 1,
    ];

    $a += $score;
}

for ($i = array_key_first($bRows); $i < array_key_last($bRows); $i++) {
    $data = $bRows[$i];

    for ($j=1; $j <= $data['copies'] ; $j++) {
        for ($k=$i+1; $k < ($i + 1 + $data['tickets']) ; $k++) {
            if (isset($bRows[$k])) {
                $bRows[$k]['copies'] = $bRows[$k]['copies'] + 1;
            }
        }
    }
}

foreach ($bRows as $card => $data) {
    $b += $data['copies'];
}

echo "The score of the total points is {$a} and you will end up with {$b} copies\n";
