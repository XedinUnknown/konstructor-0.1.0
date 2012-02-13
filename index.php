<?php
/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */

if( version_compare(PHP_VERSION, '5.3', '<') ) {
    exit('Sorry, but at least PHP 5.3 is needed to run this.');
}

define('PATH_ROOT', dirname(realpath(__FILE__)) . '/');

function xdn_autoload($className) {
    $fileName = PATH_ROOT . str_replace('_', '/', $className) . '.php';
    if( file_exists($fileName) ) {
        require_once($fileName);
    }
}
spl_autoload_register('xdn_autoload');

$graftA = new GraftA();
var_dump($graftA);

echo $graftA->getName();

?>