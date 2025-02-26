<?php

namespace App\route;


use App\controller\admin\ProductController as AdminProductController;
use App\controller\admin\RoleController;
use App\controller\admin\UserController;
use App\controller\AuthenticationController;
use App\controller\BaseController;
use App\controller\customer\CheckoutController;
use App\controller\customer\PaymentController;
use App\controller\customer\ProductController as CustomerProductController;
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
            $this->product($path);
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
                $cartController->add([$_POST['productDetailId'] => $_POST['quantity']]);
            }else{
                $cartController->cart();
            }
        }
        elseif (preg_match('#^/checkout?$#', $path)) {
            $checkoutController = new CheckoutController($this->latte, $this->database);
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $checkoutController->checkout();
            }
        }elseif (preg_match('#^/about?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->render("about");
            }
        } elseif (preg_match('#^/contact-us?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->render("contactus");
            }
        }elseif (preg_match('#^/payments?$#', $path)) {
            $paymentController = new PaymentController($this->latte, $this->database);
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $paymentController->viewPayments();
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
        } //product-details
        elseif (str_contains($path, '/product-details')) {
            $this->productDetail($path);
        } //products
        elseif (str_contains($path, '/books')) {
            $this->product($path);
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

    function product(string $path): void
    {
        $customerProductController = new CustomerProductController($this->latte, $this->database);
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

            $customerProductController->getAllProducts($start, $limit, $search);
        } elseif (preg_match('#^/books/detail\?id=\d+$#', $path)) {
            $customerProductController->getProductDetail($_GET['id']);
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

    function productDetail(string $path): void
    {
        $productDetailController = new AdminProductController($this->latte, $this->database);
        if (preg_match('#^/product-details/?(?:\?.*)?$#', $path)) {

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

            $productDetailController->getAllProductDetails($start, $limit, $search);
        } else if (preg_match('#^/product-details/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productDetailController->saveProducts();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $productDetailController->saveProductDetailsPage();
            }
        } else if (preg_match('#^/product-details/edit\?productDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productDetailController->updateProductDetails($_GET['productDetailId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $productDetailController->getProductDetails($_GET['productDetailId']);
            }
        } else if (preg_match('#^/product-details/delete\?productDetailId=\d+$#', $path)) {
            $productDetailController->deleteProductDetails($_GET['productDetailId']);
        } else if (preg_match('#^/product-details/stats\?productDetailId=\d+$#', $path)) {
            $productDetailController->statistics($_GET['productDetailId']);
        } else if (preg_match('#^/product-details/inventory\?productDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productDetailController->getProductByProductDetailIdAndId($_GET['productDetailId'], $_POST['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $productDetailController->getProductByProductDetailId($_GET['productDetailId']);
            }
        } else if (preg_match('#^/product-details/inventory\?productDetailId=\d+&start=\d+&limit=\d+$#', $path)) {
            $productDetailController->getProductByProductDetailId($_GET['productDetailId'], $_GET['start'], $_GET['limit']);
        } else if (preg_match('#^/product-details/inventory\?bookId=\d+$#', $path)) {
            $productDetailController->getProductByProductDetailIdAndId($_GET['bookId'], $_GET['productDetailId'], $_GET['start'], $_GET['limit']);
        } else if (preg_match('#^/product-details/inventory/save\?productDetailId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productDetailController->saveProduct();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $productDetailController->saveProductPage($_GET['productDetailId']);
            }
        } else if (preg_match('#^/product-details/inventory/save/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productDetailController->saveProduct();
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $productDetailController->saveProductPage(null);
            }
        } else if (preg_match('#^/product-details/inventory/?$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productDetailController->getBookDetailInventoryByProductDetailId($_POST['productDetailId'], $_POST['date'], $_POST['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $productDetailController->getProductDetailInventory();
            }
        } else if (preg_match('#^/product-details/inventory\?start=\d+&limit=\d+$#', $path)) {
            $productDetailController->getProductDetailInventory($_GET['start'], $_GET['limit']);
        } else if (preg_match('#^/product-details/inventory\?start=\d+&limit=\d+$#', $path)) {
            $productDetailController->getBookDetailInventoryByproductDetailId($_POST['productDetailId'], $_POST['date'], $_POST['bookId'], $_GET['start'], $_GET['limit']);
        } else if (preg_match('#^/product-details/inventory/update\?bookId=\d+$#', $path)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productDetailController->updateProductDetailInventory($_GET['bookId']);
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $productDetailController->updateProductDetailInventoryPage($_GET['bookId']);
            }
        } else if (preg_match('#^/product-details/inventory/delete\?bookId=\d+&redirect=.*$#', $path)) {
            $productDetailController->deleteProductDetailInventory($_GET['bookId'], $_GET['redirect']);
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