<?php

use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request,
    Silex\Application;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = new Application();

$app['webPath'] = dirname(__DIR__);

$app['config'] = array_merge(
    array(
        'httpRoot' => 'http://' . $_SERVER['SERVER_NAME'],
        'knownName' => '',
        'knownEmail' => '',
    ),
    (require $app['webPath'] . '/config.php')
);

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__ . '/views',
    'twig.options' => array(
        'cache' => sys_get_temp_dir(),
    ),
));

$app['tokenMgr'] = $app->share(function () use ($app) {
    return new UFCOE\CsrfTokenManager($app['session']);
});

if ($app['config']['isTesting']) {
    $app['debug'] = true;
}

$app['errorResponse'] = function ($err) use ($app) {
    return $app['twig']->render('error.twig', array(
        'config' => $app['config'],
    ));
};

require __DIR__ . '/app-routes.php';

return $app;