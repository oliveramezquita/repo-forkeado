<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class RegisterUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user.register_user')->only('create');
    }

    /**
     * Display the admin registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // This two parameters will be required in the final version
            'gender' => ['nullable', 'in:m,w,o'],
            'phone1' => ['nullable', 'max:12'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // Cannot create a user with the admin role
        if ($request->role_id == 1) {
            return back();
        }

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            // Create a new metadata record for the user
            $user->metadata()->create([
                'gender' => $request->gender,
                'phone1' => $request->phone1,
            ]);
    
            // Assign the role to the user
            $role = Role::find($request->role_id);
            $user->assignRole($role);
    
            event(new Registered($user));

            DB::commit();
    
            return Redirect::route('admin.register');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back();
        }
    }
}
