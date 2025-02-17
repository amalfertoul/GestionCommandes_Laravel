<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;

// use App\Http\Controllers\Controleur_1;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/',function(){
//     return view('profil');
// });


use App\Http\Controllers\CommandeController;

// Routes pour les commandes
Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');
Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');

Route::get('/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update'); 
Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');
// Route de recherche pour filtrer les commandes par client
// Route::get('commandes/delete'.function(){
//     return view('commandes.delete');
// })->name('commandes.delete');


// Route to update the product quantity in the order
Route::put('/commandes/{commande}/produits/{produit}', [CommandeController::class, 'updateQuantity'])->name('commandes.updateQuantity');

// Route to delete a product from the order
Route::delete('/commandes/{commande}/produits/{produit}', [CommandeController::class, 'deleteProduct'])->name('commandes.deleteProduct');


Route::post('/commandes/{commande}/add-product', [CommandeController::class, 'addProduct'])->name('commandes.addProduct');






Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/profile', function () {
    if (!Session::has('user')) {
        return redirect('/login')->with('error', 'Veuillez vous connecter.');
    }
    return view('auth.profile');
})->name('profile');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', function () {
    if (!Session::has('user') || Session::get('user')->profil !== 'admin') {
        return redirect('/login')->with('error', 'Accès réservé aux administrateurs.');
    }
    return view('admin.dashboard');
})->name('admin.dashboard');
