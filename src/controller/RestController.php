<?php

namespace App\controller;


use App\db\Database;
use App\response\ServerResponse;


class RestController
{
    protected Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    function redirect(string $url = ""): void
    {
        // Get the current protocol (http or https)
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

        // Get the current host and port (if necessary)
        $host = $_SERVER['HTTP_HOST'];  // Will give you localhost:9900 or domain:port
        $baseUrl = $protocol . '://' . $host . '/';

        header("Location: " . $baseUrl . $url);
    }

    function response(int $httpCode, $data = null): void
    {
        ob_start();
        ob_clean();
        header_remove();
        
        // Set security headers
        header("Content-type: application/json; charset=utf-8");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        
        // Set CORS headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Max-Age: 3600");
        
        http_response_code($httpCode);
        echo json_encode($data);
        exit();
    }

    function error(int $httpCode, string $message): void
    {
        $this->response($httpCode, new ServerResponse(null, $message));
    }
}