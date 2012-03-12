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