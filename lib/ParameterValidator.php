<?php

/**
 * Abstract class for EchoNest_Api classes
 *
 * @author    Brent Shaffer <bshafs at gmail dot com>
 * @license   MIT License
 */
class ParameterValidator
{
    const
        ALL  = 0,
        ARR  = 1,
        BOOL = 2,
        DEC  = 4,
        INT  = 8,
        STR  = 16;
        
    protected 
        $validation = null;

    public function __construct($validation = null)
    {
        $this->validation = $validation;
    }

    public function setValidation($validation)
    {
        $this->validation = $validation;
    }
    
    public function validate($parameters, $validation = null)
    {
        $validation = $validation ? $validation : $this->validation;

        if (!$validation) {
            return true;
        }

        foreach ($parameters as $name => $value) {
            if (!isset($validation[$name])) {
                throw new ParameterException(sprintf('Parameter name "%s" is not supported by this function', $name));
            }
            
            $supportedTypes = $validation[$name];
            
            if (is_array($supportedTypes) && is_array($value)) {
                $this->validate($value, $supportedTypes);
                continue;
            }
            
            if ($supportedTypes & self::ALL) {
                continue;
            }
            
            if ($supportedTypes & self::ARR && is_array($value)) {
                continue;
            }
            
            if ($supportedTypes & self::BOOL && is_bool($value)) {
                continue;
            }
            
            if ($supportedTypes & self::DEC && $this->checkDec($value)) {
                continue;
            }
            
            if ($supportedTypes & self::INT && $this->checkInt($value)) {
                continue;
            }
            
            if ($supportedTypes & self::STR && is_string($value)) {
                continue;
            }
            
            throw new ParameterException($name, $value, $supportedTypes);
        }
        
        return true;
    }
    
    protected function checkInt($value)
    {
        if (is_int($value)) {
            return true;
        }
        
        if ($value == '0') {
            return true;
        }
        
        if (intval($value)) {
            return true;
        }

        return false;
    }
    
    protected function checkDec($value)
    {
        if(is_numeric($value)) {
            return true;
        }
        
        if ($value == '0') {
            return true;
        }
        
        if (floatval($value)) {
            return true;
        }

        return false;
    }
}
