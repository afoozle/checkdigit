<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Algorithm;

/**
 * Luhn Check Digit Algorithm
 * @see http://pointil.com/resources/mod.htm
 * @see http://www.pgrocer.net/Cis51/mod11.html
 */
class WeightedModulo implements AlgorithmInterface
{
    /**
     * @var int the Modulous to use for validating
     */
    protected $_modulous;

    /**
     * @var array The weighting values to use
     */
    protected $_weightFactors;

    /*
        Tax File Number weightings: array(1,4,3,7,5,8,6,9,10)
    */

    public function __construct($modulous, array $weightFactors) {
        $this->_modulous = (int)$modulous;
        $this->_weightFactors = $weightFactors;
    }

    /**
     * Generate the Weighted Modulo checkdigit from a partial number
     *
     * @param $partial string The partial to generate the digit for
     *
     * @return mixed The checkDigit
     */
    public function generateCheckDigit($partial) {
        $total = 0;
        for ($i=strlen($partial)-1;$i>=0;$i--) {
            $total += $partial[$i] * $this->_weightFactors[$i+2];
        }

        return $this->_modulous - ($total % $this->_modulous);
    }

    /**
     * Check that a digit is valid for this algorithm
     *
     * @param $num string The full string to validate including checkdigit
     *
     * @return bool
     */
    public function isCheckDigitValid($num) {
        $total = 0;
        for ($i = 0; $i < strlen($num); $i++) {
            $total += $num[$i] * $this->_weightFactors[$i];
        }

        if ($total % $this->_modulous !== 0) {
            return false;
        }

        return true;
    }
}