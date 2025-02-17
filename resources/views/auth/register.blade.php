@extends('layouts.app')

@section('content')
<h2>Inscription</h2>
<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="login" placeholder="Login" required>
    <input type="password" name="mot_passe" placeholder="Mot de passe" required>
    <select name="profil">
        <option value="client">Client</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">S'inscrire</button>
</form>
<p>Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
@endsection
