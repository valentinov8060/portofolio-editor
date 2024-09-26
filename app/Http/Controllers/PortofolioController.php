<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PortofolioController extends Controller
{
    public function showPortofolio()
    {
        return view('portofolio');
    }

    public function showLogin()
    {
        // Jika user sudah login, redirect ke halaman editor
        if (Auth::check()) {
            return redirect()->route('editor page')->with('success', 'You are already logged in.');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah ada pengguna dengan name yang diberikan
        $user = User::where('name', $request->name)->first();

        // Jika pengguna ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Set session dan redirect ke halaman editor
            Auth::login($user);
            return redirect()->route('editor page')->with('success', 'Login success!');
        }

        // Jika login gagal
        return back()->withErrors([
            'name' => 'name atau password is invalid.',
        ]);
    }

    public function showEditor()
    {
        return view('editor');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login page')->with('success', 'Logout successful!');
    }
}
