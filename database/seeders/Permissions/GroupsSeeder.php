<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Collective groups
        Permission::create(['name' => 'group.show']);
        // Permission::create(['name' => 'group.update']);
        // Permission::create(['name' => 'group.destroy']);
        // Permission::create(['name' => 'group.activate']);

        // Individual groups
        Permission::create(['name' => 'group.individual.show']);
        // Permission::create(['name' => 'group.individual.update']);
        // Permission::create(['name' => 'group.individual.destroy']);
        // Permission::create(['name' => 'group.individual.activate']);

        // Grid groups
        Permission::create(['name' => 'group.grid.show']);
        // Permission::create(['name' => 'group.grid.update']);
        // Permission::create(['name' => 'group.grid.destroy']);
        // Permission::create(['name' => 'group.grid.activate']);

        // Schedule groups
        Permission::create(['name' => 'group.schedule.show']);
        // Permission::create(['name' => 'group.schedule.update']);
        // Permission::create(['name' => 'group.schedule.destroy']);
        // Permission::create(['name' => 'group.schedule.activate']);


    }
}
