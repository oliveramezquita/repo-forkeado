<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class GroupingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Grouping list, bands
        Permission::create(['name' => 'grouping.show']);
        // Permission::create(['name' => 'grouping.create']);
        // Permission::create(['name' => 'grouping.store']);
        // Permission::create(['name' => 'grouping.edit']);
        // Permission::create(['name' => 'grouping.update']);
        // Permission::create(['name' => 'grouping.destroy']);

        // Grouping member lists
        Permission::create(['name' => 'grouping.member.show']);
        // Permission::create(['name' => 'grouping.member.create']);
        // Permission::create(['name' => 'grouping.member.store']);
        // Permission::create(['name' => 'grouping.member.edit']);
        // Permission::create(['name' => 'grouping.member.update']);
        // Permission::create(['name' => 'grouping.member.destroy']);

        // Grouping instruments lists
        Permission::create(['name' => 'grouping.instrument.show']);
        // Permission::create(['name' => 'grouping.instrument.create']);
        // Permission::create(['name' => 'grouping.instrument.store']);
        // Permission::create(['name' => 'grouping.instrument.edit']);
        // Permission::create(['name' => 'grouping.instrument.update']);
        // Permission::create(['name' => 'grouping.instrument.destroy']);

        // Grouping events lists
        Permission::create(['name' => 'grouping.event.show']);
        // Permission::create(['name' => 'grouping.event.create']);
        // Permission::create(['name' => 'grouping.event.store']);
        // Permission::create(['name' => 'grouping.event.edit']);
        // Permission::create(['name' => 'grouping.event.update']);
        // Permission::create(['name' => 'grouping.event.destroy']);

        // Grouping events lists
        Permission::create(['name' => 'grouping.rehearsal.show']);
        // Permission::create(['name' => 'grouping.rehearsal.create']);
        // Permission::create(['name' => 'grouping.rehearsal.store']);
        // Permission::create(['name' => 'grouping.rehearsal.edit']);
        // Permission::create(['name' => 'grouping.rehearsal.update']);
        // Permission::create(['name' => 'grouping.rehearsal.destroy']);
    
        // Grouping sheets
        Permission::create(['name' => 'grouping.sheet.show']);
        // Permission::create(['name' => 'grouping.sheet.create']);
        // Permission::create(['name' => 'grouping.sheet.store']);
        // Permission::create(['name' => 'grouping.sheet.edit']);
        // Permission::create(['name' => 'grouping.sheet.update']);
        // Permission::create(['name' => 'grouping.sheet.destroy']);
    
    }
}
