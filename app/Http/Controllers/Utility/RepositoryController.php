<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RepositoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:utility.repository.show')->only(['show']);
    }

    public function show(Request $request)
    {
        $folders = [
            [
                'id' => 1,
                'type' => 'folder',
                'name' => 'Partituras',
                'content' => 
                [
                    [
                        'id' => 1,
                        'type' => 'file',
                        'name' => 'Sinfonía nº 5',
                        'author' => 'Beethoven',
                        'length' => '3:00',
                        'difficulty' => '05',
                        'url' => 'null',
                        'updated_at' => '2021-05-01 12:00:00',
                        'variants' => [
                            [
                                'id' => 1,
                                'type' => 'file',
                                'name' => 'Trompeta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 2,
                                'type' => 'file',
                                'name' => 'Flauta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 3,
                                'type' => 'file',
                                'name' => 'Tuba',
                                'url' => 'null',
                            ],
                        ],
                    ],
                    [
                        'id' => 2,
                        'type' => 'file',
                        'name' => 'Sinfonía nº 5',
                        'author' => 'Beethoven',
                        'length' => '3:00',
                        'difficulty' => '05',
                        'url' => 'null',
                        'variants' => [
                            [
                                'id' => 1,
                                'type' => 'file',
                                'name' => 'Trompeta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 2,
                                'type' => 'file',
                                'name' => 'Flauta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 3,
                                'type' => 'file',
                                'name' => 'Tuba',
                                'url' => 'null',
                            ],
                        ],
                    ],
                    [
                        'id' => 3,
                        'type' => 'file',
                        'name' => 'Sinfonía nº 5',
                        'author' => 'Beethoven',
                        'length' => '3:00',
                        'difficulty' => '05',
                        'url' => 'null',
                        'variants' => [
                            [
                                'id' => 1,
                                'type' => 'file',
                                'name' => 'Trompeta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 2,
                                'type' => 'file',
                                'name' => 'Flauta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 3,
                                'type' => 'file',
                                'name' => 'Tuba',
                                'url' => 'null',
                            ],
                        ]
                    ],
                    [
                        'id' => 4,
                        'type' => 'file',
                        'name' => 'Sinfonía nº 5',
                        'author' => 'Beethoven',
                        'length' => '3:00',
                        'difficulty' => '05',
                        'url' => 'null',
                        'variants' => [
                            [
                                'id' => 1,
                                'type' => 'file',
                                'name' => 'Trompeta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 2,
                                'type' => 'file',
                                'name' => 'Flauta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 3,
                                'type' => 'file',
                                'name' => 'Tuba',
                                'url' => 'null',
                            ],
                        ]
                    ],
                    [
                        'id' => 5,
                        'type' => 'file',
                        'name' => 'Sinfonía nº 5',
                        'author' => 'Beethoven',
                        'length' => '3:00',
                        'difficulty' => '05',
                        'url' => 'null',
                        'variants' => [
                            [
                                'id' => 1,
                                'type' => 'file',
                                'name' => 'Trompeta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 2,
                                'type' => 'file',
                                'name' => 'Flauta',
                                'url' => 'null',
                            ],
                            [
                                'id' => 3,
                                'type' => 'file',
                                'name' => 'Tuba',
                                'url' => 'null',
                            ],
                        ]
                    ],
                ],
            ],
            [
                'id' => 2,
                'type' => 'folder',
                'name' => 'Administración',
                'content' =>
                [
                    [
                        'id' => 1,
                        'type' => 'file',
                        'name' => 'Archivo_1',
                        'length' => '3:00',
                        'difficulty' => '05',
                    ],
                    [
                        'id' => 2,
                        'type' => 'file',
                        'name' => 'Archivo_2',
                        'length' => '3:00',
                        'difficulty' => '05',
                    ],
                    [
                        'id' => 3,
                        'type' => 'file',
                        'name' => 'Archivo_3',
                        'length' => '3:00',
                        'difficulty' => '05',
                    ],
                    [
                        'id' => 4,
                        'type' => 'file',
                        'name' => 'Archivo_4',
                        'length' => '3:00',
                        'difficulty' => '05',
                    ],
                    [
                        'id' => 5,
                        'type' => 'file',
                        'name' => 'Archivo_5',
                        'length' => '3:00',
                        'difficulty' => '05',
                    ],
                    [
                        'id' => 1,
                        'type' => 'folder',
                        'name' => 'Carpeta 01',
                        'content' =>
                        [
                            [
                                'id' => 1,
                                'type' => 'file',
                                'name' => 'Archivo_1',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                            [
                                'id' => 2,
                                'type' => 'file',
                                'name' => 'Archivo_2',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                            [
                                'id' => 3,
                                'type' => 'file',
                                'name' => 'Archivo_3',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                            [
                                'id' => 4,
                                'type' => 'file',
                                'name' => 'Archivo_4',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                            [
                                'id' => 5,
                                'type' => 'file',
                                'name' => 'Archivo_5',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                        ],
                    ],
                    [
                        'id' => 2,
                        'type' => 'folder',
                        'name' => 'Carpeta 02',
                        'content' =>
                        [
                            [
                                'id' => 1,
                                'type' => 'file',
                                'name' => 'Archivo_1',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                            [
                                'id' => 2,
                                'type' => 'file',
                                'name' => 'Archivo_2',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                            [
                                'id' => 3,
                                'type' => 'file',
                                'name' => 'Archivo_3',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                            [
                                'id' => 4,
                                'type' => 'file',
                                'name' => 'Archivo_4',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                            [
                                'id' => 5,
                                'type' => 'file',
                                'name' => 'Archivo_5',
                                'length' => '3:00',
                                'difficulty' => '05',
                            ],
                        ],
                    ],
                ],
            ],
        ];
        addUpdatedAt($folders);

        return Inertia::render('Utility/RepositoryShow', [
            'folders' => $folders,
        ]);
    }
}

function randomDate($startDate, $endDate) {
    $timestamp = mt_rand(strtotime($startDate), strtotime($endDate));
    return date("Y-m-d H:i:s", $timestamp);
}

function addUpdatedAt(&$array) {
    foreach ($array as $key => &$entry) {
        if (is_array($entry)) {
            $entry['updated_at'] = randomDate('2020-01-01', '2023-12-31');
            
            if (isset($entry['content']) && is_array($entry['content'])) {
                addUpdatedAt($entry['content']);
            }
            
            if (isset($entry['variants']) && is_array($entry['variants'])) {
                addUpdatedAt($entry['variants']);
            }
        }
    }
}
