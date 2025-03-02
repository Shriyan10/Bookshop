<?php

namespace App\controller;

use App\db\Database;
use App\mapper\impl\RoleMapper;
use App\mapper\impl\UserMapper;
use App\model\User;
use Exception;
use Latte\Engine;

class AuthenticationController extends BaseController
{
    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function login(string $email, string $password): void
    {
        $sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.address, u.contact_no, r.name AS role_id, u.password FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email='$email'";

        $user = $this->database->queryOne($sql, new UserMapper());

        if (!$user) {
            var_dump("User with email: $email not found");
        } else {
            $isVerified = password_verify(trim($password), $user->getPassword());
            if ($isVerified) {
                $_SESSION['user'] = $user;
                $this->redirect();
            } else {
                $this->redirect("login");
            }
        }
    }

    function logOut(): void
    {
        if ($this->isLoggedIn()) {
            session_unset();
            session_destroy();
        }

        $this->redirect();
    }

    function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    function loginPage(): void
    {
        if (isset($_SESSION['user'])) {
            $this->redirect();
        } else {
            $this->render("login");
        }

    }

    function registerPage(): void
    {
        $this->render("register");
    }

    function register(): void
    {
        try {
            $role = $this->database->queryOne("SELECT * FROM roles WHERE name='CUSTOMER'", new RoleMapper());
            error_log($role->id);
            $user = new User(
                null,
                $_POST['firstName'] ?? null,
                $_POST['lastName'] ?? null,
                $_POST['email'] ?? null,
                $_POST['password'] ?? null,
                $role->id,
                $_POST['address'] ?? null,
                $_POST['contactNo'] ?? null
            );

            $result = $this->database->query(
                "INSERT INTO users(first_name, last_name, email, password,role_id, address, contact_no) VALUES('%s','%s','%s','%s',%d,'%s',%d)",
                [
                    $user->getFirstName(),
                    $user->getLastName(),
                    $user->getEmail(),
                    password_hash(trim($user->getPassword()), PASSWORD_BCRYPT),
                    $user->getRoleId(),
                    $user->getAddress(),
                    $user->getContactNo()
                ],
            );

            if ($result) {
                $this->redirect("login");
                var_dump($result);
            }

        } catch (Exception $e) {
            error_log($e->getMessage());
//            $this->redirect("500");
        }
    }
}

