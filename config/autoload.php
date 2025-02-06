<?php

function autoload($path) {
  spl_autoload_register(function ($class) use ($path) {
    $file = $path . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Class $class not found");
    }
  });

}

autoload('app/Controllers/');
autoload('app/Models/');