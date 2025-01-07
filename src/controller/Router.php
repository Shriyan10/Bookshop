<?php

namespace App\controller;


use Latte\Engine;

class Router
{
    private Engine $latte;

    public function __construct()
    {
        $this->latte = new Engine();
    }


    function route(string $path): void
    {
        $roleController = new RoleController($this->latte);
        $userController = new UserController($this->latte);

        if ($this->endsWith($path, 'bookshop/')) {
            echo "<h1>Your in the home page</h1>";
        }

        // roles

        elseif ($this->endsWith($path, 'roles')) {
            $roleController->getAllRoles();
        } else if (str_contains($path, 'roles/save')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $roleController->saveRole();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $roleController->saveRolePage();
            }
        } else if (str_contains($path, 'roles/edit?roleId=')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $roleController->updateRole($_GET['roleId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $roleController->getRole($_GET['roleId']);
            }
        } else if (str_contains($path, 'roles/delete?roleId=')) {
            $roleController->deleteRole($_GET['roleId']);
        }

        // users
        else if ($this->endsWith($path, 'users')) {
            $userController->getAllUsers();
        } else if (str_contains($path, 'users/edit?userId=')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->updateUser($_GET['userId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $userController->getUser($_GET['userId']);
            }
        } else if (str_contains($path, 'users/delete?userId=')) {
            $userController->deleteUser($_GET['userId']);
        }

        // 404 page
        else if ($this->endsWith($path, '404')) {
            $this->latte->render('templates\404.latte', []);
        } else {
            $this->latte->render('templates\404.latte', []);
        }
    }

    function endsWith($string, $endString): bool
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }

}