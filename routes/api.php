<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/pokemons', [PokemonController::class, 'showPokemons']);

Route::get('/pokemons/{id}', [PokemonController::class, 'showPokemonById']);
Route::get('/pokemons/{id}/moves', [PokemonController::class, 'showPokemonMoves']);
Route::get('/pokemons/{id}/abilities', [PokemonController::class, 'showPokemonAbilities']);
Route::get('/pokemons/{id}/evolutions', [PokemonController::class, 'showPokemonEvolutions']);
Route::get('/pokemons/{id}/base', [PokemonController::class, 'showPokemonBase']);
Route::get('/pokemons/{id}/stats', [PokemonController::class, 'showPokemonBaseStats']);

/*
To be implemented:
Multiple filters in pokemons, multiple types, multiple habitats, etc

Method to see the "destroyable","winnable","risky","avoidable" and "suicidal" matchup types of a particular pokemon
based on type_efficacy
Endpoint (with GET method)
api/pokemons/{id}/matchups


*/