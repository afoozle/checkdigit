<?php
/**
 * @author Matthew Wheeler <matt@yurisko.net>
 * @copyright Copyright 2011 Matthew Wheeler
 * @license See LICENSE file distributed with this source code
 */

/**
 * Autoloader
 */
spl_autoload_register(function($class)
{
    $file = __DIR__.'/../src/'.strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});