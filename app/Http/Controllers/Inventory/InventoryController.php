<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:inventory.show')->only(['show']);
    }

    public function show(Request $request)
    {
        // Create a random collection of items, each with the following fields:
        // ID, Name, Brand, Model, Serial Number, Date of acquisition, Value, Quantity.
        $items = collect([
            [
                'id' => 1,
                'type' => 'Instrumento',
                'name' => 'Item 1',
                'brand' => 'Brand 1',
                'status' => 'Disponible',
                'model' => 'Model 1',
                'serial_number' => 'Serial Number 1',
                'date_of_acquisition' => '2021-01-01',
                'value' => 100,
                'quantity' => 1,
                'observations' => [
                    [
                        'user_id' => 1,
                        'user_name' => 'User 1',
                        'user_surname' => 'Surname 1',
                        'real_return_date' => '2021-01-01',
                        'return_date' => '2021-01-01',
                    ],
                    [
                        'user_id' => 2,
                        'user_name' => 'User 2',
                        'user_surname' => 'Surname 2',
                        'real_return_date' => '2021-01-02',
                        'return_date' => '2021-01-02',
                    ],
                    [
                        'user_id' => 3,
                        'user_name' => 'User 3',
                        'user_surname' => 'Surname 3',
                        'real_return_date' => '2021-01-03',
                        'return_date' => '2021-01-03',
                    ],
                ],
            ],
            [
                'id' => 2,
                'type' => 'Instrumento',
                'name' => 'Item 2',
                'brand' => 'Brand 2',
                'status' => 'Prestamo',
                'model' => 'Model 2',
                'serial_number' => 'Serial Number 2',
                'date_of_acquisition' => '2021-01-02',
                'value' => 200,
                'quantity' => 2,
                'observations' => [
                    [
                        'user_id' => 1,
                        'user_name' => 'User 1',
                        'user_surname' => 'Surname 1',
                        'real_return_date' => '2021-01-01',
                        'return_date' => '2021-01-01',
                    ],
                    [
                        'user_id' => 2,
                        'user_name' => 'User 2',
                        'user_surname' => 'Surname 2',
                        'real_return_date' => '2021-01-02',
                        'return_date' => '2021-01-02',
                    ],
                    [
                        'user_id' => 3,
                        'user_name' => 'User 3',
                        'user_surname' => 'Surname 3',
                        'real_return_date' => '2021-01-03',
                        'return_date' => '2021-01-03',
                    ],
                ],
            ],
            [
                'id' => 3,
                'type' => 'Instrumento',
                'name' => 'Item 3',
                'brand' => 'Brand 3',
                'status' => 'Reparación',
                'model' => 'Model 3',
                'serial_number' => 'Serial Number 3',
                'date_of_acquisition' => '2021-01-03',
                'value' => 300,
                'quantity' => 3,
                'observations' => [
                    [
                        'user_id' => 1,
                        'user_name' => 'User 1',
                        'user_surname' => 'Surname 1',
                        'real_return_date' => '2021-01-01',
                        'return_date' => '2021-01-01',
                    ],
                    [
                        'user_id' => 2,
                        'user_name' => 'User 2',
                        'user_surname' => 'Surname 2',
                        'real_return_date' => '2021-01-02',
                        'return_date' => '2021-01-02',
                    ],
                    [
                        'user_id' => 3,
                        'user_name' => 'User 3',
                        'user_surname' => 'Surname 3',
                        'real_return_date' => '2021-01-03',
                        'return_date' => '2021-01-03',
                    ],
                ],
            ],
            [
                'id' => 4,
                'type' => 'Instrumento',
                'name' => 'Item 4',
                'brand' => 'Brand 4',
                'status' => 'No disponible',
                'model' => 'Model 4',
                'serial_number' => 'Serial Number 4',
                'date_of_acquisition' => '2021-01-04',
                'value' => 400,
                'quantity' => 4,
                'observations' => [
                    [
                        'user_id' => 1,
                        'user_name' => 'User 1',
                        'user_surname' => 'Surname 1',
                        'real_return_date' => '2021-01-01',
                        'return_date' => '2021-01-01',
                    ],
                    [
                        'user_id' => 2,
                        'user_name' => 'User 2',
                        'user_surname' => 'Surname 2',
                        'real_return_date' => '2021-01-02',
                        'return_date' => '2021-01-02',
                    ],
                    [
                        'user_id' => 3,
                        'user_name' => 'User 3',
                        'user_surname' => 'Surname 3',
                        'real_return_date' => '2021-01-03',
                        'return_date' => '2021-01-03',
                    ],
                ],
            ],
        ]);

        $loan_agreement = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.";

        return Inertia::render('Inventory/Show', [
            'items' => $items,
            'loan_agreement' => $loan_agreement,
        ]);
    }
}
