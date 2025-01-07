<?php
namespace App\controller;

use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\model\Role;
use Exception;
use Latte\Engine;


class RoleController {

    function getAllRoles(): void
    {
        $latte = new Engine;

        $database = new Database();
        $query = "SELECT * FROM roles";

        $route = new Router();

        $roles = $database -> queryAll($query, new RoleMapper());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $type = $_POST['type'];
                if(strcmp("DELETE", $type) == 0){
                    $database->query("DELETE FROM roles where id=%d", [$_POST['roleId']]);
                    header("Location: http://localhost/bookshop/roles");
                }elseif(strcmp("EDIT", $type) == 0){
                    header("Location: http://localhost/bookshop/EditRoleController.php?roleId=" . $_POST['roleId']);
                }
            } catch (Exception $e) {
                var_dump($e);
            }
        }

        $params = [
            'roles' => $roles,
            'roles_heading' => 'Roles'
        ];

// render to output
        $latte->render('templates\roles\roles.latte', $params);
    }

    function getRole(int $roleId): void
    {
        $latte = new Engine;
        $database = new Database();

        $query = "SELECT * FROM roles WHERE id=".$roleId;
        $role = $database->queryOne($query, new RoleMapper());
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $role = new Role(
                    $_GET['roleId'],
                    $_POST['roleName'] ?? null,
                );

                $result = $database->query(
                    "UPDATE roles SET name='%s' where id=%d",
                    [
                        $role->getName(),
                        $role->getId()
                    ],
                );
                if ($result) {
                    header("Location: http://localhost/bookshop/roles");
                }
            } catch (Exception $e) {
                var_dump($e);
            }
        }

        $params = [
            'role' => $role
        ];

        // render to output
        $latte->render('templates\roles\edit_role.latte', $params);
    }
}