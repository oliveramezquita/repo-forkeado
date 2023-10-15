<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Admin\SchoolSettings;
use Illuminate\Support\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        // Manage the enrollment status
        $enrollment_status = false;

        // Obtain the day of today using Carbon
        $today = Carbon::now();

        // Obtain the settings
        $settings = SchoolSettings::first();

        try {
            if(config('app.type') == 'cons') {
                // Check if today is in between the enrollment dates (current or next)
                if ($today->gte(Carbon::parse($settings->current_enrollment)) && $today->lte(Carbon::parse($settings->end_current_enrollment))) {
                    $enrollment_status = true;
                } else if ($today->gte(Carbon::parse($settings->next_enrollment)) && $today->lte(Carbon::parse($settings->end_next_enrollment))) {
                    $enrollment_status = true;
                }
            } else if (config('app.type') == 'school') {
                // Check if today's date is greater than or equal to current_enrollment or next_enrollment
                if ($today->gte(Carbon::parse($settings->current_enrollment)) || ($settings->next_enrollment && $today->gte(Carbon::parse($settings->next_enrollment)))) {
                    $enrollment_status = true;
                }
            }
        }
        catch (\Exception $e) {
            // Do nothing
        }

        // Si es un movil renderiza la otra vista
        $frontParams = [
            'enrollmentStatus' => $enrollment_status,
        ];
        if (app('isMobile')) {
            return Inertia::render('Auth/Mobile/Login', $frontParams);
        } else {
            return Inertia::render('Auth/Login', $frontParams);
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
