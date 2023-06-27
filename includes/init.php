<?php

/**
 * Initializations
 * Register autoload, start or resume the session etc.
 */
spl_autoload_register(function($class){
    require "classes/{$class}.php";
});

session_start();