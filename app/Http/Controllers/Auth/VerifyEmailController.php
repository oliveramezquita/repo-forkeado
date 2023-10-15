<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke($id, $hash): RedirectResponse
    {
        // Buscar el usuario por el ID proporcionado en la URL
        $user = User::find($id);

        // Si no se encuentra al usuario, abortar
        if (!$user) {
            abort(404, 'Usuario no encontrado.');
        }

        // Si no se encuentra el usuario o ya ha verificado su correo electrónico, redirige a una página correspondiente
        if (!$user || $user->hasVerifiedEmail()) {
            return redirect(RouteServiceProvider::HOME.'?verified=1');
        }

        // Verificar si el hash coincide con el hash de email del usuario
        if (! hash_equals((string) $id, (string) $user->getKey())) {
            return abort(403, 'El ID no coincide.');
        }
        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            return abort(403, 'El hash del correo electrónico no coincide.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Authenticate the user
        auth()->login($user);

        return redirect()->route('verification.done');
    }
}
