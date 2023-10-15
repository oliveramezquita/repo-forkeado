<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main Admin User
        $amadeus = User::factory()->create([
            'email' => 'admin@amadeusmagister.com',
            'name' => 'Amadeus',
            'password' => Hash::make('amadeus'),
            'surname' => 'Magister',
            'birth_date' => '1990-01-01',
            'photo_url' => url('storage/sample_avatar.jpeg'),
        ]);
        $amadeus->assignRole('admin');
        $amadeus->metadata()->create([
            'phone1' => '999999999',
            'gender' => 'o',
        ]);

        $teacher = User::factory()->create([
            'email' => 'teacher@amadeusmagister.com',
            'name' => 'Nicolás',
            'password' => Hash::make('teacher'),
            'surname' => 'Galvez',
            'birth_date' => '1990-01-01',
            'photo_url' => url('storage/sample_avatar.jpeg'),
        ]);
        $teacher->assignRole('teacher');
        $teacher->assignPosition(['Profesor']);
        $teacher->metadata()->create([
            'phone1' => '999999999',
            'gender' => 'o',
        ]);
    }
}
