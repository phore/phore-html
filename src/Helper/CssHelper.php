<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 18.04.18
 * Time: 14:11
 */

namespace Phore\Html\Helper;


use Phore\Html\Fhtml\FHtml;

class CssHelper
{

    public static function IsCssClassName($name) {
        return preg_match ("/^[ a-z0-9\-]+$/i", $name);
    }

    public static function AppendIconOrImage (string $iconDef = null) {
        if ($iconDef === null)
            return null;
        if (self::IsCssClassName($iconDef))
            return (new FHtml())->i("@class=?", [$iconDef]);
        return (new FHtml())->img("@src=? @class=d-inline-block align-top @width=30 @height=30", [$iconDef]);
    }

}