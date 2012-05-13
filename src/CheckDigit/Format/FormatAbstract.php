<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Format;

abstract class FormatAbstract implements FormatInterface
{
    /**
     * @var array the error stack for this format validator
     */
    protected $errors = array();

    /**
     * @abstract
     * @param $value
     */
    abstract protected function filter($value);

    abstract protected function validateFormat($value);

    abstract protected function validateAlgorithm($value);

    /**
     * Constructor
     * @param array|null $options
     */
    public function __construct(array $options = null) {
        if ($options !== null && count($options)) {
            $this->setOptions($options);
        }
    }
    
    /**
     * Iterate and set the options provided
     * @param array $options
     */
    public function setOptions(array $options) {
        foreach($options as $optionName => $optionValue) {
            $optionMethod = sprintf('set%s',$optionName);
            
            if (method_exists($this, $optionMethod) && is_callable(array($this,$optionMethod))) {
                throw new \InvalidArgumentException("Invalid option $optionName");
            }
            
            call_user_func(array($this, $optionMethod));
        }
    }

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

        if (!$this->validateAlgorithm($value)) {
            return false;
        }

        return true;
    }

    /**
     * Return any errors on the error stack
     * @return array The array of errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Clear errors from the error stack
     */
    protected function clearErrors() {
        $this->errors = array();
    }

    /**
     * Return whether there are any errors on the error stack
     *
     * @return bool
     */
    public function hasErrors() {
        return count($this->errors) > 0;
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

        $this->errors[] = array('user'      => trim($userErrorString),
                                 'developer' => trim($developerErrorString)
        );
    }
}