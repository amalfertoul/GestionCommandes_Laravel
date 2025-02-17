<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    // public function index() {
    //     $commandes = Commande::paginate(10);
    //     // Nombre de commandes par client
    //     $commandesParClient = Client::withCount('commandes')->get();
    //     return view('commandes.index', compact('commandes'));
    // }
    public function index(Request $request)
    {

        $clientId = $request->get('client_id');
        $search = $request->get('search');
        $query = Commande::with('client', 'produits');

        
        // Récupérer tous les clients pour le formulaire de recherche
 
        $clients = Client::all();

        // Récupérer le nombre de commandes par client
        $commandesParClient = Client::withCount('commandes')->get();

        //recherche
        $clientId = $request->input('client_id'); // Récupérer l'ID du client sélectionné


         // Filtrer les commandes en fonction du client sélectionné

        if ($clientId) {
            $query->where('client_id', $clientId);
        }

        if (!$clientId) {
            $commandes = Commande::paginate(10);
        } else {
            $commandes = Commande::where('client_id', $clientId)->paginate(10);
        }
    
        $produitsQuery = Produit::query();
            if ($search) {
                $produitsQuery->where('nom', 'LIKE', "%{$search}%")
                            ->orWhere('description', 'LIKE', "%{$search}%");
            }
        $produits = $produitsQuery->get();

        // Passer les commandes, les clients et le nombre de commandes par client à la vue
        return view('commandes.index', compact('commandes', 'commandesParClient', 'clients','clientId','produits', 'search'));
    }

    public function create() {
        $clients = Client::all();
        //$produits = Produit::all();
        return view('commandes.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date|before_or_equal:today',
        ]);

        // Crée une nouvelle commande
        $commande = Commande::create([
            'client_id' => $request->client_id,
            'date' => $request->date,
        ]);
        
        return redirect()->route('commandes.index')->with('success', 'Commande créée avec succès!');
    }

    // public function show($id) {
    //     $commande = Commande::with('client', 'produits')->findOrFail($id);
    //     $produits = Produit::all();
    //     return view('commandsaes.index', compact('commande', 'produits'));
    // }





    public function edit(Commande $commande) {
        $clients = Client::all();
       // $produits = Produit::all();
        return view('commandes.edit', compact('commande', 'clients'));
    }

    public function update(Request $request, $id)
    {
        // Valider les données
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date|before_or_equal:today',
        ]);
        // Récupérer la commande
        $commande = Commande::findOrFail($id);
        $commande->update([
            'client_id' => $request->client_id,
            'date' => $request->date,
        ]);
  
        // Ajouter le produit à la commande (via la relation many-to-many)
        //$commande->produits()->attach($request->produit_id, ['qte_cmd' => $request->qte_cmd]);

        return redirect()->route('commandes.index')->with('success', 'Produit ajouté à la commande');
    }

    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès.');
    }




    // Method to update the quantity of a product in the commande
    public function updateQuantity(Request $request, Commande $commande, Produit $produit)
    {
        // Validate the quantity input
        $validated = $request->validate([
            'qte_cmd' => 'required|integer|min:1',
        ]);

        // Update the quantity for the product in the pivot table
        $commande->produits()->updateExistingPivot($produit->id, [
            'qte_cmd' => $validated['qte_cmd'],
        ]);

        return redirect()->route('commandes.show', $commande->id)->with('success', 'Quantité mise à jour avec succès');
    }

    // Method to delete a product from the commande
    public function deleteProduct(Commande $commande, Produit $produit)
    {
        // Detach the product from the order (delete the product from the pivot table)
        $commande->produits()->detach($produit->id);

        return redirect()->route('commandes.show', $commande->id)->with('success', 'Produit supprimé avec succès');
    }
 

    // Method to add a product to the order
public function addProduct(Request $request, Commande $commande)
{
    $validated = $request->validate([
        'produit_id' => 'required|exists:produits,id',
        'qte_cmd' => 'required|integer|min:1',
    ]);

    // Attach the product to the order with the specified quantity
    $commande->produits()->attach($validated['produit_id'], [
        'qte_cmd' => $validated['qte_cmd'],
    ]);

    return redirect()->route('commandes.show', $commande->id)->with('success', 'Produit ajouté à la commande');
}

}
