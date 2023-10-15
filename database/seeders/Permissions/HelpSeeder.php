<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class HelpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Suggestions
        Permission::create(['name' => 'help.tutorial.show']);

        // Suggestions
        Permission::create(['name' => 'help.support.show']);

        // Suggestions
        Permission::create(['name' => 'help.suggestion.show']);
        // Permission::create(['name' => 'suggestions.create']);
        // Permission::create(['name' => 'suggestions.store']);
        // Permission::create(['name' => 'suggestions.edit']);
        // Permission::create(['name' => 'suggestions.update']);
        // Permission::create(['name' => 'suggestions.destroy']);
    }
}
