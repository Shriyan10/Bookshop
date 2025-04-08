<?php

namespace App\controller;


use App\exception\ApplicationException;
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


        // Handle preflight request for OPTIONS method
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            error_log("asd");
            header("Content-Type: application/json; charset=utf-8");
            header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
            header("Access-Control-Allow-Headers: *"); // Allow requests from any origin
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

            http_response_code(204); // No Content
            exit;
        }else{
            header("Content-Type: application/json; charset=utf-8");
            header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
            header("Access-Control-Allow-Headers: *"); // Allow requests from any origin
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

            http_response_code($httpCode);
            echo json_encode($data);
            exit();
        }

    }

    /**
     * @throws ApplicationException
     */
    function mandatoryKey(string $key): mixed
    {
        $array = $this->requestBody();
        if (!array_key_exists($key, $array)) {
            throw new ApplicationException("Mandatory key '$key' not found", 400);
        }
        return $array[$key];
    }

    function requestBody(): array
    {
        $requestBody = file_get_contents('php://input');
        return json_decode($requestBody, true);
    }



    function validatedRequestBody(): array
    {
        $requestBody = file_get_contents('php://input');
        return json_decode($requestBody, true);
    }


    function validator(){

    }

    function getQueryParam(string $key, $default)
    {

        if (isset($_GET[$key])) {
            return $_GET[$key];
        }

        return $default;
    }
}