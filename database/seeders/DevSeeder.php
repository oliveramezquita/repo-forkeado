<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin\SchoolYear;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\SchoolSettings;

class DevSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (config('app.env') === 'local' || config('app.env') === 'staging') {
            $amadeus = User::factory()->create([
                'email' => 'amadeus@amadeus.com',
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

            // Teacher User
            $teacher = User::factory()->create([
                'email' => 'teacher@amadeus.com',
                'name' => 'Juan Pedro',
                'password' => Hash::make('teacher'),
                'surname' => 'Palotes',
                'birth_date' => '1990-01-01',
                'photo_url' => url('storage/sample_avatar.jpeg'),
            ]);
            $teacher->assignRole('teacher');
            $teacher->assignPosition(['Profesor', 'RMI']);
            $teacher->metadata()->create([
                'phone1' => '999999999',
                'gender' => 'o',
            ]);
            $teacher->assignPosition(['RMI']);

            // Student User
            $student = User::factory()->create([
                'email' => 'student@amadeus.com',
                'name' => 'Student',
                'password' => Hash::make('student'),
                'surname' => 'Test',
                'birth_date' => '1990-01-01',
                'photo_url' => url('storage/sample_avatar.jpeg'),
            ]);
            $student->assignRole('student');
            $student->metadata()->create([
                'phone1' => '999999999',
                'gender' => 'o',
            ]);

            // Guardian User
            $guardian = User::factory()->create([
                'email' => 'guardian@amadeus.com',
                'name' => 'Guardian',
                'password' => Hash::make('guardian'),
                'surname' => 'Test',
                'birth_date' => '1990-01-01',
                'photo_url' => url('storage/sample_avatar.jpeg'),
            ]);
            $guardian->assignRole('guardian');
            $guardian->metadata()->create([
                'phone1' => '999999999',
                'gender' => 'o',
            ]);
            $student->guardians()->attach($guardian->id);

            $nico = User::factory()->create([
                'email' => 'nmeseguer@mowatave.com',
                'name' => 'Nicolás',
                'password' => Hash::make('1234'),
                'surname' => 'Meseguer',
                'birth_date' => '1990-01-01',
                'photo_url' => url('storage/sample_avatar.jpeg'),
            ]);
            $nico->assignRole('admin');
    
            $nico->metadata()->create([
                'phone1' => '666666666',
                'gender' => 'm',
            ]);

            $debug = User::factory()->create([
                'email' => 'debug@a.com',
                'name' => 'Debug',
                'password' => Hash::make('1234'),
                'surname' => 'Mode',
                'birth_date' => '1990-01-01',
                'photo_url' => url('storage/sample_avatar.jpeg'),
            ]);
            $debug->assignRole('debug');
    
            $debug->metadata()->create([
                'phone1' => '999999999',
                'gender' => 'o',
            ]);
            
            $jose = User::factory()->create([
                'email' => 'jdelaguila@mowatave.com',
                'name' => 'Jose',
                'password' => Hash::make('1234'),
                'surname' => 'Del Águila',
                'birth_date' => '1990-01-01',
                'photo_url' => url('storage/sample_avatar.jpeg'),
            ]);
            $jose->assignRole('student');
            $jose->assignRole('guardian');
    
            $jose->metadata()->create([
                'phone1' => '666666666',
                'gender' => 'm',
            ]);
    
            $marta = User::factory()->create([
                'email' => 'marta@mowatave.com',
                'name' => 'Marta',
                'password' => Hash::make('1234'),
                'surname' => 'Del Águila',
                'birth_date' => '1990-01-01',
                'photo_url' => url('storage/sample_avatar.jpeg'),
            ]);
            $marta->assignRole('student');
    
            $marta->metadata()->create([
                'phone1' => '666666666',
                'gender' => 'w',
            ]);
    
            $marta->guardians()->attach($jose->id);

            // Create the current scholar year
            SchoolYear::createScholarYear(date('Y'));

            // Create the next scholar year
            SchoolYear::createNextScholarYear();

            SchoolSettings::create([
                'school_name' => 'Amadeus-Test',
                'school_address' => 'Calle de la Música, 1',
                'school_phone' => '999999999',
                'school_cif' => 'ES-1234',
                'school_email' => 'info@amadeusmagister.com',

                'subjects_to_pass' => '0',
                'previous_subject_passed' => '0',

                'max_loans' => '3',

                'max_annual_instalments_fees' => '10',

                'current_enrollment' => '2023-10-22',
                'starting_time' => '2023-10-29',
                'ending_time' => '2024-07-31',
            ]);
        }    
    }
}