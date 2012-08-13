<?php

use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request,
    Silex\Application;

/* @var Silex\Application $app */

$app->post('/send', function (Application $app, Request $req) {
    return (require __DIR__ . '/actions/send.php');
});


$app->get('/form', function(Application $app) {
    return (require __DIR__ . '/actions/form.php');
});


$app->get('/{version}', function(Application $app, $version) {
    return (require __DIR__ . '/actions/sendJs.php');
})->value('version', '');
