<?php

function isPrime($number) {
    for ($i = 2; $i < $number; $i++) 
        if ($number % $i == 0)
            return false;
    return true;
}

function sumDigits($number) {
    $sum = 0;

    while ($number > 0) {
        $sum += $number % 10;
        $number = $number / 10;
    }
    return $sum;
}

$counter = 0;
for ($i = 2; $i < 1000; $i++) {
    if (isPrime($i)) {
        $primes[$counter] = $i;
        $digits[$counter] = sumDigits($i);
        $counter++;
    }
}

$result = array();

for ($i = 2; $i < count($primes); $i++) 
    $result[$primes[$i]] = $digits[$i];

asort($result);

foreach($result as $primes => $digits) 
	echo "Vsota števka praštevila $primes je $digits. \n";