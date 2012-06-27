<?php
/* @var \Silex\Application $app */

$config = $app['config'];
$sess = $app['session'];
/* @var \Symfony\Component\HttpFoundation\Session\SessionInterface $sess */

$email = $name = '';
if ($sess->has('Feedback_email')) {
    $email = $sess->get('Feedback_email');
} elseif ($config['knownEmail']) {
    $email = $config['knownEmail'];
}
if ($sess->has('Feedback_name')) {
    $name = $sess->get('Feedback_name');
} elseif ($config['knownName']) {
    $name = $config['knownName'];
}

return $app['twig']->render('form.twig', array(
    'config' => $config,
    'email' => $email,
    'name' => $name,
    'tokenInput' => $app['tokenMgr']->generateHiddenInput(),
));
