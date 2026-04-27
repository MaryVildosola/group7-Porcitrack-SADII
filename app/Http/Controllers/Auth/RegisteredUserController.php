<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * This is the method your error says is missing.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,farm_worker'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => true, // Ensure status is set to true/1
        ]);

        event(new Registered($user));

        // Log the user in to create the Laravel Session
        Auth::login($user);

        // Role-based redirect
        $role = strtolower(trim($user->role ?? ''));

        if ($role === 'admin') {
            return redirect('/admin/dashboard');
        }

        if ($role === 'farm_worker' || $role === 'worker') {
            return redirect('/worker/dashboard');
        }

        return redirect()->route('dashboard');
    }
}