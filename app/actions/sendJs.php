<?php
/* @var \Silex\Application $app */
/* @var string $version */

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
$webPath = $app['webPath'];
if (is_file($webPath . '/static/style.css')) {
    $cssTimestamp = filemtime($webPath . '/static/style.css');
} else {
    $cssTimestamp = 0;
}

$body = $app['twig']->render('jsConfig.twig', array(
    'url' => "{$protocol}://{$_SERVER['SERVER_NAME']}" . dirname($_SERVER['SCRIPT_NAME']),
    'cssTimestamp' => $cssTimestamp,
    'config' => $app['config'],
));
$resp = new UFCOE\JsResponse($body);
$resp->setPublic();
$resp->setMaxAge($version ? 365 * 86400 : 0);
return $resp;