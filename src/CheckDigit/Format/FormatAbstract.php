<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Format;

abstract class FormatAbstract implements FormatInterface
{
    abstract protected function filter($value);

    abstract protected function validateFormat($value);

    abstract protected function valdidateAlgorithm($value);

    protected $_errors = array();

    /**
     * Validate the provided value
     *
     * @param string $abn
     *
     * @return bool Whether validation succeeded or not
     */
    public function validate($value) {
        $this->clearErrors();

        $value = $this->filter($value);

        if (!$this->validateFormat($value)) {
            return false;
        }

        if (!$this->valdidateAlgorithm($value)) {
            return false;
        }

        return true;
    }

    /**
     * Return any errors on the error stack
     * @return array The array of errors
     */
    public function getErrors() {
        return $this->_errors;
    }

    /**
     * Clear errors from the error stack
     */
    protected function clearErrors() {
        $this->_errors = array();
    }

    /**
     * Return whether there are any errors on the error stack
     *
     * @return bool
     */
    public function hasErrors() {
        return count($this->_errors) > 0;
    }

    /**
     * Add an error to the array of errors
     *
     * @param string $userErrorString
     * @param string $developerErrorString
     */
    protected function addError($userErrorString, $developerErrorString = null) {
        if ($developerErrorString === null) {
            $developerErrorString = $userErrorString;
        }

        $this->_errors[] = array('user'      => trim($userErrorString),
                                 'developer' => trim($developerErrorString)
        );
    }
}