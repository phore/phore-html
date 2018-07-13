<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 06.04.18
 * Time: 17:15
 */

namespace Phore\Html\Helper;


class DataUrl
{

    public static function FromFile(string $filename) : string
    {
        $typeMap = [
            "png" => "image/png",
            "jpg" => "image/jpg",
            "svg" => "image/svg+xml",
            "gif" => "image/gif",
        ];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $cType = "image/*";
        if (isset ($typeMap[$extension]))
            $cType = $typeMap[$extension];

        return "data:$cType;base64," . base64_encode(file_get_contents($filename));
    }

}