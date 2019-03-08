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
        $doc = fhtml("div @cssClass @class=cssClass2");
        $this->assertEquals("<div class=\"cssClass cssClass2\"></div>", $doc->render(false));

        $doc = fhtml("div @cssClass");
        $this->assertEquals('<div class="cssClass"></div>',$doc->render(false));
    }

    public function testTemplate ()
    {
        $doc = fhtml([
            "html" => [
                "p" => "abc"
            ]
        ]);

        $this->assertEquals('<html><p>abc</p></html>', $doc->render(false));
    }

    public function testAppendToDocument ()
    {
        $doc = fhtml("div");
        //This wont works - will return
        $elem = (fhtml("p")[] = fhtml("img"));

        // Correct way to create
        $doc["p"][] = fhtml("img");
        $doc[] = fhtml("p");

        $this->assertEquals('<div><p><img/></p><p></p></div>', $doc->render(false));
    }

    public function testAppendArrayTemplateToDocument()
    {
        $doc = fhtml("div");
        $doc[] = [
            "p" => fhtml("b")
        ];
        $this->assertEquals('<div><p><b></b></p></div>', $doc->render(false));
    }

    public function testTemplateInTemplate()
    {
        $doc = fhtml([
            "p" => "Some escaped Content",
            "p " => fhtml("img")
        ]);
        $this->assertEquals('<p>Some escaped Content</p><p><img/></p>', $doc->render(false));
    }

    public function testCreateWithParameters()
    {
        $doc = fhtml([
            "p @class=:class" => "b"
        ], ["class" => "x"]);
        $this->assertEquals('<p class="x">b</p>', $doc->render(false));
    }


    public function testAppendElementToIndexCreateElement()
    {
        $ob = fhtml("tr");
        $ob["td"] = fhtml(["elem" => "content"]);


        $this->assertEquals('<tr><td><elem>content</elem></td></tr>', $ob->render(false));
        echo $ob->render();

    }
}