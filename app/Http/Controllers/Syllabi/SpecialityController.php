<?php

namespace App\Http\Controllers\Syllabi;

use App\Http\Controllers\Controller;
use App\Models\Syllabi\SyllabiBP\SpecialityBP;
use App\Models\Syllabi\SyllabiBP\SubjectBP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SpecialityController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:speciality.store')->only('store');
        $this->middleware('can:speciality.update')->only('update');
        $this->middleware('can:speciality.destroy')->only('destroy');
        $this->middleware('can:speciality.activate')->only('activate');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:specialities_blueprint,name'],
            'department_id' => ['nullable', 'exists:departments,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();

            $speciality = SpecialityBP::create([
                'name' => $request->input('name'),
                'is_active' => true,
            ]);

            // At the same time we will create two subjects for the speciality
            SubjectBP::create([
                'name' => $request->input('name') . ' - Individual',
                'speciality_id' => $speciality->id,
                'department_id' => $request->input('department_id'),
                'is_collective' => false,
                'student_ratio' => 1,
                'is_active' => true,
            ]);

            SubjectBP::create([
                'name' => $request->input('name') . ' - Colectiva',
                'speciality_id' => $speciality->id,
                'department_id' => $request->input('department_id'),
                'is_collective' => true,
                'student_ratio' => 8,
                'is_active' => true,
            ]);

            DB::commit();

            return redirect()->back()->with('success', '¡Especialidad creada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al crear la especialidad.');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:specialities_blueprint,id'],
            'name' => ['required', 'unique:specialities_blueprint,name,' . $request->input('id')],
            'department_id' => ['nullable', 'exists:departments,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();

            $speciality = SpecialityBP::find($request->input('id'));

            // For each subject, update the name
            foreach($speciality->subjects as $subject) {
                // Replace the old name with the new one
                $subject->name = str_replace($speciality->name, $request->input('name'), $subject->name);
                $subject->department_id = $request->input('department_id');
                $subject->save();
            }
            $speciality->name = $request->input('name');
            $speciality->save();

            DB::commit();
            
            return redirect()->back()->with('success', '¡Especialidad actualizada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al actualizar la especialidad.');
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:specialities_blueprint,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        $speciality = SpecialityBP::find($request->input('id'));

        if($speciality->syllabis && $speciality->syllabis->count() > 0) {
            return redirect()->back()->withErrors('No se puede desactivar la especialidad porque está siendo usada por un plan de estudios.');
        }

        try {
            DB::beginTransaction();

            foreach($speciality->subjects as $subject) {
                $subject->is_active = false;
                $subject->save();
            }
            $speciality->is_active = false;
            $speciality->save();

            DB::commit();

            return redirect()->back()->with('success', '¡Especialidad desactivada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al desactivar la especialidad.');
        }
    }

    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:specialities_blueprint,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();

            $speciality = SpecialityBP::find($request->input('id'));

            foreach($speciality->subjects as $subject) {
                $subject->is_active = true;
                $subject->save();
            }
            $speciality->is_active = true;
            $speciality->save();

            DB::commit();

            return redirect()->back()->with('success', '¡Especialidad activada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al activar la especialidad.');
        }
    }

}
