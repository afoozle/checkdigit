<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Algorithm;

class WeightedModuloTest extends \PHPUnit_Framework_testCase
{

    private $weightFactors89 = array(10, 1, 3, 5, 7, 9, 11, 13, 15, 17, 19);

    public function generateCheckDigitProvider()
    {
        return array(
            array(89, $this->weightFactors89, "004085616", 43),
            array(89, $this->weightFactors89, "426324856", 50),
            array(89, $this->weightFactors89, "828158638", 72),
            array(89, $this->weightFactors89, "987100472", 14),
            array(89, $this->weightFactors89, "752144492", 29),
        );
    }

    /**
     * @dataProvider generateCheckDigitProvider
     */
    public function testGenerateCheckDigit($modulous, array $weightFactors, $partial, $expectedResult) {
        $algorithm = new WeightedModulo($modulous, $weightFactors);
        $this->assertEquals($expectedResult, $algorithm->generateCheckDigit($partial));
    }

    /**
     * Data Provider for testing isCheckDigitValid
     */
    public function isCheckDigitValidProvider() {
        return array(
            array(89, $this->weightFactors89, "43004085616", true),
            array(89, $this->weightFactors89, "50426324856", true),
            array(89, $this->weightFactors89, "72828158638", true),
            array(89, $this->weightFactors89, "14987100472", true),
            array(89, $this->weightFactors89, "29752144492", true),
        );
    }

    /**
     * @dataProvider isCheckDigitValidProvider
     */
    public function testIsCheckDigitValid($modulus, array $weightFactors, $testValue, $expectedResult) {
        $algorithm = new WeightedModulo($modulus, $weightFactors);
        $this->assertEquals($expectedResult, $algorithm->isCheckDigitValid($testValue));
    }
}