<?php

function autoLoad($class){
    require_once "php/$class.class.php";
}

spl_autoload_register("autoLoad");