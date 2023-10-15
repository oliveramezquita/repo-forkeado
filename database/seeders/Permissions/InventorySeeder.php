<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inventory list
        Permission::create(['name' => 'inventory.show']);
        // Permission::create(['name' => 'inventory.update']);
        // Permission::create(['name' => 'inventory.destroy']);
        // Permission::create(['name' => 'inventory.activate']);

        // Inventory history
        Permission::create(['name' => 'inventory.log.show']);
        // Permission::create(['name' => 'inventory.log.update']);
        // Permission::create(['name' => 'inventory.log.destroy']);
        // Permission::create(['name' => 'inventory.log.activate']);
    }
}
