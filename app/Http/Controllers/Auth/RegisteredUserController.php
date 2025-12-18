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
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,admin'], // Validasi role
            'nomor_induk' => ['nullable', 'string', 'max:20'], // Validasi nomor induk
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,          // Simpan role
            'nomor_induk' => $request->nomor_induk, // Simpan nomor induk
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect logika (bisa disesuaikan jika admin dan mahasiswa punya dashboard beda)
        if ($user->role === 'admin') {
            return redirect(route('dashboard', absolute: false)); // Atau ganti ke route khusus admin
        }

        return redirect(route('dashboard', absolute: false));
    }

      
}
