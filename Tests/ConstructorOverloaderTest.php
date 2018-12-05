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


    public function testMethod()
    {
        $obj = $this->arbitraryObject();
        $this->assertEquals(2);
    }

    private function arbitraryObject()
    {
        $overloader = new ConstructorOverloader();
        return new class
        {
            private function __construct1(int $a)
            {
                return $this->__construct2($a, 2.2);
            }

            private function __construct2(int $a, float $b)
            {
                return 2;
            }

            public function __construct(ConstructorOverloader $overloader, ...$args)
            {
                return $overloader->construct($this, $args);
            }
        };
    }


}
