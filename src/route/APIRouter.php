<?php

namespace App\route;


use App\controller\api\admin\RoleRestController;
use App\controller\api\admin\UserRestController;
use App\controller\RestController;
use App\exception\ApplicationException;
use App\exception\BaseException;
use App\response\ServerResponse;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;

class APIRouter extends RestController
{
    public const API_REST = 'api/rest';
    private Container $container;
    private RoleRestController $roleRestController;
    private UserRestController $userRestController;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    function route(string $path): void
    {
        try {

            if (str_contains($path, '/' . self::API_REST . '/generate-password')) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->response(200, new ServerResponse(["hashed" => password_hash($this->requestBody()['password'], PASSWORD_BCRYPT)], null));
                    return;
                }
            }

            if (str_contains($path, '/' . self::API_REST . '/roles')) {
                $this->role($path);
            } else if (str_contains($path, '/' . self::API_REST . '/users')) {
                $this->user($path);
            }

        } catch (BaseException $exception) {
            if ($exception->throwable()) {
                error_log('Exception: ' . $exception->throwable()->getMessage());
            }
            RestController::error($exception->getCode(), $exception->getMessage());
        } catch (Exception $exception) {
            error_log('Exception: ' . $exception->getMessage());
            RestController::error(500, $exception->getMessage());
        }

        self::response(404, "Not found");
    }

    /**
     * @throws ApplicationException
     * @throws NotFoundException
     * @throws DependencyException
     */
    function role(string $path): void
    {
        $this->roleRestController = $this->container->get(RoleRestController::class);
        if (preg_match('#^/' . self::API_REST . '/roles/?$#', $path)) {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->roleRestController->saveRole();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->roleRestController->getAllRoles();
            }
        } else if (preg_match('#^/api/rest/roles\?id=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                $this->roleRestController->updateRole($_GET['id']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->roleRestController->getRole($_GET['id']);
            }else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $this->roleRestController->deleteRole($_GET['id']);
            }
        }
    }

    /**
     * @throws ApplicationException
     * @throws NotFoundException
     * @throws DependencyException
     */
    function user(string $path): void
    {
        $this->userRestController = $this->container->get(UserRestController::class);
        if (preg_match('#^/api/rest/users\?id=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                $this->userRestController->updateUser($_GET['id']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->userRestController->getUser($_GET['id']);
            }else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $this->userRestController->deleteUser($_GET['id']);
            }
        } else if (preg_match('#^/api/rest/users/?(?:\?.*)?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->userRestController->getAllUsers();
            } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->userRestController->saveUser();
            }
        }
    }
}