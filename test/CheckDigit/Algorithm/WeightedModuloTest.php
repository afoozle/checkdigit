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

    /**
     * Data Provider for testing isCheckDigitValid
     */
    public function isCheckDigitValidProvider() {
        return array(
            array(89, $this->weightFactors89, "43004085616", true),
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