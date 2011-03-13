<?php

/**
 * Parameter Validation Error
 *
 * @author    Brent Shaffer <bshafs at gmail dot com>
 * @license   MIT License
 */
class ParameterException extends Exception
{
    /**
     * Http header-codes
     * @var  array
     */
    static protected $parameterTypes = array(
        ParameterValidator::ARR   => 'array',
        ParameterValidator::BOOL  => 'boolean',
        ParameterValidator::DEC   => 'decimal',
        ParameterValidator::INT   => 'integer',
        ParameterValidator::STR   => 'string',
    );

    /**
     * Default constructor
     *
     * @param  string $message
     * @param  mixed $value
     * @param  int $code
     */
    public function __construct($message, $value = null, $code = null)
    {
        $supportedTypes = array();
        
        if ($value && $code) {
            foreach (self::$parameterTypes as $typeCode => $typeString) {
                if ($code & $typeCode) {
                    $supportedTypes[] = $typeString;
                }
            }
        }

        $message = sprintf('Parameter %s is not of proper type. "%s" provided, expected %s.', $message, $value, implode(' or ', $supportedTypes));

        parent::__construct($message);
    }
}