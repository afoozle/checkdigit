<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Format;
use CheckDigit\Algorithm\WeightedModulo;

class AustralianBusinessNumber extends FormatAbstract implements FormatInterface
{
    /**
     * @var array The weighting factors for use when validating
     */
    private $weightFactors = array(10, 1, 3, 5, 7, 9, 11, 13, 15, 17, 19);

    /**
     * @var int The Modulus to use in the weighting algorithm
     */
    private $weightModulus = 89;

    protected function filter($abn) {
        return preg_replace('/[^0-9]/', '', $abn);
    }

    /**
     * Validate that the basic format is correct
     *
     * @param $abn string The abn to check the format of
     */
    protected function validateFormat($abn) {
        $okay = true;

        if (strlen($abn) !== 11) {
            $this->addError("ABN should be 11 characters long");
            $okay = false;
        }

        if (!preg_match('/^[0-9]+$/', $abn)) {
            $this->addError("ABN must only contain numbers");
            $okay = false;
        }

        return $okay;
    }

    /**
     * @param $abn string The abn to validate the algorithm against
     *
     * @return bool
     */
    protected function validateAlgorithm($abn) {
        $abn[0] = $abn[0] - 1;

        $algorithm = new WeightedModulo($this->weightModulus, $this->weightFactors);

        if (!$algorithm->isCheckDigitValid($abn)) {
            $this->addError("ABN failed Check Digit validation");
            return false;
        }
        return true;
    }
}