<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Format;
use CheckDigit\Algorithm\Luhn;

/**
 * Credit Card Validator
 */
class CreditCard extends FormatAbstract implements FormatInterface
{
    const ALL = PHP_INT_MAX;

    const VISA = 1;
    const MASTERCARD = 2;
    const AMERICAN_EXPRESS = 4;
    const UNIONPAY = 8;
    const DINERS_CLUB_CARTEBLANCHE = 16;
    const DINERS_CLUB_INTERNATIONAL = 32;
    const DISCOVER = 64;
    const JCB = 128;
    const MAESTRO = 256;
    const LASER = 512;
    const DANKORT = 1024;

    /**
     * US Diners club cards are treated as Mastercards
     */
    const DINERS_CLUB_US = self::MASTERCARD;

    /**
     * @var array Credit Card Prefixes for validation
     */
    private $cardPrefixes = array(
        self::VISA                      => array('4'),
        self::MASTERCARD                => array('51', '52', '53', '54', '55'),
        self::AMERICAN_EXPRESS          => array('34', '37'),
        self::UNIONPAY                  => array(
            '622126', '622127', '622128', '622129', '62213', '62214',
            '62215', '62216', '62217', '62218', '62219', '6222', '6223',
            '6224', '6225', '6226', '6227', '6228', '62290', '62291',
            '622920', '622921', '622922', '622923', '622924', '622925'
        ),
        self::DINERS_CLUB_CARTEBLANCHE  => array('300', '301', '302', '303', '304', '305'),
        self::DINERS_CLUB_INTERNATIONAL => array('36'),
        self::DISCOVER                  => array(
            '6011', '622126', '622127', '622128', '622129', '62213',
            '62214', '62215', '62216', '62217', '62218', '62219',
            '6222', '6223', '6224', '6225', '6226', '6227', '6228',
            '62290', '62291', '622920', '622921', '622922', '622923',
            '622924', '622925', '644', '645', '646', '647', '648',
            '649', '65'
        ),
        self::JCB                       => array('3528', '3529', '353', '354', '355', '356', '357', '358'),
        self::MAESTRO                   => array('5018', '5020', '5038', '6304', '6759', '6761', '6763'),
        self::LASER                     => array('6304', '6706', '6771', '6709'),
        self::DANKORT                   => array('5019')
    );

    /**
     * @var array Credit Card lengths for validation
     */
    private $cardLengths = array(
        self::AMERICAN_EXPRESS          => array(15),
        self::DINERS_CLUB_CARTEBLANCHE  => array(14),
        self::DINERS_CLUB_INTERNATIONAL => array(16),
        self::DISCOVER                  => array(16),
        self::JCB                       => array(16),
        self::LASER                     => array(16, 17, 18, 19),
        self::MAESTRO                   => array(12, 13, 14, 15, 16, 17, 18, 19),
        self::MASTERCARD                => array(16),
        self::UNIONPAY                  => array(16, 17, 18, 19),
        self::VISA                      => array(13, 16),
        self::DANKORT                   => array(16),
    );

    /**
     * @var int The bitmask of allowed card types
     */
    private $allowedCardTypes = self::ALL;

    /**
     * Set the types of credit cards to validate
     *
     * @param array|int $cardTypes The array or bitmask of allowed card types to validate for
     */
    public function setAllowedCardTypes($cardTypes) {
        if (is_array($cardTypes)) {
            $bitflag = 0;
            foreach ($cardTypes as $typeValue) {
                $bitflag = $bitflag | (int)$typeValue;
            }
        }
        else {
            $bitflag = (int)$cardTypes;
        }
        $this->allowedCardTypes = $bitflag;
    }

    /**
     * @param string $value
     */
    protected function filter($value) {
        return preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Validate the Credit Card Format
     *
     * @param string $value
     *
     * @return bool
     */
    protected function validateFormat($value) {

        // Work out the Card Format and check against allowed types
        $cardType = $this->getCardFormat($value);
        if ($cardType === false) {
            // Unrecognised Card Type
            return true;
        }

        if (($cardType & $this->allowedCardTypes) === 0) {
            $this->addError("Credit Card Type is not allowed");
            return false;
        }

        // Check the length of the string against the allowed lengths for this format
        if (!in_array(strlen($value), $this->cardLengths[$cardType])) {
            return false;
        }
        return true;
    }

    /**
     * Determine the type of credit card being used
     *
     * @param string $value The credit card number to check
     *
     * @return int Bitflag for the card type detected
     */
    protected function getCardFormat($value) {
        foreach ($this->cardPrefixes as $cardType => $prefixes) {
            foreach ($prefixes as $prefix) {
                if ($prefix == substr($value, 0, strlen($prefix))) {
                    return $cardType;
                }
            }
        }
        return false;
    }

    /**
     * Validate the checkdigit on the credit card
     *
     * @param string $value
     *
     * @return bool
     */
    protected function validateAlgorithm($value) {
        $algorithm = new Luhn();
        if (!$algorithm->isCheckDigitValid($value)) {
            $this->addError("Credit Card failed Check Digit Validation");
            return false;
        }
        return true;
    }
}
