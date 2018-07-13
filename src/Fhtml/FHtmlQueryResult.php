<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 13.06.18
 * Time: 14:24
 */

namespace Phore\Html\Fhtml;


class FHtmlQueryResult extends FHtml
{


    protected $result;

    public function __construct(array $template = null, array $result)
    {
        $this->result = $result;
        parent::__construct($template);
    }

    public function each(callable $fn) : int
    {
        for ($i=0; $i< count ($this->result); $i++) {
            if ($fn($this->result[$i], $i) === false)
                return false;
        }
        return $i;
    }

}