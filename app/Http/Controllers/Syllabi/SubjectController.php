<?php

namespace App\Http\Controllers\Syllabi;

use App\Http\Controllers\Controller;
use App\Models\Syllabi\SyllabiBP\SubjectBP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:subject.store')->only('store');
        $this->middleware('can:subject.update')->only('update');
        $this->middleware('can:subject.destroy')->only('destroy');
        $this->middleware('can:subject.activate')->only('activate');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:subjects_blueprint,name'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'school_hours' => ['required', 'numeric', 'min:0', 'max:100'],
            'switch_is_mandatory' => ['required', 'boolean'],
            'price' => ['required', 'numeric', 'min:0', 'max:1000'],
            'switch_is_collective' => ['required', 'boolean'],
            'student_ratio' => ['required', 'numeric', 'min:0'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            SubjectBP::create([
                'name' => $request->input('name'),
                'department_id' => $request->input('department_id'),
                'school_hours' => $request->input('school_hours'),
                'is_mandatory' => $request->input('switch_is_mandatory'),
                'price' => $request->input('price'),
                'is_collective' => $request->input('switch_is_collective'),
                'student_ratio' => $request->input('student_ratio'),
                'is_active' => true
            ]);

            return redirect()->back()->with('success', '¡Asignatura creada correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al crear la asignatura.');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:subjects_blueprint,id'],
            'name' => ['required', 'unique:subjects_blueprint,name,' . $request->input('id')],
            'school_hours' => ['required', 'numeric', 'min:0', 'max:100'],
            'switch_is_mandatory' => ['required', 'boolean'],
            'price' => ['required', 'numeric', 'min:0', 'max:1000'],
            'switch_is_collective' => ['required', 'boolean'],
            'student_ratio' => ['required', 'numeric', 'min:0'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            SubjectBP::find($request->input('id'))->update([
                'name' => $request->input('name'),
                'school_hours' => $request->input('school_hours'),
                'is_mandatory' => $request->input('switch_is_mandatory'),
                'price' => $request->input('price'),
                'is_collective' => $request->input('switch_is_collective'),
                'student_ratio' => $request->input('student_ratio'),
            ]);

            return redirect()->back()->with('success', '¡Asignatura actualizada correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al actualizar la asignatura.');
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:subjects_blueprint,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        $subject = SubjectBP::find($request->input('id'));

        if($subject->syllabi && $subject->syllabi()->count() > 0) {
            return redirect()->back()->withErrors('No se puede desactivar la asignatura porque está siendo usada por un plan de estudios.');
        }

        try {
            $subject->is_active = false;
            $subject->save();

            return redirect()->back()->with('success', '¡Asignatura desactivada correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al desactivar la asignatura.');
        }
    }

    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:subjects_blueprint,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            SubjectBP::find($request->input('id'))->update([
                'is_active' => true
            ]);

            return redirect()->back()->with('success', '¡Asignatura activada correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al activar la asignatura.');
        }
    }
}
