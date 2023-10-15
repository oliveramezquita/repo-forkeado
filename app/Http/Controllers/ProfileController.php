<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $user = [
            'id' => $request->user()->id,
            'email' => $request->user()->email,
            'photo_url' => $request->user()->photo_url,
            'name' => $request->user()->name,
            'surname' => $request->user()->surname,
            'dni' => $request->user()->dni,
            'phone' => $request->user()->metadata->phone,
            'birth_date' => $request->user()->birth_date
        ];

        // Create guaridan with Test Data
        $guardian = [
            'id' => 1,
            'email' => 'info@random.com',
            'name' => 'Pedro',
            'surname' => 'Perico de los Palotes',
            'dni' => '00000000X',
            'phone' => '666666666',
            'birth_date' => '1990-01-01',
        ];

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => $user,
            'guardian' => $guardian,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }
}
