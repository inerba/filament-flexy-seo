<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["ViewAny:Article","View:Article","Create:Article","Update:Article","Delete:Article","Restore:Article","ForceDelete:Article","ForceDeleteAny:Article","RestoreAny:Article","Replicate:Article","Reorder:Article","ViewAny:Author","View:Author","Create:Author","Update:Author","Delete:Author","Restore:Author","ForceDelete:Author","ForceDeleteAny:Author","RestoreAny:Author","Replicate:Author","Reorder:Author","ViewAny:Category","View:Category","Create:Category","Update:Category","Delete:Category","Restore:Category","ForceDelete:Category","ForceDeleteAny:Category","RestoreAny:Category","Replicate:Category","Reorder:Category","ViewAny:Menu","View:Menu","Create:Menu","Update:Menu","Delete:Menu","Restore:Menu","ForceDelete:Menu","ForceDeleteAny:Menu","RestoreAny:Menu","Replicate:Menu","Reorder:Menu","ViewAny:Page","View:Page","Create:Page","Update:Page","Delete:Page","Restore:Page","ForceDelete:Page","ForceDeleteAny:Page","RestoreAny:Page","Replicate:Page","Reorder:Page","ViewAny:Tag","View:Tag","Create:Tag","Update:Tag","Delete:Tag","Restore:Tag","ForceDelete:Tag","ForceDeleteAny:Tag","RestoreAny:Tag","Replicate:Tag","Reorder:Tag","ViewAny:User","View:User","Create:User","Update:User","Delete:User","Restore:User","ForceDelete:User","ForceDeleteAny:User","RestoreAny:User","Replicate:User","Reorder:User","ViewAny:Role","View:Role","Create:Role","Update:Role","Delete:Role","Restore:Role","ForceDelete:Role","ForceDeleteAny:Role","RestoreAny:Role","Replicate:Role","Reorder:Role","View:HomePageSettings","View:WebsiteSettings","View:OverlookWidget","View:LogTable"]},{"name":"Editor","guard_name":"web","permissions":["ViewAny:Article","View:Article","Create:Article","Update:Article","Delete:Article","Restore:Article","ForceDelete:Article","ForceDeleteAny:Article","RestoreAny:Article","Replicate:Article","Reorder:Article","ViewAny:Author","View:Author","Create:Author","Update:Author","Delete:Author","Restore:Author","ForceDelete:Author","ForceDeleteAny:Author","RestoreAny:Author","Replicate:Author","Reorder:Author","ViewAny:Category","View:Category","Create:Category","Update:Category","Delete:Category","Restore:Category","ForceDelete:Category","ForceDeleteAny:Category","RestoreAny:Category","Replicate:Category","Reorder:Category"]},{"name":"Admin","guard_name":"web","permissions":["ViewAny:Article","View:Article","Create:Article","Update:Article","Delete:Article","Restore:Article","ForceDelete:Article","ForceDeleteAny:Article","RestoreAny:Article","Replicate:Article","Reorder:Article","ViewAny:Author","View:Author","Create:Author","Update:Author","Delete:Author","Restore:Author","ForceDelete:Author","ForceDeleteAny:Author","RestoreAny:Author","Replicate:Author","Reorder:Author","ViewAny:Category","View:Category","Create:Category","Update:Category","Delete:Category","Restore:Category","ForceDelete:Category","ForceDeleteAny:Category","RestoreAny:Category","Replicate:Category","Reorder:Category","ViewAny:Menu","View:Menu","Create:Menu","Update:Menu","Delete:Menu","Restore:Menu","ForceDelete:Menu","ForceDeleteAny:Menu","RestoreAny:Menu","Replicate:Menu","Reorder:Menu","ViewAny:Page","View:Page","Create:Page","Update:Page","Delete:Page","Restore:Page","ForceDelete:Page","ForceDeleteAny:Page","RestoreAny:Page","Replicate:Page","Reorder:Page","ViewAny:Tag","View:Tag","Create:Tag","Update:Tag","Delete:Tag","Restore:Tag","ForceDelete:Tag","ForceDeleteAny:Tag","RestoreAny:Tag","Replicate:Tag","Reorder:Tag","ViewAny:User","View:User","Create:User","Update:User","Delete:User","Restore:User","ForceDelete:User","ForceDeleteAny:User","RestoreAny:User","Replicate:User","Reorder:User","ViewAny:Role","View:Role","Create:Role","Update:Role","Delete:Role","Restore:Role","ForceDelete:Role","ForceDeleteAny:Role","RestoreAny:Role","Replicate:Role","Reorder:Role","View:HomePageSettings","View:WebsiteSettings","View:OverlookWidget"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
