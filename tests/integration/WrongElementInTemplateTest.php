<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 26.06.19
 * Time: 15:11
 */

namespace Phore\Html\Tests\Integration;


use Phore\Html\Fhtml\FHtml;
use PHPUnit\Framework\TestCase;

class WrongElementInTemplateTest extends TestCase
{

    public function testDebugTag()
    {
        $doc = new FHtml("div");
        $doc[] = $b = new FHtml([
            "a" => $c = new FHtml("p")
        ]);

        print_r ($c->debugGetPath());
    }


    public function testInvalidArrayElement()
    {
        $doc = new FHtml([

        ]);
    }

}