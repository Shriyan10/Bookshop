<?php

namespace App\route;


use App\controller\admin\BookDetailController;
use App\controller\admin\RoleController;
use App\controller\admin\UserController;
use App\controller\AuthenticationController;
use App\controller\BaseController;
use App\controller\customer\BookController;
use App\controller\customer\CartController;
use App\db\Database;
use Latte\Engine;

class Router extends BaseController
{
    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function route(string $path): void
    {
        // home
        if ($path === '/') {
            $this->book($path);
        } elseif (preg_match('#^/login/?$#', $path)) {
            $authenticationController = new AuthenticationController($this->latte, $this->database);
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $authenticationController->login($_POST['email'], $_POST['password']);
            } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $authenticationController->loginPage();
            }
        } elseif (preg_match('#^/logout/?$#', $path)) {
            $authenticationController = new AuthenticationController($this->latte, $this->database);
            $authenticationController->logOut();
        } elseif (preg_match('#^/cart?$#', $path)) {
            $cartController = new CartController($this->latte, $this->database);
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $cartController->add([$_POST['bookDetailId'] => $_POST['quantity']]);
            }else{
                $cartController->cart();
            }
        } elseif (preg_match('#^/about?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->render("about");
            }
        } elseif (preg_match('#^/contact-us?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->render("contactus");
            }
        } elseif (preg_match('#^/register?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->render("register");
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $authenticationController = new AuthenticationController($this->latte, $this->database);
                $authenticationController -> register();
            }
        } // roles
        elseif (str_contains($path, '/roles')) {
            $this->role($path);
        } // users
        elseif (str_contains($path, '/users')) {
            $this->user($path);
        } //book-details
        elseif (str_contains($path, '/book-details')) {
            $this->bookDetail($path);
        } //products
        elseif (str_contains($path, '/books')) {
            $this->book($path);
        } // 500 page
        else if ($this->endsWith($path, '500')) {
            $this->render('500');
        } // 404 page
        else if ($this->endsWith($path, '404')) {
            $this->render('404');
        } else {
            $this->render('404');
        }
    }

    function book(string $path): void
    {
        $bookController = new BookController($this->latte, $this->database);
        if (preg_match('/^\/(?:\?(?:[a-zA-Z0-9_-]+=[^&]*)?(?:&[a-zA-Z0-9_-]+=[^&]*)*)?$/', $path)) {

            $start = 1;
            $limit = 8;
            $search = "";

            if (isset($_GET['start'])) {
                $start = $_GET['start'];
            }

            if (isset($_GET['limit'])) {
                $limit = $_GET['limit'];
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['search'])) {
                    $search = $_POST['search'];
                }
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                }
            }

            $bookController->getAllBooks($start, $limit, $search);
        } elseif (preg_match('#^/books/detail\?id=\d+$#', $path)) {
            $bookController->getBookDetail($_GET['id']);
        }
    }

    function role(string $path): void
    {
        $roleController = new RoleController($this->latte, $this->database);
        if (preg_match('#^/roles/?$#', $path)) {
            $roleController->getAllRoles();
        } else if (preg_match('#^/roles/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $roleController->saveRole();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $roleController->saveRolePage();
            }
        } else if (preg_match('#^/roles/edit\?roleId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $roleController->updateRole($_GET['roleId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $roleController->getRole($_GET['roleId']);
            }
        } else if (preg_match('#^/roles/delete\?roleId=\d+$#', $path)) {
            $roleController->deleteRole($_GET['roleId']);
        }
    }

    function user(string $path): void
    {
        $userController = new UserController($this->latte, $this->database);
        if (preg_match('#^/users/?(?:\?.*)?$#', $path)) {

            $start = 1;
            $limit = 5;
            $search = "";

            if (isset($_GET['start'])) {
                $start = $_GET['start'];
            }

            if (isset($_GET['limit'])) {
                $limit = $_GET['limit'];
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['search'])) {
                    $search = $_POST['search'];
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                }
            }

            $userController->getAllUsers($start, $limit, $search);
        } else if (preg_match('#^/users/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->saveUser();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $userController->saveUserPage();
            }
        } else if (preg_match('#^/users/edit\?userId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->updateUser($_GET['userId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $userController->getUser($_GET['userId']);
            }
        } else if (preg_match('#^/users/delete\?userId=\d+$#', $path)) {
            $userController->deleteUser($_GET['userId']);
        }
    }

    function bookDetail(string $path): void
    {
        $bookDetailController = new BookDetailController($this->latte, $this->database);
        if (preg_match('#^/book-details/?(?:\?.*)?$#', $path)) {

            $start = 1;
            $limit = 3;
            $search = "";

            if (isset($_GET['start'])) {
                $start = $_GET['start'];
            }

            if (isset($_GET['limit'])) {
                $limit = $_GET['limit'];
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['search'])) {
                    $search = $_POST['search'];
                }
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                }
            }

            $bookDetailController->getAllBookDetails($start, $limit, $search);
        } else if (preg_match('#^/book-details/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->saveBookDetails();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->saveBookDetailsPage();
            }
        } else if (preg_match('#^/book-details/edit\?bookDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->updateBookDetails($_GET['bookDetailId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->getBookDetails($_GET['bookDetailId']);
            }
        } else if (preg_match('#^/book-details/delete\?bookDetailId=\d+$#', $path)) {
            $bookDetailController->deleteBookDetails($_GET['bookDetailId']);
        } else if (preg_match('#^/book-details/stats\?bookDetailId=\d+$#', $path)) {
            $bookDetailController->statistics($_GET['bookDetailId']);
        } else if (preg_match('#^/book-details/inventory\?bookDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->getBookByBookDetailIdAndId($_GET['bookDetailId'], $_POST['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->getBookByBookDetailId($_GET['bookDetailId']);
            }
        } else if (preg_match('#^/book-details/inventory\?bookDetailId=\d+&start=\d+&limit=\d+$#', $path)) {
            $bookDetailController->getBookByBookDetailId($_GET['bookDetailId'], $_GET['start'], $_GET['limit']);
        } else if (preg_match('#^/book-details/inventory\?bookId=\d+$#', $path)) {
            $bookDetailController->getBookByBookDetailIdAndId($_GET['bookId'], $_GET['bookDetailId'], $_GET['start'], $_GET['limit']);
        } else if (preg_match('#^/book-details/inventory/save\?bookDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->saveBook();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->saveBookPage($_GET['bookDetailId']);
            }
        } else if (preg_match('#^/book-details/inventory/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->saveBook();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->saveBookPage(null);
            }
        } else if (preg_match('#^/book-details/inventory/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->getBookDetailInventoryByBookDetailId($_POST['bookDetailId'], $_POST['date'], $_POST['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->getBookDetailInventory();
            }
        } else if (preg_match('#^/book-details/inventory\?start=\d+&limit=\d+$#', $path)) {
            $bookDetailController->getBookDetailInventory($_GET['start'], $_GET['limit']);
        } else if (preg_match('#^/book-details/inventory\?start=\d+&limit=\d+$#', $path)) {
            $bookDetailController->getBookDetailInventoryByBookDetailId($_POST['bookDetailId'], $_POST['date'], $_POST['bookId'], $_GET['start'], $_GET['limit']);
        } else if (preg_match('#^/book-details/inventory/update\?bookId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookDetailController->updateBookDetailInventory($_GET['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $bookDetailController->updateBookDetailInventoryPage($_GET['bookId']);
            }
        } else if (preg_match('#^/book-details/inventory/delete\?bookId=\d+&redirect=.*$#', $path)) {
            $bookDetailController->deleteBookDetailInventory($_GET['bookId'], $_GET['redirect']);
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