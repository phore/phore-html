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
        $doc = fhtml("html");
        $div = $doc->elem("div @id=abc");

        $this->assertEquals($div->getNode(), $doc->query("#abc")->getNode());
        $this->assertEquals($div->getNode(), $doc["?#abc"]->getNode());
    }


}