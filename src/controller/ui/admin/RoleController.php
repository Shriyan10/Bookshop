<?php

namespace App\controller\ui\admin;

use App\controller\ui\UIController;
use App\db\Database;
use App\mapper\impl\RoleMapper;
use App\model\Role;
use App\service\RoleService;
use Exception;
use Latte\Engine;


class RoleController extends UIController
{
    private RoleService $roleService;

    public function __construct(Engine $latte, Database $database, RoleService $roleService)
    {
        parent::__construct($latte, $database);
        $this->roleService = $roleService;
    }

    function getAllRoles(): void
    {
        try {
            $params = [
                'roles' => $this->roleService->getAllRoles()
            ];

            $this->render('roles/list_role', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
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
            $this->render('roles/edit_role', $params);
        } catch (Exception $e) {
            error_log($e->getMessage());
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
                $this->redirect("roles");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function deleteRole(int $roleId): void
    {
        try {
            $result = $this->database->query("DELETE FROM roles where id=%d", [$roleId]);
            if ($result) {
                $this->redirect("roles");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }

    function saveRolePage(): void
    {
        try {
            $this->render('roles/add_role');
        } catch (Exception $e) {
            error_log($e->getMessage());
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
            error_log($e->getMessage());
            $this->redirect("500");
        }
    }
}