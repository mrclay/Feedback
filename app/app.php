<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/* @var Silex\Application $app */
$app = (require __DIR__ . '/bootstrap.php');

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


$app->post('/send', function (Application $app, Request $req) {
    return (require __DIR__ . '/actions/send.php');
});


$app->get('/form', function(Application $app) {
    return (require __DIR__ . '/actions/form.php');
});


$ctrl = $app->get('/{version}', function(Application $app, $version) {
    return (require __DIR__ . '/actions/sendJs.php');
})->value('version', '');

return $app;