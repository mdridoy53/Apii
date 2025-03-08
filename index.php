<?php
function generateCardNumber($bin) {
    $number = $bin . str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT);
    
    // Luhn Algorithm Checksum
    $sum = 0;
    $alt = false;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
        $n = (int)$number[$i];
        if ($alt) {
            $n *= 2;
            if ($n > 9) {
                $n -= 9;
            }
        }
        $sum += $n;
        $alt = !$alt;
    }
    
    $checkDigit = (10 - ($sum % 10)) % 10;
    return $number . $checkDigit;
}

if (isset($_GET['bin'])) {
    $bin = preg_replace('/\D/', '', $_GET['bin']); // Remove non-numeric characters
    if (strlen($bin) < 6) {
        die("Invalid BIN.");
    }
    $cardNumber = generateCardNumber($bin);
    $expMonth = str_pad(mt_rand(1, 12), 2, '0', STR_PAD_LEFT);
    $expYear = date("Y") + mt_rand(2, 5);
    $cvv = mt_rand(100, 999);

    echo "Card Generated: $cardNumber|$expMonth|$expYear|$cvv";
} else {
    echo "Usage: localhost/cardgen.php?bin=402766";
}
?>
