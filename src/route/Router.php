<?php

namespace App\route;


use App\controller\BookDetailController;
use App\controller\RoleController;
use App\controller\UserController;
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
        // home
        if ($this->endsWith($path, 'bookshop/')) {
            echo "<h1>Your in the home page</h1>";
        }

        // roles
        elseif (str_contains($path, 'bookshop/roles/')) {
           $this -> role($path);
        }

        // users
        elseif (str_contains($path, 'bookshop/users/')) {
            $this->user($path);
        }

        //books
        elseif (str_contains($path, 'bookshop/books/')) {
            $this->book($path);
        }

        // 404 page
        else if ($this->endsWith($path, '404')) {
            $this->latte->render('templates\404.latte', []);
        } else {
            $this->latte->render('templates\404.latte', []);
        }
    }

    function role(string $path): void
    {
        $roleController = new RoleController($this->latte);
        if ($this->endsWith($path, '/roles/')) {
            $roleController->getAllRoles();
        } else if (str_contains($path, '/save')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $roleController->saveRole();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $roleController->saveRolePage();
            }
        } else if (str_contains($path, '/edit?roleId=')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $roleController->updateRole($_GET['roleId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $roleController->getRole($_GET['roleId']);
            }
        } else if (str_contains($path, '/delete?roleId=')) {
            $roleController->deleteRole($_GET['roleId']);
        }
    }

    function user(string $path): void
    {
        $userController = new UserController($this->latte);
    if ($this->endsWith($path, '/users/')) {
        $userController->getAllUsers();
    }else if ($this->endsWith($path, '/save')) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->saveUser();
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userController->saveUserPage();
        }
    }
    else if (str_contains($path, '/edit?userId=')) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->updateUser($_GET['userId']);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userController->getUser($_GET['userId']);
        }
    } else if (str_contains($path, '/delete?userId=')) {
        $userController->deleteUser($_GET['userId']);
    }
    }


    function book(string $path): void
    {
        $bookDetailController = new BookDetailController($this->latte);
        if ($this->endsWith($path, '/books/')) {
            $bookDetailController->getAllBookDetails();
        }else if ($this->endsWith($path, '/save')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->saveBookDetails();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->saveBookDetailsPage();
            }
        }
        else if (str_contains($path, '/edit?bookId=')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->updateBookDetails($_GET['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->getBookDetails($_GET['bookId']);
            }
        } else if (str_contains($path, '/delete?bookId=')) {
            $bookDetailController->deleteBookDetails($_GET['bookId']);
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