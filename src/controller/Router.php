<?php

namespace App\controller;


class Router
{

    function route(string $path): void
    {
        $roleController = new RoleController();

        if ($this->endsWith($path, 'roles')) {
            $roleController->getAllRoles();
        }else if (str_contains($path, 'roles/edit?roleId=')) {
            $roleController->getRole($_GET['roleId']);
        } elseif ($this->endsWith($path, 'bookshop/')) {
            echo "<h1>Your in the home page</h1>";
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