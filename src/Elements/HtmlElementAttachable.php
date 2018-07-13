<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 18.04.18
 * Time: 09:37
 */

namespace Phore\Html\Elements;


interface HtmlElementAttachable
{

    public function getHtmlElementNode() : HtmlElementNode;

}