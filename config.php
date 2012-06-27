<?php

return call_user_func(function () {

    $config = array();

    $config['isTesting'] = true;

    $config['includeName'] = false;

    $config['emailTo'] = 'user@example.com';

    return $config;
});