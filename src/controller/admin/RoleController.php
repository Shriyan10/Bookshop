<?php
namespace App\controller\admin;

use App\Db\Database;
use App\mapper\impl\RoleMapper;
use App\model\Role;
use Exception;
use Latte\Engine;


class RoleController {

    private Engine $latte;

    public function __construct(Engine $latte)
    {
        $this->latte = $latte;
    }

    function getAllRoles(): void
    {
        try {
            $database = new Database();
            $query = "SELECT * FROM roles";

            $roles = $database -> queryAll($query, new RoleMapper());

            $params = [
                'roles' => $roles
            ];

            $this -> latte->render('templates\roles\list_role.latte', $params);
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }

    function getRole(int $roleId): void
    {
        try{
            $database = new Database();

            $query = "SELECT * FROM roles WHERE id=".$roleId;
            $role = $database->queryOne($query, new RoleMapper());

            $params = [
                'role' => $role
            ];

            // render to output
            $this -> latte->render('templates\roles\edit_role.latte', $params);
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/404");
        }
    }

    function updateRole(int $roleId): void{
        try {
            $role = new Role(
                $roleId,
                $_POST['roleName'] ?? null,
            );
            $database = new Database();
            $result = $database->query(
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
            var_dump($e);
            header("Location: http://localhost/bookshop/404");
        }
    }

    function deleteRole(int $roleId): void{
        try {
            $database = new Database();
            $result = $database->query("DELETE FROM roles where id=%d", [$roleId]);
            if ($result) {
                header("Location: http://localhost/bookshop/roles/");
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/404");
        }
    }

    function saveRolePage(): void {
        try {
            $this -> latte->render('templates\roles\add_role.latte', []);
        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/404");
        }
    }

    function saveRole(): void
    {
        try {
            $database = new Database();

            $role = new Role(
                null,
                $_POST['name'] ?? null
            );

            $result = $database->query(
                "INSERT INTO roles(name) VALUES('%s')",
                [
                    $role->getName(),
                ],
            );

            if ($result) {
                header("Location: http://localhost/bookshop/roles");
            }

        } catch (Exception $e) {
            var_dump($e);
            header("Location: http://localhost/bookshop/500");
        }
    }
}