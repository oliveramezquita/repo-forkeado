<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncidenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:utility.incidence.show')->only(['show']);
    }

    public function show(Request $request)
    {
        // Each incidence stores a title, a date, a group ("Sección de Grupos" or "Sección de Alumnos"), a subject, a description, and then
        // a status ("planned", "in_progress" y "done") and a priority ("low", "mid" y "high")
        $incidences = [
            [
                'id' => 1,
                'title' => 'Incidencia 1',
                'date' => '2021-01-01',
                'group' => 'Sección Calendario',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae aliquam ultricies, nunc nisl aliquet nunc, vi
                tae aliquam nisl nunc sit ame',
                'status' => 'planned',
                'priority' => 'low'
            ],
            [
                'id' => 2,
                'title' => 'Incidencia 2',
                'date' => '2021-01-01',
                'group' => 'Sección Calendario',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae aliquam ultricies, nunc nisl aliquet nunc, vi
                tae aliquam nisl nunc sit ame',
                'status' => 'planned',
                'priority' => 'low'
            ],
            [
                'id' => 3,
                'title' => 'Incidencia 3',
                'date' => '2021-01-01',
                'group' => 'Sección Inventario',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae aliquam ultricies, nunc nisl aliquet nunc, vi
                tae aliquam nisl nunc sit ame',
                'status' => 'planned',
                'priority' => 'mid'
            ],

            
            [
                'id' => 4,
                'title' => 'Incidencia 4',
                'date' => '2021-01-01',
                'group' => 'Sección Grupos',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae aliquam ultricies, nunc nisl aliquet nunc, vi
                tae aliquam nisl nunc sit ame',
                'status' => 'in_progress',
                'priority' => 'high'
            ],


            [
                'id' => 5,
                'title' => 'Incidencia 5',
                'date' => '2021-01-01',
                'group' => 'Sección Inventario',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae aliquam ultricies, nunc nisl aliquet nunc, vi
                tae aliquam nisl nunc sit ame',
                'status' => 'done',
                'priority' => 'mid'
            ],
            [
                'id' => 6,
                'title' => 'Incidencia 6',
                'date' => '2021-01-01',
                'group' => 'Sección Grupos',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl vitae aliquam ultricies, nunc nisl aliquet nunc, vi
                tae aliquam nisl nunc sit ame',
                'status' => 'done',
                'priority' => 'high'
            ],


        ];

        return Inertia::render('Utility/IncidenceShow', [
            'incidences' => $incidences
        ]);
    }
}
