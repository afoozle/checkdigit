<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Algorithm;

/**
 * Interface for all Check Digit Algorithms
 */
interface AlgorithmInterface
{
    /**
     * Generate the checkdigit for a partial number
     *
     * @param $num string The partial to generate the digit for
     *
     * @return mixed The checkDigit
     */
    public function generateCheckDigit($num);

    /**
     * Check that a digit is valid for this algorithm
     *
     * @param $num string The full string to validate including checkdigit
     *
     * @return bool
     */
    public function isCheckDigitValid($num);
}