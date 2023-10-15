<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Staff list
        Permission::create(['name' => 'staff.show']);
        // Permission::create(['name' => 'staff.update']);
        // Permission::create(['name' => 'staff.destroy']);
        // Permission::create(['name' => 'staff.activate']);

        // Staff diary
        Permission::create(['name' => 'staff.diary.show']);
        // Permission::create(['name' => 'staff.diary.update']);
        // Permission::create(['name' => 'staff.diary.destroy']);
        // Permission::create(['name' => 'staff.diary.activate']);

        // Staff substitutions
        Permission::create(['name' => 'staff.substitution.show']);
        // Permission::create(['name' => 'staff.substitutions.update']);
        // Permission::create(['name' => 'staff.substitutions.destroy']);
        // Permission::create(['name' => 'staff.substitutions.activate']);


    }
}
