<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2012 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Algorithm;

class LuhnTest extends \PHPUnit_Framework_testCase
{
    /**
     * Data Provider for testGenerateCheckDigit
     * @return array
     */
    public function generateCheckDigitProvider() {
        return array(
            //American Express
            array("34000000000000", 9),
            array("37828224631000", 5),
            array("37144963539843", 1),
            array("37873449367100", 0),
            //Australian BankCard
            array("561059108101825", 0),
            //Carte Blanche
            array("3000000000000", 4),
            //Dankort (PBS)
            array("501971701010374", 2),
            //Diners Club
            array("3056930902590", 4),
            array("3852000002323", 7),
            array("3000000000000", 4),
            //Discover
            array("601111111111111", 7),
            array("601100099013942", 4),
            array("601100000000000", 4),
            //enRoute
            array("20140000000000", 9),
            //JCB
            array("213100000000000", 8),
            array("353011133330000", 0),
            array("356600202036050", 5),
            //MasterCard
            array("555555555555444", 4),
            array("510510510510510", 0),
            array("550000000000000", 4),
            //Switch/Solo
            array("490301000000000", 9),
            array("633110199999001", 6),
            array("633400000000000", 4),
            //Visa
            array("411111111111111", 1),
            array("401288888888188", 1),
            array("422222222222", 2),
        );
    }

    /**
     * @dataProvider generateCheckDigitProvider
     */
    public function testGenerateCheckDigit($partial, $expectedDigit) {
        $algorithm = new Luhn();
        $this->assertEquals($expectedDigit, $algorithm->generateCheckDigit($partial));
    }
    /**
     * Data Provider for testIsCheckDigitValid
     * @return array
     */
    public function isCheckDigitValidProvider() {
        return array(
            //American Express
            array("340000000000009", true),
            array("378282246310005", true),
            array("371449635398431", true),
            array("378734493671000", true),
            //Australian BankCard
            array("5610591081018250", true),
            //Carte Blanche
            array("30000000000004", true),
            //Dankort (PBS)
            array("5019717010103742", true),
            //Diners Club
            array("30569309025904", true),
            array("38520000023237", true),
            array("30000000000004", true),
            //Discover
            array("6011111111111117", true),
            array("6011000990139424", true),
            array("6011000000000004", true),
            //enRoute
            array("201400000000009", true),
            //JCB
            array("2131000000000008", true),
            array("3530111333300000", true),
            array("3566002020360505", true),
            //MasterCard
            array("5555555555554444", true),
            array("5105105105105100", true),
            array("5500000000000004", true),
            //Switch/Solo
            array("4903010000000009", true),
            array("6331101999990016", true),
            array("6334000000000004", true),
            //Visa
            array("4111111111111111", true),
            array("4012888888881881", true),
            array("4222222222222", true),
        );
    }

    /**
     * @dataProvider isCheckDigitValidProvider
     */
    public function testIsCheckDigitValid($testNumber, $expectedResult) {
        $algorithm = new Luhn();
        $this->assertEquals($expectedResult, $algorithm->isCheckDigitValid($testNumber));
    }
}
