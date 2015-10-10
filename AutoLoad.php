<?php

function autoLoad($class){
    require_once "php/classes/$class.class.php";
}

spl_autoload_register("autoLoad");