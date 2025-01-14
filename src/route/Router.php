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
            $this->latte->render('templates\home.latte', []);
        } // roles
        elseif (str_contains($path, 'bookshop/roles')) {
            $this->role($path);
        } // users
        elseif (str_contains($path, 'bookshop/users')) {
            $this->user($path);
        } //book-details
        elseif (str_contains($path, 'bookshop/book-details')) {
            $this->bookDetail($path);
        } // 404 page
        else if ($this->endsWith($path, '500')) {
            $this->latte->render('templates\500.latte', []);
        } // 404 page
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

    function role(string $path): void
    {
        $roleController = new RoleController($this->latte);
        if (preg_match('#^/bookshop/roles/?$#', $path)) {
            $roleController->getAllRoles();
        } else if (preg_match('#^/bookshop/roles/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $roleController->saveRole();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $roleController->saveRolePage();
            }
        } else if (preg_match('#^/bookshop/roles/edit\?roleId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $roleController->updateRole($_GET['roleId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $roleController->getRole($_GET['roleId']);
            }
        } else if (preg_match('#^/bookshop/roles/delete\?roleId=\d+$#', $path)) {
            $roleController->deleteRole($_GET['roleId']);
        }
    }

    function user(string $path): void
    {
        $userController = new UserController($this->latte);
        if (preg_match('#^/bookshop/users/?$#', $path)) {
            $userController->getAllUsers();
        } else if (preg_match('#^/bookshop/users/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->saveUser();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $userController->saveUserPage();
            }
        } else if (preg_match('#^/bookshop/users/edit\?userId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->updateUser($_GET['userId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $userController->getUser($_GET['userId']);
            }
        } else if (preg_match('#^/bookshop/users/delete\?userId=\d+$#', $path)) {
            $userController->deleteUser($_GET['userId']);
        }
    }

    function bookDetail(string $path): void
    {
        $bookDetailController = new BookDetailController($this->latte);
        if (preg_match('#^/bookshop/book-details/?$#', $path)) {
            $bookDetailController->getAllBookDetails();
        } else if (preg_match('#^/bookshop/book-details/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->saveBookDetails();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->saveBookDetailsPage();
            }
        } else if (preg_match('#^/bookshop/book-details/edit\?bookDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->updateBookDetails($_GET['bookDetailId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->getBookDetails($_GET['bookDetailId']);
            }
        } else if (preg_match('#^/bookshop/book-details/delete\?bookDetailId=\d+$#', $path)) {
            $bookDetailController->deleteBookDetails($_GET['bookDetailId']);
        } else if (preg_match('#^/bookshop/book-details/stats\?bookDetailId=\d+$#', $path)) {
            $bookDetailController->statistics($_GET['bookDetailId']);
        } else if (preg_match('#^/bookshop/book-details/inventory\?bookDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->getBookByBookDetailIdAndId($_GET['bookDetailId'], $_POST['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->getBookByBookDetailId($_GET['bookDetailId']);
            }
        } else if (preg_match('#^/bookshop/book-details/inventory\?bookId=\d+$#', $path)) {
            $bookDetailController->getBookByBookDetailIdAndId($_GET['bookId']);
        } else if (preg_match('#^/bookshop/book-details/inventory/save\?bookDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->saveBook();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->saveBookPage($_GET['bookDetailId']);
            }
        } else if (preg_match('#^/bookshop/book-details/inventory/save?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->saveBook();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->saveBookPage(null);
            }
        } else if (preg_match('#^/bookshop/book-details/inventory/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->getBookDetailInventoryByBookDetailId($_POST['bookDetailId'], $_POST['date'], $_POST['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->getBookDetailInventory();
            }

        } else if (preg_match('#^/bookshop/book-details/inventory/update\?bookId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->updateBookDetailInventory($_GET['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->updateBookDetailInventoryPage($_GET['bookId']);
            }
        } else if (preg_match('#^/bookshop/book-details/inventory/delete\?bookId=\d+&redirect=.*$#', $path)) {
            $bookDetailController->deleteBookDetailInventory($_GET['bookId'], $_GET['redirect']);
        }
    }
}