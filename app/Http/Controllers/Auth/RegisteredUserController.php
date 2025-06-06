<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
// app/Http/Controllers/Auth/RegisteredUserController.php

// ... (use statements lainnya)
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    // ... (method create() biarkan apa adanya)

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nim' => ['required', 'string', 'max:255', 'unique:'.User::class], // Tambahkan ini
            'nomor_telepon' => ['required', 'string', 'max:20'], // Tambahkan ini
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim, // Tambahkan ini
            'nomor_telepon' => $request->nomor_telepon, // Tambahkan ini
            'role' => 'mahasiswa', // Secara default, yang mendaftar adalah mahasiswa
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}