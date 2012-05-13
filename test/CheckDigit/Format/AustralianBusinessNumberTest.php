<?php
/**
 * @author    Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license   MIT - See LICENSE file supplied with this source code
 */
namespace CheckDigit\Format;

class AustralianBusinessNumberTest extends \PHPUnit_Framework_TestCase
{
    public function testValidNumber() {
        $validator = new AustralianBusinessNumber();
        $this->assertEquals(true, $validator->validate("53 004 085 616"), "Example ABN should pass validation");
        $this->assertEquals(array(), $validator->getErrors());
    }
}
