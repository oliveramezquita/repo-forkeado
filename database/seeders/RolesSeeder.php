<?php

namespace Database\Seeders;

use App\Models\Staff\Position;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (config('app.env') === 'local' || config('app.env') === 'staging') {
            $debug = Role::create(['name' => 'debug']);
            $debug->givePermissionTo(Permission::all());
            $debug->revokePermissionTo([
                'degree.store',
                'department.store',
                'degree.update',
                'course.destroy',
                'subject.activate'
            ]);
        }

        // Schools Roles
        $admin = Role::create(['name' => 'admin']);
        $director = Role::create(['name' => 'director']);
        $headstudies = Role::create(['name' => 'headstudies']);
        $secretary = Role::create(['name' => 'secretary']);
        $headdepartment = Role::create(['name' => 'headdepartment']);
        $teacher = Role::create(['name' => 'teacher']);
        $concierge = Role::create(['name' => 'concierge']);
        $student = Role::create(['name' => 'student']);
        $guardian = Role::create(['name' => 'guardian']);
        $partner = Role::create(['name' => 'partner']);


        // Create the positions, 1 position correspondos to 1 role
        Position::create([
            'name' => 'Director',
            'role_id' => $director->id,
        ]);

        Position::create([
            'name' => 'Jefe de Estudios',
            'role_id' => $headstudies->id,
        ]);

        Position::create([
            'name' => 'Secretario',
            'role_id' => $secretary->id,
        ]);

        Position::create([
            'name' => 'Jefe de Departamento',
            'role_id' => $headdepartment->id,
        ]);

        Position::create([
            'name' => 'Profesor',
            'role_id' => $teacher->id,
        ]);

        Position::create([
            'name' => 'Conserje',
            'role_id' => $concierge->id,
        ]);

        // Assign all the permissions to the admin
        $admin->givePermissionTo(Permission::all());

        // Assign permissions to the head of studies
        $headstudies->givePermissionTo(Permission::all());
        $headstudies->revokePermissionTo([
            'school.settings.edit',
            'school.settings.update',
        ]);

        // Assign permissions to the secretary
        $secretary->givePermissionTo(Permission::all());
        $secretary->revokePermissionTo([
            'school.settings.edit',
            'school.settings.update',
        ]);

        // Combine both roles into director
        $director->givePermissionTo($headstudies->permissions->merge($secretary->permissions));
        $director->givePermissionTo([
            'school.settings.create',
            'school.settings.store',
            'school.settings.edit',
            'school.settings.update',
        ]);
        
        // Assign the permissions to the teacher
        $teacher->givePermissionTo([
            'syllabi.elements.show',
            'syllabi.show',
        ]);

        
        // Assign permissions to the head of department
        $headdepartment->givePermissionTo($teacher->permissions);
        // $headdepartment->givePermissionTo([
        //     '',
        // ]);

        // Assign the permissions to the concierge
        $concierge->givePermissionTo([
            'syllabi.show',
        ]);

        // Assign the permissions to the student
        $student->givePermissionTo(
            'messaging.show',
            'utility.calendar.show',
            'utility.schedule.show',
            'utility.repository.show',
            'utility.classroom.show',
            'utility.assistance.show',
        );

        // Assign the permissions to the guardian
        $guardian->givePermissionTo(
            'messaging.show',
            'utility.calendar.show',
            'utility.schedule.show',
            'utility.repository.show',
            'utility.classroom.show',
            'utility.assistance.show',
        );

        // Assign the permissions to the partner
        $partner->givePermissionTo(
            'messaging.show',
            'utility.calendar.show',
            'utility.schedule.show',
            'utility.repository.show',
            'utility.assistance.show',
        );


        // Group roles
        $gruping_director = Role::create(['name' => 'grouping_director']);
        $gruping_musician = Role::create(['name' => 'grouping_musician']);
        $gruping_archive = Role::create(['name' => 'grouping_archive']);

    }
}
