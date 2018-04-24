<?php

$loader = require_once (__DIR__.'/../vendor/autoload.php');
$loader->addPsr4('Tests\\App\\', [__DIR__]);

/*
 * fix for using PHPUnit as composer package and PEAR extension
 */
$composerClassName = '\PHPUnit\Framework\TestCase';
$pearClassName = '\PHPUnit_Framework_TestCase';
if (!class_exists($composerClassName) && class_exists($pearClassName)) {
    class_alias($pearClassName, $composerClassName);
}