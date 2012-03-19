<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Algorithm;

/**
 * Luhn Check Digit Algorithm
 * @see http://en.wikipedia.org/wiki/Luhn_algorithm
 */
class Luhn implements AlgorithmInterface
{
    /**
     * Generate the Luhn checkdigit for a partial number
     *
     * @param $partial string The partial to generate the digit for
     *
     * @return mixed The checkDigit
     */
    public function generateCheckDigit($partial) {
        settype($partial,"string");

        $revPartial = strrev($partial);
        $total = 0;
        for ($i=0;$i<strlen($revPartial);$i++) {

            $digit = $revPartial[$i];

            if ($i %2 == 0) {
                $total += ($digit >= 5) ? $digit*2-9 : $digit*2;
            }
            else {
                $total += $digit;
            }
        }

        $checkDigit = 10 - ($total % 10);
        // 10 is a special case, return zero...
        return $checkDigit == 10 ? 0 : $checkDigit;
    }

    /**
     * Check that a digit is valid for this algorithm
     *
     * @param $num string The full string to validate including checkdigit
     *
     * @return bool
     */
    public function isCheckDigitValid($num) {
        settype($num,"string");

        $checkDigit = substr($num,-1);
        $partial = substr($num,0,-1);
        return $checkDigit == $this->generateCheckDigit($partial);
    }
}