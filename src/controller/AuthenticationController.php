<?php

namespace App\controller;

use App\db\Database;
use App\mapper\impl\UserMapper;
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
        if (isset($_SESSION['user'])) {
            session_unset();
            session_destroy();
        }

        $this->redirect();
    }

    function loginPage(): void
    {
        if (isset($_SESSION['user'])) {
            $this->redirect();
        } else {
            $this->render("login");
        }

    }
}

