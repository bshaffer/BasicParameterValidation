<?php

class ParameterValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException ParameterException
     */
    public function testGetRequestIntegerWithInvalidStringParameterThrowsException()
    {
        $validator = $this->getValidatorMock();
      
        $validator->getWithInteger('This is not an integer');
    }

    public function testGetRequesIntegertWithStringIntegerParameter()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithInteger('15');
      
        $this->assertEquals(true, $response);
    }

    public function testGetRequestIntegerWithIntegerParameter()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithInteger(15);
      
        $this->assertEquals(true, $response);
    }

    public function testGetRequestBooleanWithBooleanParameter()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithBoolean(true);
      
        $this->assertEquals(true, $response);
    }
    
    /**
     * @expectedException ParameterException
     */
    public function testGetRequestBooleanWithStringParameterThrowsException()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithBoolean('This is not a boolean');
      
        $this->assertEquals(true, $response);
    }

    public function testGetRequestArrayWithArrayParameter()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithArray(array('key' => 'value'));
      
        $this->assertEquals(true, $response);
    }

    /**
     * @expectedException ParameterException
     */
    public function testGetRequestArrayWithStringParameterThrowsException()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithArray('string');
      
        $this->assertEquals(true, $response);
    }

    public function testGetRequestArrayOrStringWithArrayParameter()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithArrayOrString(array('key' => 'value'));
        
        $this->assertEquals(true, $response);
    }

    /**
     * @expectedException ParameterException
     */
    public function testGetRequestArrayOrStringWithIntegerParameterThrowsException()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithArrayOrString(15);
    }

    public function testGetRequestDecimalWithDecimalParameter()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithDecimal(1.2);
      
        $this->assertEquals(true, $response);
    }
    
    public function testGetRequestDecimalWithStringDecimalParameter()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithDecimal('1.2');
      
        $this->assertEquals(true, $response);
    }
    
    /**
     * @expectedException ParameterException
     */
    public function testGetRequestDecimalWithStringParameterThrowsException()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithDecimal('This is not a decimal');
    }
    
    public function testGetRequestOptionsWithCorrectParameterTypes()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithOptions(array('integer' => 1, 'string' => 'string'));
      
        $this->assertEquals(true, $response);
    }
    
    /**
     * @expectedException ParameterException
     */
    public function testGetRequestOptionsWithIncorrectParameterTypeThrowsException()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithOptions(array('integer' => 'This is not an integer', 'string' => 'string'));
    }
    
    /**
     * @expectedException ParameterException
     */
    public function testGetRequestOptionsWithInvalidParameterThrowsException()
    {
        $validator = $this->getValidatorMock();
      
        $response = $validator->getWithOptions(array('integer' => 2, 'string' => 'string', 'extra_parameter' => true));
    }
    
    protected function getValidatorMock()
    {
        return new ValidatorMock();
    }
}

/**
* 
*/
class ValidatorMock extends ParameterValidator
{
    public function getWithInteger($integer)
    {
        $this->setValidation(array('integer' => self::INT));

        return $this->validate(array('integer' => $integer));
    }
    
    public function getWithArray($array)
    {
        $this->setValidation(array('array' => self::ARR));

        return $this->validate(array('array' => $array));
    }
    
    public function getWithArrayOrString($array_or_string)
    {
        $this->setValidation(array('array_or_string' => self::ARR | self::STR));

        return $this->validate(array('array_or_string' => $array_or_string));
    }
    
    
    public function getWithBoolean($boolean)
    {
        $this->setValidation(array('boolean' => self::BOOL));

        return $this->validate(array('boolean' => $boolean));
    }
    
    
    public function getWithDecimal($decimal)
    {
        $this->setValidation(array('decimal' => self::DEC));

        return $this->validate(array('decimal' => $decimal));
    }
    
    public function getWithOptions($options)
    {
        $this->setValidation(array('options' => array('integer' => self::INT, 'string' => self::STR)));

        return $this->validate(array('options' => $options));
    }
}

