<?php

namespace App\controller\admin;

use App\controller\BaseController;
use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\model\Role;
use Exception;
use Latte\Engine;


class RoleController extends BaseController
{

    public function __construct(Engine $latte, Database $database)
    {
        parent::__construct($latte, $database);
    }

    function getAllRoles(): void
    {
        try {
            $query = "SELECT * FROM roles";

            $roles = $this->database->queryAll($query, new RoleMapper());

            $params = [
                'roles' => $roles
            ];

            $this->render('roles\list_role', $params);
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function getRole(int $roleId): void
    {
        try {

            $query = "SELECT * FROM roles WHERE id=" . $roleId;
            $role = $this->database->queryOne($query, new RoleMapper());

            $params = [
                'role' => $role
            ];

            // render to output
            $this->render('roles\edit_role', $params);
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function updateRole(int $roleId): void
    {
        try {
            $role = new Role(
                $roleId,
                $_POST['roleName'] ?? null,
            );
            $database = new Database();
            $result = $this->database->query(
                "UPDATE roles SET name='%s' where id=%d",
                [
                    $role->getName(),
                    $role->getId()
                ],
            );
            if ($result) {
                header("Location: http://localhost/bookshop/roles/");
            }
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function deleteRole(int $roleId): void
    {
        try {
            $result = $this->database->query("DELETE FROM roles where id=%d", [$roleId]);
            if ($result) {
                header("Location: http://localhost/bookshop/roles/");
            }
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function saveRolePage(): void
    {
        try {
            $this->render('roles\add_role');
        } catch (Exception $e) {
            $this->redirect("500");
        }
    }

    function saveRole(): void
    {
        try {

            $role = new Role(
                null,
                $_POST['name'] ?? null
            );

            $result = $this->database->query(
                "INSERT INTO roles(name) VALUES('%s')",
                [
                    $role->getName(),
                ],
            );

            if ($result) {
                $this->redirect("roles");
            }

        } catch (Exception $e) {
            $this->redirect("500");
        }
    }
}