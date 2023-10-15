<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deparment
        Permission::create(['name' => 'department.show']);
        Permission::create(['name' => 'department.store']);
        Permission::create(['name' => 'department.update']);
        Permission::create(['name' => 'department.destroy']);
        Permission::create(['name' => 'department.activate']);

        Permission::create(['name' => 'department.subject.store']);
        Permission::create(['name' => 'department.subject.destroy']);
    }
}
