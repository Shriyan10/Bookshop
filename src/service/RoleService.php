<?php

namespace App\service;


use App\exception\ApplicationException;
use App\repository\RoleRepository;
use Exception;

class RoleService
{

    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function getAllRoles(): array
    {
        try {
            return $this->roleRepository->getAllRoles();
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function getRoleById(int $id): object | null
    {
        try {
             $role = $this->roleRepository->getRoleById($id);
             if(!$role){
                 throw new ApplicationException("Role not found", 404);
             }
             return $role;
        }  catch (ApplicationException $e) {
            throw $e;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public function saveRole(string $name): bool
    {
        try {
            return $this->roleRepository->saveRole($name);
        } catch (Exception $e) {
            throw new ApplicationException($e);
        }
    }

}