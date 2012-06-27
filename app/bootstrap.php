<?php

require dirname(__DIR__) . '/vendor/.composer/autoload.php';

use Silex\Application;

$app = new Application();

/* @var Symfony\Component\ClassLoader\UniversalClassLoader $loader */
$loader = $app['autoloader'];

$loader->registerNamespace('UFCOE', __DIR__ . '/lib');

return $app;
