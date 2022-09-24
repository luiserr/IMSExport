<?php

namespace IMSExport\Core;

abstract class BaseHandler
{
    const ERROR = 'Error al hacer la operación';
    const SUCCESS = 'Operación exitosa';
    public $params = [];
    public $body = [];

    public function __construct($params = [], $body = [])
    {
        $this->params = $params;
        $this->body = $body;
    }

    public static function response($success = false, $data = [], $message = self::ERROR)
    {
        return print_r(json_encode(compact('success', 'message', 'data')));
    }
}