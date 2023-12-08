<?php
$fp = fopen('input', 'r');
$a = null;
$b = 0;

$aSeeds = [];
$bSeeds = [];
$maps = [];
$collection = [];

while (false !== ($line = fgets($fp))) {
    if (preg_match('/^seeds:\s(.*)$/', trim($line), $matches)) {
        $aSeeds = explode(' ', $matches[1]);
        $bSeeds = array_chunk(array_values($aSeeds), 2);
    } else if (preg_match('/^(\w+)-to-(\w+)\smap:$/', trim($line), $matches)) {
        $mapFrom = $matches[1];
        $mapTo = $matches[2];
        $key = $matches[1] . '#' . $matches[2];

        $collection[$key] = [];
    } else if (preg_match('/^(\d+)\s(\d+)\s(\d+)$/', trim($line), $matches)) {
        $collection[$key][] = [$matches[1], $matches[2], $matches[3]];
    }
}

function getLocation(int $nr, array $collection) : int {
    foreach ($collection as $list) {
        foreach ($list as $data) {
            list($d, $s, $l) = $data;

            if ($nr >= $s && $nr <= ($s + $l - 1)) {
                $nr = $d + ($nr - $s);
                break;
            }
        }
    }

    return $nr;
}

function getSeed(int $nr, array $collection, array $seeds) :? int {
    foreach (array_reverse($collection) as $list) {
        foreach ($list as $data) {
            list($d, $s, $l) = $data;

            if ($nr >= $d && $nr <= ($d + $l - 1)) {
                $nr = $s + ($nr - $d);
                break;
            }
        }
    }

    foreach ($seeds as $chunk) {
        list($s, $l) = $chunk;

        if ($nr >= $s && $nr <= ($s + $l - 1)) {
            return $nr;
            break;
        }
    }

    return null;
}

foreach ($aSeeds as $seed) {
    if (null === $a) {
        $a = getLocation($seed, $collection);
    } else {
        $a = min($a, getLocation($seed, $collection));
    }
}

$n = null;
while ($n == null) {
    $b++;
    $n = getSeed($b, $collection, $bSeeds);
}

echo "In the initial seed numbers the lowest location number is {$a} and with a range of seed numbers the lowest location number is {$b}\n";
