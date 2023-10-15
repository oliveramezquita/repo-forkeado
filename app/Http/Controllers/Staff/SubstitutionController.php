<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubstitutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:staff.substitution.show')->only(['show']);
    }

    public function show(Request $request)
    {

        // Create a collection of teachers with random names (id, name, surname, dni, substitution_state)
        $substitutions = collect([
            [
                'id' => 1,
                'name' => 'Juan',
                'surname' => 'Perez',
                'photo_url' => 'http://localhost:8000/storage/sample_avatar.jpeg',
                'state' => 'Cancelado Temporalmente',
            ],
            [
                'id' => 2,
                'name' => 'Pedro',
                'surname' => 'Garcia',
                'photo_url' => 'http://localhost:8000/storage/sample_avatar.jpeg',
                'state' => 'Asignado a otro profesor',
            ],
            [
                'id' => 3,
                'name' => 'Pablo',
                'surname' => 'Gonzalez',
                'photo_url' => 'http://localhost:8000/storage/sample_avatar.jpeg',
                'state' => 'Cambio de día',
            ],
            [
                'id' => 4,
                'name' => 'Jose',
                'surname' => 'Rodriguez',
                'photo_url' => 'http://localhost:8000/storage/sample_avatar.jpeg',
                'state' => 'Sin asignar',
            ],
        ]);

        return Inertia::render('Staff/SubstitutionShow', [
            'substitutions' => $substitutions,
        ]);
    }
}
