<?php

use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    public function testMultiplicationOfTwoNumber()
    {
        $a = 10;
        $b = 5;
        $c =10 * 5;
        $this->assertEquals($c, 50);
    }

    public function testSplittingOfTwoNumber()
    {
        $d = 20;
        $e = 4;
        $f =20 / 4;
        $this->assertEquals($f, 5);
    }
}