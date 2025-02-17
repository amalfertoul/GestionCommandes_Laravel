@extends('layouts.app')

@section('content')
<h2>Profil</h2>
<p>Login : {{ session('user')->login }}</p>
<p>Profil : {{ session('user')->profil }}</p>

@if(session('user')->profil === 'admin')
    <a href="{{ route('admin.dashboard') }}">Accéder au tableau de bord Admin</a>
@endif

<a href="{{ route('logout') }}">Déconnexion</a>
@endsection
