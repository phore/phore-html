<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 31.10.18
 * Time: 16:20
 */

namespace Phore\Html\Tests\Integration;


use PHPUnit\Framework\TestCase;

class QueryingElementsTest extends TestCase
{


    public function testQueryIdElements ()
    {
        $doc = fhtml([
                "html @id=ccd" => [
                    "div @id=abc" => FE
                ]
            ]
        );

        $this->assertEquals("div", $doc->query("#abc")->getNode()->getTag());
        $this->assertEquals("div", $doc["?#abc"]->getNode()->getTag());
    }

    public function testQueryIdOnAddedTemplate()
    {
        $doc = fhtml("div");
        $doc[] = [
            "p @id=abc" => "x"
        ];

        $this->assertEquals(
            "p",
            $doc["?#abc"]->getNode()->getTag()
        );
    }


    public function testQueryFindsSelfContainerElement()
    {
        $elem = fhtml("div @id=abc");
        $this->assertEquals(
            "div",
            $elem["?#abc"]->getNode()->getTag()
        );
    }

    public function testQueryFindsSelfSimpleElement()
    {
        $elem = fhtml("img @id=abc");
        $this->assertEquals(
            "img",
            $elem["?#abc"]->getNode()->getTag()
        );
    }

    public function testIdIndexIsWorkingOnElements()
    {
        $elem = fhtml("div");
        $elem[] = fhtml("div @id=abc");

        $this->assertEquals(
            "div",
            $elem["?#abc"]->getNode()->getTag()
        );
    }


}


