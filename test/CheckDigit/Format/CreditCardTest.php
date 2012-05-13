<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Format;

class CreditCardTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Data Provider for testValidate
     * @return array
     */
    public function testValidateProvider() {
        return array(
            array(CreditCard::AMERICAN_EXPRESS, "340000000000009", true),
            array(CreditCard::AMERICAN_EXPRESS, "378282246310005", true),
            array(CreditCard::AMERICAN_EXPRESS, "371449635398431", true),
            array(CreditCard::AMERICAN_EXPRESS, "378734493671000", true),
            //Dankort
            array(CreditCard::DANKORT, "5019717010103742", true),
            //Diners Club
            array(CreditCard::DINERS_CLUB_CARTEBLANCHE, "30569309025904", true),
            array(CreditCard::DINERS_CLUB_CARTEBLANCHE, "30000000000004", true),
            array(CreditCard::DINERS_CLUB_CARTEBLANCHE, "30000000000004", true),
            array(CreditCard::DINERS_CLUB_INTERNATIONAL, "3600000000000008", true),
            array(CreditCard::DINERS_CLUB_US, "5400000000000005", true),
            array(CreditCard::DINERS_CLUB_US, "5600000000000003", true),
            //Discover
            array(CreditCard::DISCOVER, "6011111111111117", true),
            array(CreditCard::DISCOVER, "6011000990139424", true),
            array(CreditCard::DISCOVER, "6011000000000004", true),
            //JCB
            array(CreditCard::JCB, "2131000000000008", true),
            array(CreditCard::JCB, "3530111333300000", true),
            array(CreditCard::JCB, "3566002020360505", true),
            //MasterCard
            array(CreditCard::MASTERCARD, "5555555555554444", true),
            array(CreditCard::MASTERCARD, "5105105105105100", true),
            array(CreditCard::MASTERCARD, "5500000000000004", true),
            //Visa
            array(CreditCard::VISA, "4111111111111111", true),
            array(CreditCard::VISA, "4012888888881881", true),
            array(CreditCard::VISA, "4222222222222", true),
        );
    }

    /**
     * Test the validate function
     *
     * @param int    $cardType
     * @param string $cardNumber
     * @param bool   $isValid
     *
     * @dataProvider testValidateProvider
     */
    public function testValidate($cardType, $cardNumber, $isValid) {
        $validator = new CreditCard();
        $validator->setAllowedCardTypes($cardType);

        $validateResult = $validator->validate($cardNumber);

        if ($isValid === true) {
            $this->assertEquals(true, $validateResult, "Card Number should have passed validation: " . json_encode($validator->getErrors()));
            $this->assertEquals(array(), $validator->getErrors());
        }
        else {
            $this->assertEquals(false, $validateResult, "Card Number should not have passed validation");
            $this->assertEquals(1, count($validator->getErrors()));
        }
    }

    /**
     * Test that the allowed card types option is working properly
     *
     * @param array      $allowedCardTypes
     * @param string     $cardNumber
     * @param bool       $isValid
     */
    public function testAllowedCardTypes() {

        $validVisa = "4111111111111111";
        $validMastercard = "5555555555554444";
        $validAmex = "340000000000009";

        $validator = new CreditCard();

        // Test Allowed VISA only
        $validator->setAllowedCardTypes(CreditCard::VISA);
        $this->assertEquals(true, $validator->validate($validVisa), "Visa card should validate okay");
        $this->assertEquals(false, $validator->validate($validMastercard), "Mastercard is not in allowed card types");
        $this->assertEquals(false, $validator->validate($validAmex), "Amex is not in allowed card types");

        // Test Allowed Mastercard Only
        $validator->setAllowedCardTypes(CreditCard::MASTERCARD);
        $this->assertEquals(false, $validator->validate($validVisa), "Visa card is not in allowed card types");
        $this->assertEquals(true, $validator->validate($validMastercard), "Mastercard should validate okay");
        $this->assertEquals(false, $validator->validate($validAmex), "Amex is not in allowed card types");

        // Test Allowed Amex Only
        $validator->setAllowedCardTypes(CreditCard::AMERICAN_EXPRESS);
        $this->assertEquals(false, $validator->validate($validVisa), "Visa card is not in allowed card types");
        $this->assertEquals(false, $validator->validate($validMastercard), "Mastercard is not in allowed card types");
        $this->assertEquals(true, $validator->validate($validAmex), "Amex should validate okay");

        // Test Visa and Mastercard using bit operations
        $validator->setAllowedCardTypes(CreditCard::VISA | CreditCard::MASTERCARD);
        $this->assertEquals(true, $validator->validate($validVisa), "Visa should validate okay");
        $this->assertEquals(true, $validator->validate($validMastercard), "Mastercard should validate okay");
        $this->assertEquals(false, $validator->validate($validAmex), "Amex is not in allowed card types");

        // Test Mastercard and Amex using an array
        $validator->setAllowedCardTypes(array(CreditCard::MASTERCARD, CreditCard::AMERICAN_EXPRESS));
        $this->assertEquals(false, $validator->validate($validVisa), "Visa is not in allowed card type");
        $this->assertEquals(true, $validator->validate($validMastercard), "Mastercard should validate okay");
        $this->assertEquals(true, $validator->validate($validAmex), "Amex should validate okay");

        // Check ALL
        $validator->setAllowedCardTypes(CreditCard::ALL);
        $this->assertEquals(true, $validator->validate($validVisa), "Visa should validate okay");
        $this->assertEquals(true, $validator->validate($validMastercard), "Mastercard should validate okay");
        $this->assertEquals(true, $validator->validate($validAmex), "Amex should validate okay");
    }
}