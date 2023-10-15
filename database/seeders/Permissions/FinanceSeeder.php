<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class FinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (config('app.type') == 'school') {
            // Finance diary
            Permission::create(['name' => 'finance.balance.show']);
            // Permission::create(['name' => 'finance.balance.update']);
            // Permission::create(['name' => 'finance.balance.destroy']);
            // Permission::create(['name' => 'finance.balance.activate']);
    
            // Finance income
            Permission::create(['name' => 'finance.income.show']);
            // Permission::create(['name' => 'finance.income.update']);
            // Permission::create(['name' => 'finance.income.destroy']);
            // Permission::create(['name' => 'finance.income.activate']);
    
            // Finance expenses
            Permission::create(['name' => 'finance.outcome.show']);
            // Permission::create(['name' => 'finance.outcome.update']);
            // Permission::create(['name' => 'finance.outcome.destroy']);
            // Permission::create(['name' => 'finance.outcome.activate']);
        }
    }
}
