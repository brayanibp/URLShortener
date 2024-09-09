<?php

/**
 * Summary of base62_encode
 * Recieves a Dec secuency and Return a Base62 encoded number
 * @param int|float $num
 * @return string
 */
function base62_encode(int|float $num) {
    // characters for base62 encoding
    $chars =
        // lowercase letters
        "abcdefghijklmnopqrstuvwyxz"
        // uppercase letters
        . "ABCDEFGHIJKLMNOPQRSTUVWYXZ"
        // numeric characters
        . "0123456789";

    // defining constant value
    $characters_length = 62;

    // if there came a empty value
    // return the first character
    // of the character set
    if (empty($num)) {
        return $chars[0];
    }

    // default enconding value
    // as an empty string
    $encoding = '';

    // while rounded integer value keeps higher than 0
    // then keep processing
    while ($num > 0) {
        // taking the remainder value of the division
        $remainder = $num % $characters_length;

        // int division result
        $num = floor((float) ($num / $characters_length));

        // getting the character from the character set
        // based on the remainder value
        // and concatenating with the encoding
        $encoding = $chars[$remainder] . $encoding;
    }

    // returns base 62 result
    return $encoding;
}
