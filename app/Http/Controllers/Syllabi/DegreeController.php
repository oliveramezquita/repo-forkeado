<?php

namespace App\Http\Controllers\Syllabi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Syllabi\SyllabiBP\DegreeBP;
use Illuminate\Support\Facades\Validator;

class DegreeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:degree.store')->only('store');
        $this->middleware('can:degree.update')->only('update');
        $this->middleware('can:degree.destroy')->only('destroy');
        $this->middleware('can:degree.activate')->only('activate');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:degrees_blueprint,name', 'string', 'max:255', 'min:4'],
            'max_failed_subjects_to_pass' => ['required', 'numeric', 'min:0', 'max:99'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            DegreeBP::create([
                'name' => $request->input('name'),
                'max_failed_subjects_to_pass' => $request->input('max_failed_subjects_to_pass'),
                'is_active' => true
            ]);

            return redirect()->back()->with('success', 'degree.store');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al crear el grado.');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:degrees_blueprint,id'],
            'name' => ['required', 'string', 'max:255', 'min:4', 'unique:degrees_blueprint,name,' . $request->input('id')],
            'max_failed_subjects_to_pass' => ['required', 'numeric', 'min:0', 'max:99'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            $degree = DegreeBP::find($request->input('id'));
            $degree->name = $request->input('name');
            $degree->max_failed_subjects_to_pass = $request->input('max_failed_subjects_to_pass');
            $degree->save();

            return redirect()->back()->with('success', 'degree.update');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al actualizar el grado.');
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:degrees_blueprint,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        $degree = DegreeBP::find($request->input('id'));

        if($degree->syllabi && $degree->syllabi->count() > 0) {
            return redirect()->back()->withErrors('No se puede desactivar el grado porque está siendo usado por un plan de estudios.');
        }

        try {
            $degree->is_active = false;
            $degree->save();

            return redirect()->back()->with('success', 'degree.destroy');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al desactivar el grado.');
        }
    }

    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:degrees_blueprint,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            $degree = DegreeBP::find($request->input('id'));
            $degree->is_active = true;
            $degree->save();

            return redirect()->back()->with('success', 'degree.activate');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al activar el grado.');
        }
    }
}
