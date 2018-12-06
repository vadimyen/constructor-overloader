<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 05.12.2018
 * Time: 11:38
 */

namespace Tests;


use PHPUnit\Framework\TestCase;
use Vadimyen\ConstructorOverloader;

class ConstructorOverloaderTest extends TestCase
{

    public function testWithoutParameters()
    {
        $obj = $this->arbitraryObject();
        $this->assertTrue($obj->flag);
    }

    public function testWithOneParameter()
    {
        $obj = $this->arbitraryObject([1]);
        $this->assertTrue($obj->flag);
    }

    public function testWithTwoParameters()
    {
        $obj = $this->arbitraryObject([1, 2.3]);
        $this->assertTrue($obj->flag);
    }

    public function testWithNonexistentConstructor()
    {
        $this->expectException(\InvalidArgumentException::class);
        $obj = $this->arbitraryObject([1, 2.3, 12]);
    }

    public function testWithNotObject()
    {
        $this->expectException(\TypeError::class);
        $overloader = new ConstructorOverloader();
        $overloader->construct(1, []);
    }

    public function testWithNotValidSecondArgument()
    {
        $this->expectException(\TypeError::class);
        $overloader = new ConstructorOverloader();
        $overloader->construct($this->arbitraryObject(), 2);
    }

    private function arbitraryObject(array $args = array())
    {
        return new class(...$args)
        {
            private $overloader;
            public $flag = false;

            private function __construct0()
            {
                $this->__construct(1);
            }

            private function __construct1(int $a)
            {
                $this->__construct($a, 2.2);
            }

            private function __construct2(int $a, float $b)
            {
                $this->flag = true;
            }

            public function __construct(...$args)
            {
                $this->overloader = $this->overloader ?? new ConstructorOverloader();
                return $this->overloader->construct($this, $args);
            }
        };
    }


}
