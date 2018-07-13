<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 14.06.18
 * Time: 18:22
 */

namespace Phore\Html\Fhtml;


abstract class FHtmlMacro
{

    protected $data;

    protected function __construct(array $data=[])
    {
        $this->data = $data;
    }


    public static function Use(array $data=[]) : self
    {
        return static($data);
    }

    abstract public function onAttach(FHtml $node) : FHtml;

}