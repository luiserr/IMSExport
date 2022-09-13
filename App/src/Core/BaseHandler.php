<?php

namespace IMSExport\Core;

abstract class BaseHandler
{
    const ERROR = 'Error al hacer la operación';
    const SUCCESS = 'Operación exitosa';

    public function __construct(public array $params = [], public array $body = [])
    {
    }

    public static function response($success = false, $data = [], $message = self::ERROR): bool|string
    {
        return print_r(json_encode(compact('success', 'message', 'data')));
    }
}