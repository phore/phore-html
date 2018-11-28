<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 31.10.18
 * Time: 16:29
 */

namespace Phore\Html\Tests\Integration;


use PHPUnit\Framework\TestCase;

class AlterElementsTest extends TestCase
{

    public function testAlterElements()
    {
        $doc = fhtml("div");
        $doc[] = fhtml("p @id=abc @a @b");

        $doc["?#abc"]->alter("@class=-b +c");

        $this->assertEquals('<div><p id="abc" class="a c"></p></div>', $doc->render(false));
    }


    public function testRemoveElements()
    {
        $doc = fhtml("div");
        $doc[] = fhtml(["p @id=abc" => ["p" => "text"]]);

        $doc["?#abc"]->clear();

        $this->assertEquals('<div><p id="abc"></p></div>', $doc->render(false));
    }

}