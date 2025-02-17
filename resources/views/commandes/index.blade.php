@extends('layouts.app')

@section('content')


<!-- Ajout du formulaire de recherche -->
<h2>Rechercher un Produit</h2>
<form method="GET" action="{{ route('commandes.index') }}">
    <input type="text" name="search" placeholder="Rechercher un produit..." value="{{ request('search') }}">
    <button type="submit">Rechercher</button>
</form>

@if(request('search'))
    <h3>Résultats de la recherche pour "{{ request('search') }}"</h3>
    @if($produits->isEmpty())
        <p>Aucun produit trouvé.</p>
    @else
        <ul>
            @foreach($produits as $produit)
                <li>{{ $produit->nom }} - {{ $produit->prix }} €</li>
            @endforeach
        </ul>
    @endif
@endif



<h2>Nombre de Commandes par Client</h2>
<table border="1" width="100%">
    <thead>
        <tr>
            <th>Client</th>
            <th>Nombre de Commandes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($commandesParClient as $client)
        <tr>
            <td>{{ $client->nom }} {{ $client->prenom }}</td>
            <td>{{ $client->commandes_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('commandes.create') }}">Ajouter commande</a>

<h2>Liste des Commandes</h2>

<form method="GET" action="{{ route('commandes.index') }}" class="mb-4">
    <div class="form-group">
        <label for="client_id">Sélectionner un client :</label>
        <select name="client_id" id="client_id" class="form-control" onchange="this.form.submit()">
            <option value="">Tous les clients</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ isset($clientId) && $clientId == $client->id ? 'selected' : '' }}>
                    {{ $client->nom }} {{ $client->prenom }}
                </option>
            @endforeach
        </select>
    </div>
</form>

<div>Client sélectionné: {{ $clientId ?? 'Aucun' }}</div>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Client</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($commandes as $commande)
        <tr>
            <td>{{ $commande->id }}</td>
            <td>{{ $commande->date }}</td>
            <td>{{ $commande->client->nom }} {{ $commande->client->prenom }}</td>
            <td>
                <!-- Show button to toggle details -->
                <button class="btn btn-info" onclick="toggleDetails({{ $commande->id }})">Voir</button>
                <a href="{{ route('commandes.edit', $commande->id) }}">Modifier</a>
                <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <tr id="details-{{ $commande->id }}" style="display:none;">
            <td colspan="4">
                <h2>Détails de la commande #{{ $commande->id }}</h2>
                <p><strong>Client :</strong> {{ $commande->client->nom }} {{ $commande->client->prenom }}</p>
                <p><strong>Date :</strong> {{ $commande->date }}</p>

                <h3>Ajouter des produits</h3>
                <form action="{{ route('commandes.addProduct', $commande->id) }}" method="POST">
                    @csrf
                    <label for="produit_id">Produit :</label>
                    <select name="produit_id">
                        @foreach($commande->produits as $produit)
                            <option value="{{ $produit->id }}">{{ $produit->nom }} - {{ $produit->prix }} €</option>
                        @endforeach
                    </select>

                    <label for="qte_cmd">Quantité :</label>
                    <input type="number" name="qte_cmd" min="1" required>

                    <button type="submit" class="btn btn-success">Ajouter</button>
                </form>

                <h3>Produits commandés</h3>
                <table class="table" border="1" width="100%">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($commande->produits as $produit)
                        <tr>
                            <td>{{ $produit->nom }}</td>
                            <td>
                                <form action="{{ route('commandes.updateQuantity', ['commande' => $commande->id, 'produit' => $produit->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="qte_cmd" value="{{ $produit->pivot->qte_cmd }}" min="1" required>
                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                </form>
                            </td>
                            <td>{{ $produit->prix }} €</td>
                            <td>{{ $produit->pivot->qte_cmd * $produit->prix }} €</td>
                            <td>
                                <form action="{{ route('commandes.deleteProduct', ['commande' => $commande->id, 'produit' => $produit->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit de la commande ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div>
    {{ $commandes->links() }}
</div>





@push('scripts')
<script>
    function toggleDetails(commandeId) {
        let detailsRow = document.getElementById('details-' + commandeId);
        detailsRow.style.display = (detailsRow.style.display === 'none' || detailsRow.style.display === '') ? 'table-row' : 'none';
    }
</script>
@endpush

@endsection
