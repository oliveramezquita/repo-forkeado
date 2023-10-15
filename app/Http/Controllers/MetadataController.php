<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MetadataController extends Controller
{

    /**
     * Display the user's metadata profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Metadata/Edit');
    }

    /**
     * Update the user's metadata information.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone1' => ['required', 'max:12'],
            'gender' => ['required', 'in:m,w,o'],
        
            'student_murciaeduca_id' => [
                'nullable',
                'unique:metadata,student_murciaeduca_id,' . $request->user()->metadata->id,
            ],
            'student_number' => [
                'nullable',
                'unique:metadata,student_number,' . $request->user()->metadata->id,
            ],
            'professor_number' => [
                'nullable',
                'unique:metadata,professor_number,' . $request->user()->metadata->id,
            ],
            'professor_social_security' => [
                'nullable',
                'unique:metadata,professor_social_security,' . $request->user()->metadata->id,
            ],
            'member_number' => [
                'nullable',
                'unique:metadata,member_number,' . $request->user()->metadata->id,
            ],
        ]);

        $request->user()->metadata->update($validated); 

        return back();
    }
}
