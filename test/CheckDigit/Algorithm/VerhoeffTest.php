<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Algorithm;

/**
 * Test Harness for \CheckDigit\Algorithm\Verhoeff
 * @see \CheckDigit\Algorithm\Verhoeff
 */
class VerhoeffTest extends \PHPUnit_Framework_testCase
{

    /**
     * Data Provider for the testGenerateCheckDigit method
     * @return array Multi dimensional array of test values and expected results
     */
    public function generateCheckDigitProvider() {
        return array(
            array("75872", 2),
            array("12345", 1),
            array("142857", 0),
            array("123456789012", 0),
            array("8473643095483728456789", 2)
        );
    }

    /**
     * @dataProvider generateCheckDigitProvider
     *
     * @param $partial       string The partial number to generate the digit for
     * @param $expectedDigit int The expected check digit
     */
    public function testGenerateCheckDigit($partial, $expectedDigit) {
        $algorithm = new Verhoeff();
        $this->assertEquals($expectedDigit, $algorithm->generateCheckDigit($partial));
    }

    public function isValidCheckDigitProvider() {
        return array(
            array("758722", true),
            array("758721", false),
            array("123451", true),
            array("123452", false),
            array("1428570", true),
            array("1428573", false),
            array("1234567890120", true),
            array("1234567890124", false),
            array("84736430954837284567892", true),
            array("84736430954837284567895", false)
        );
    }

    /**
     * @dataProvider isValidCheckDigitProvider
     * @param $num string the number to validate
     * @param $expectedResult bool whether the provided number is valid or not
     */
    public function testIsValidCheckDigit($num, $expectedResult) {
        $algorithm = new Verhoeff();
        $this->assertEquals($expectedResult, $algorithm->isCheckDigitValid($num));
    }
}