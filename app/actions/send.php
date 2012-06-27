<?php
/* @var \Silex\Application $app */
/* @var \Symfony\Component\HttpFoundation\Request $req */

$config = $app['config'];
$sess = $app['session'];
/* @var \Symfony\Component\HttpFoundation\Session\SessionInterface $sess */

if (! $app['tokenMgr']->requestHasValidToken($req)) {
    return $app['errorResponse'];
}

$email = (string) $req->get('fb_email');
$name = (string) $req->get('fb_name');

// single line fields should not have spaces/mail headers
if (preg_match('/\\r|\\n|cc:|to:/i', $email . $name)) {
    return $app['errorResponse'];
}

$email = trim($email);
$name = trim($name);

if ($email) {
    $sess->set('Feedback_email', $email);
}
if ($name) {
    $sess->set('Feedback_name', $name);
}

$body = $app['twig']->render('mailFormat.twig', array(
    'email' => $email,
    'name' => $name,
    'msg' => trim((string) $req->get('fb_msg')),
    'url' => (string) $req->get('fb_url'),
    'ua' => $req->headers->get('User-Agent'),
));

// normalize line endings for email
$body = trim($body);
$body = preg_replace('/\\r\\n?/', "\\n", $body);

if ($config['emailTo'] !== 'user@example.com') {
    mail($config['emailTo'], 'Feedback', $body, "From: " . $config['emailTo']);
}

return $app['twig']->render('sent.twig');