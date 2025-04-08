<?php

use App\db\Database;
use App\repository\impl\ProductRepositoryMySQLImpl;
use App\repository\impl\RoleRepositoryMySQLImpl;
use App\repository\impl\UserRepositoryMySQLImpl;
use App\repository\ProductRepository;
use App\repository\RoleRepository;
use App\repository\UserRepository;
use App\route\APIRouter;
use App\route\Router;
use App\util\impl\ObjectMapperJMSImpl;
use App\util\ObjectMapper;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Latte\Engine;

require 'vendor/autoload.php';

$latte = new Engine();
$database = new Database();

$uri = $_SERVER['REQUEST_URI'];
// Check if the .env file exists before loading
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    error_log("WARNING .env file not found");
}
session_start();

if (str_contains($uri, '/api/rest')) {

    $builder = new ContainerBuilder();
    $builder->useAutowiring(true);
    $builder->useAttributes(true);
    $builder->enableCompilation(__DIR__ . '\tmp');
    $builder->writeProxiesToFile(true, __DIR__ . '\tmp\proxies');
    $builder->addDefinitions([
        RoleRepository::class => DI\autowire(RoleRepositoryMySQLImpl::class),
        UserRepository::class => DI\autowire(UserRepositoryMySQLImpl::class),
        ProductRepository::class => DI\autowire(ProductRepositoryMySQLImpl::class),
        ObjectMapper::class => DI\autowire(ObjectMapperJMSImpl::class),
    ]);

    try {
        $container = $builder->build();
        $apiRouter = $container->get(ApiRouter::class);
        $apiRouter->route($uri);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }

} else {
    $router = new Router($latte, $database);
    $router->route($uri);
}






