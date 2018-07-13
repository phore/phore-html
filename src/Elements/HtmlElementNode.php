<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 16:47
 */

namespace Phore\Html\Elements;


interface HtmlElementNode
{

    public function render($indent="  ", $index=0) : string;

    public function _setParent(HtmlContainerElement $parent);

    public function getParent() : HtmlContainerElement;

}