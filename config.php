<?php

return call_user_func(function () {

    $config = array();

    $config['isTesting'] = true;

    // show Name field (required)
    $config['includeName'] = true;

    $config['emailTo'] = 'user@example.com';

    return $config;
});