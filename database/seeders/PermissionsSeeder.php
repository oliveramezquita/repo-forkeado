<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Roles Permissions
        // Permission::create(['name' => 'role.index']);
        // Permission::create(['name' => 'role.store']);
        // Permission::create(['name' => 'role.update']);
        // Permission::create(['name' => 'role.destroy']);

        // School Permissions
        // Users
        // Permission::create(['name' => 'user.register_user']);

        $this->call([
            Permissions\GroupsSeeder::class,
            Permissions\SyllabiSeeder::class,
            Permissions\DepartmentSeeder::class,
            Permissions\StudentsSeeder::class,
            Permissions\StaffSeeder::class,
            Permissions\GroupingSeeder::class,
            Permissions\InventorySeeder::class,
            Permissions\EvaluationSeeder::class,
            Permissions\TeacherSeeder::class,
            Permissions\FinanceSeeder::class,
            Permissions\UtilitySeeder::class,
            Permissions\HelpSeeder::class,
            
        ]);

        // Settings of the school
        Permission::create(['name' => 'school.settings.create']);
        Permission::create(['name' => 'school.settings.store']);
        Permission::create(['name' => 'school.settings.edit']);
        Permission::create(['name' => 'school.settings.update']);

        // Settings of the messages
        Permission::create(['name' => 'messaging.show']);
        // Permission::create(['name' => 'messaging.create']);
        // Permission::create(['name' => 'messaging.delete']);
    }
}
