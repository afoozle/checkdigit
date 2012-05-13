<?php
/**
 *
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 */
namespace CheckDigit\Format;

/**
 * Interface for all CheckDigit Format classes
 */
interface FormatInterface
{
    /**
     * Iterate and set the options for the Format Validator
     *
     * @param array $options An array of options to set
     */
    public function setOptions(array $options);

    /**
     * Validate a value in this format
     *
     * @param string $value The value to validate
     *
     * @abstract
     * @return bool Whether it validated correctly
     */
    public function validate($value);

    /**
     * Return whether any errors exist after validation
     *
     * @abstract
     * @return bool Whether any errors exist
     */
    public function hasErrors();

    /**
     * Return any error messages from the validator
     *
     * @abstract
     * @return array The error stack
     */
    public function getErrors();
}