<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 18.04.18
 * Time: 15:41
 */


function fhtml($elem=null, $params=[]) : \Phore\Html\Fhtml\FHtml {
    /*
    if (is_string($elem)) {
        return (new \Phore\Html\Fhtml\FHtml())->elem($elem, $params);
    }
    */
    return new \Phore\Html\Fhtml\FHtml($elem, $params);
}

/**
 * FHTML Empty Element
 */
define("FE", null);