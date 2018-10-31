<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 31.10.18
 * Time: 15:51
 */

namespace Phore\Html\Tests\Integration;


use PHPUnit\Framework\TestCase;

class CreatingElementsTest extends TestCase
{


    public function testCreateDocument()
    {
        $doc = fhtml();
        $doc->elem("div @cssClass @class=cssClass2");

        $this->assertEquals("<div class=\"cssClass cssClass2\"></div>", $doc->render(false));

        $doc = fhtml("div @cssClass");
        $this->assertEquals('<div class="cssClass"></div>',$doc->render(false));
    }


    public function testAppendToDocument ()
    {
        $doc = fhtml("div");
        $doc[] = fhtml("p");
        $doc[] = fhtml("p");

        $this->assertEquals('<div><p></p><p></p></div>', $doc->render(false));
    }


}