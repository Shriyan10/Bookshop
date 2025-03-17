<?php

namespace App\controller;


use App\response\ServerResponse;


class RestController
{

    static function error(int $httpCode, string $message): void
    {
        RestController::response($httpCode, new ServerResponse(null, $message));
    }

    static function response(int $httpCode, $data = null): void
    {
        ob_start();
        ob_clean();
        header_remove();

        header("Content-type: application/json; charset=utf-8");

        http_response_code($httpCode);
        echo json_encode($data);
        exit();
    }

    function requestBody(): array{
        $requestBody = file_get_contents('php://input');
        return json_decode($requestBody, true);
    }
}