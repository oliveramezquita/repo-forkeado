<?php

namespace App\Http\Controllers\Syllabi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Syllabi\SyllabiBP\CourseBP;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:course.store')->only('store');
        $this->middleware('can:course.update')->only('update');
        $this->middleware('can:course.destroy')->only('destroy');
        $this->middleware('can:course.activate')->only('activate');
    }

    public function store(Request $request)
    {
        $numberToNameDict = CourseBP::allowedNamesToDict();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:courses_blueprint,name', 'in:' . implode(',', $numberToNameDict)],
            'number' => ['required', 'unique:courses_blueprint,number', 'in:' . implode(',', array_keys($numberToNameDict))],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            CourseBP::create([
                'name' => $request->input('name'),
                'number' => $request->input('number'),
                'is_active' => true
            ]);

            return redirect()->back()->with('success', '¡Curso creado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al crear el curso.');
        }
    }

    public function update(Request $request)
    {
        $numberToNameDict = CourseBP::allowedNamesToDict();

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:courses_blueprint,id'],
            'name' => ['required', 'in:' . implode(',', $numberToNameDict), 'unique:courses_blueprint,name,' . $request->input('id')],
            'number' => ['required', 'in:' . implode(',', array_keys($numberToNameDict)), 'unique:courses_blueprint,number,' . $request->input('id')],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            $course = CourseBP::find($request->input('id'));
            $course->name = $request->input('name');
            $course->number = $request->input('number');
            $course->save();

            return redirect()->back()->with('success', '¡Curso actualizado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al actualizar el curso.');
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:courses_blueprint,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        $course = CourseBP::find($request->input('id'));

        if($course->syllabi && $course->syllabi->count() > 0) {
            return redirect()->back()->withErrors('No se puede desactivar el curso porque está siendo usado por un plan de estudios.');
        }

        try {
            $course->is_active = false;
            $course->save();

            return redirect()->back()->with('success', '¡Curso desactivado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al desactivar el curso.');
        }
    }

    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:courses_blueprint,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            $course = CourseBP::find($request->input('id'));
            $course->is_active = true;
            $course->save();

            return redirect()->back()->with('success', '¡Curso activado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al activar el curso.');
        }
    }
}
