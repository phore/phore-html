<?php

namespace Test;

require __DIR__ . "/../vendor/autoload.php";


$fhtml = fhtml("div @class=header some class @id=abcd")->content("Hello World");

echo $fhtml->render();


/*

<div class="header some class" id="abcd">
    Hello World
</div>

 */