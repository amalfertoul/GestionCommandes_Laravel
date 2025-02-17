<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compte;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showProfile()
{
    if (!Session::has('user')) {
        return redirect('/login')->with('error', 'Veuillez vous connecter.');
    }

    return view('auth.profile');
}

public function adminDashboard()
{
    if (!Session::has('user')) {
        return redirect('/login')->with('error', 'Veuillez vous connecter.');
    }

    if (Session::get('user')->profil !== 'admin') {
        return redirect('/profile')->with('error', 'Accès réservé aux administrateurs.');
    }

    return view('admin.dashboard');
}



    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|unique:comptes',
            'mot_passe' => 'required|min:6',
            'profil' => 'required|in:admin,client',
        ]);

        $compte = Compte::create([
            'login' => $request->login,
            'mot_passe' => $request->mot_passe,
            'profil' => $request->profil,
        ]);

        Session::put('user', $compte);

        return redirect('/profile');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'mot_passe' => 'required',
        ]);

        $compte = Compte::where('login', $request->login)->first();

        if ($compte && Hash::check($request->mot_passe, $compte->mot_passe)) {
            Session::put('user', $compte);
            return redirect('/profile');
        }

        return back()->withErrors(['login' => 'Identifiants incorrects']);
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login')->with('success', 'Déconnexion réussie.');
    }
}
