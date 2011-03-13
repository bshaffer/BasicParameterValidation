# Basic Parameter Validator

## Overview

What it sounds like.  A very simple validation library.  Validates the following types:

 * integers
 * decimals / floats
 * strings
 * booleans
 * arrays
 * nested arrays
 * any combination of the above

## Usage

Instantiate a validator with your schema using the class constants

    $validator = new ParameterValidator(array('I Require A String' => ParameterValidator::STR, 'I Require An Array' => ParameterValidator::ARR));

Use the valiate function to validate an array of parameters

    // this will return true
    $validator->validate(array('I Require A String' => 'a string', 'I Require An Array' => array('an array')));

    // this will throw a ParameterException
    $validator->validate(array('I Require A String' => 'a string', 'I Require An Array' => 'Not an array')));

    // so will this
    $validator->validate(array('I do not exist' => true));

### Combining Types

Pipe validator constants together to accept multiple types of parameters

    $validator = new ParameterValidator(array('I Require A Decimal Or Array' => ParameterValidator::ARR|ParameterValidator::DEC));

    // This will pass
    $validator->validate(array('I Require A Decimal Or Array' => 3.14159));
    
    // So will this
    $validator->validate(array('I Require A Decimal Or Array' => array('why would something ever need to accept a decimal or array?')));

### Nest That Shiznit

    $validator = new ParameterValidator(array('options' => array('name' => ParameterValidator::STR, 'age' => ParameterValidator::INT)));

    // This will pass
    $validator->validate(array('options' => array('name' => 'Brent Shaffer', 'age' => 25)));

    // This will not
    $validator->validate(array('options' => array('name' => 'Brent Shaffer', 'age' => "Like I'd ever tell you!")));

    // Nor will this
    $validator->validate(array('options' => array('name' => 'Brent Shaffer', 'age' => 25, 'looks' => 'very young for my age')));

## TODO

Add Required, Add Enums, ETC

