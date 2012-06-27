<?php

namespace UFCOE;

class JsResponse extends \Symfony\Component\HttpFoundation\Response
{
    public function __construct($content = '', $status = 200, $headers = array())
    {
        $headers['Content-Type'] = 'application/x-javascript;charset=utf-8';
        parent::__construct($content, $status, $headers);
    }
}