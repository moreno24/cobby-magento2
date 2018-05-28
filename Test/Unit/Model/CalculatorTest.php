<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 14.05.18
 * Time: 11:44
 */

namespace Mash2\Cobby\Tests;

use Mash2\Cobby\Model\Calculator;
//use PHPUnit\Framework\TestCase;

/**
 * @covers Mash2\Cobby\Model\Calculator
 */
class CalculatorTest extends \PHPUnit\Framework\TestCase
{

    /**
     *
     */
    public function testAdd()
    {
        $calculator = new Calculator();

        $this->assertEquals(18, $calculator->add(6,8));
        $this->assertTrue($calculator->add(1, 1) == 6);
        $this->assertFalse($calculator->add(1, 1) == 2);
    }
}