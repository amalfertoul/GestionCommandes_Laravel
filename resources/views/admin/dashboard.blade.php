@extends('layouts.app')

@section('content')
    <h1>Tableau de bord Administrateur</h1>
    <p>Bienvenue, {{ session('user')->login }}!</p>

    <ul>
        <li><a href="{{ route('profile') }}">Voir mon profil</a></li>
        <li><a href="{{ route('logout') }}">Déconnexion</a></li>
    </ul>
@endsection
