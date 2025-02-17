@extends('layouts.app')

@section('content')
<h2>Connexion</h2>
<form action="{{ route('login') }}" method="POST">
    @csrf
    <input type="text" name="login" placeholder="Login" required>
    <input type="password" name="mot_passe" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
<p>Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>
@endsection
