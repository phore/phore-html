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
        $doc->elem("p @id=abc @a @b");

        $doc->query("#abc")->alter("@class=-b +c");

        $this->assertEquals('<div><p id="abc" class="a c"></p></div>', $doc->render(false));
    }

}