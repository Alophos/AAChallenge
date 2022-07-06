<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;
use App\Models\PokemonHabitat;
use App\Models\Type;
use App\Models\Move;
use App\Models\Ability;
use App\Models\BaseStat;
use App\Models\EvolutionMatchup;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;


const POKEMONS_QUERY_PARAMS = [
    "type",
    "habitat", 
    "move", 
    "ability"
];

class PokemonController extends Controller
{
    function augmentQueryWithJoin($key, $query){
        switch($key){
            case 'habitat':
                return PokemonHabitat::joinQueryWithPokemon($query);
            case 'move':
                return Move::joinQueryWithPokemon($query);
            case 'ability':
                return Ability::joinQueryWithPokemon($query);
            default:
                return $query;
        }
    }
    function augmentQueryWithWhere($key, $value, $query){
        switch($key){
            case 'type':
                return Type::whereQueryWithPokemon($query,["type_name" => $value]);
            case 'habitat':
                return PokemonHabitat::whereQueryWithPokemon($query,["hab_name" => $value]);
            case 'move':
                return Move::whereQueryWithPokemon($query,["move_name" => $value]);
            case 'ability':
                return Ability::whereQueryWithPokemon($query,["abil_name" => $value]);
            default:
                return $query;
        }
    }
    function augmentByQueryParams($baseQuery, $queryParams){
        foreach($queryParams as $key => $value){
            if(in_array($key,POKEMONS_QUERY_PARAMS)){                
                $baseQuery = $this->augmentQueryWithJoin($key, $baseQuery);
            }
        }
        foreach($queryParams as $key => $value){
            if(in_array($key,POKEMONS_QUERY_PARAMS)){                
                $baseQuery = $this->augmentQueryWithWhere($key, $value, $baseQuery);
            }
        }
        return $baseQuery;
    }
    public function showPokemons(Request $request){
        $baseQuery = DB::table('pokemon');
        $baseQuery = Type::joinQueryWithPokemon($baseQuery);
        $queryParams = $request->all();
        $baseQuery = $this->augmentByQueryParams($baseQuery,$queryParams); 
        
        $baseQuery->selectRaw('pokemon.pok_id as "pok_id", pokemon.pok_name as name,
            pokemon.pok_height as height, pokemon.pok_weight as weight, pokemon.pok_base_experience
            as experience, group_concat(distinct types.type_name) as "type"');
        $baseQuery->groupBy('pokemon.pok_id');
        if(array_key_exists("type",$queryParams)){
            $baseQuery->havingRaw("Find_in_set('".$queryParams["type"]."',type)>0");
        }
        $pokemons = $baseQuery->get();
        return response($pokemons,200);   
    }
    
    public function showPokemonById($id){
        $expectedErrors = $this->validatePokemonId($id);
        return $this->validateResponse(Pokemon::class,'getPokemonById',$id,$expectedErrors);
    }
    public function showPokemonMoves($id){
        $expectedErrors = $this->validatePokemonId($id);
        return $this->validateResponse(Move::class,'getMovesByPokemonId',$id,$expectedErrors);
    }
    public function showPokemonAbilities($id){
        $expectedErrors = $this->validatePokemonId($id);
        return $this->validateResponse(Ability::class,'getAbilitiesByPokemonId',$id,$expectedErrors);
    }
    public function showPokemonEvolutions($id){
        $expectedErrors = $this->validatePokemonId($id);
        return $this->validateResponse(EvolutionMatchup::class,'getEvolutionsByPokemonId',$id,$expectedErrors);
    }
    public function showPokemonBase($id){
        $expectedErrors = $this->validatePokemonId($id);
        return $this->validateResponse(EvolutionMatchup::class,'getBaseByPokemonId',$id,$expectedErrors);
    }
    public function showPokemonBaseStats($id){
        $expectedErrors = $this->validatePokemonId($id);
        return $this->validateResponse(BaseStat::class,'getBaseStatByPokemonId',$id,$expectedErrors);
    }

    function validatePokemonId($id){
        $messageBag = new MessageBag();
        $messageBag->addIf(!isset($id) || !$id,"id","no id given");
        $messageBag->addIf(!(int)$id,"id","id (".$id.") with invalid data type: ".gettype($id));
        return $messageBag;
    }
    function validateResponse($class,$method,$param, $errors){
        if($errors->isEmpty()){
            try{
                return response(json_encode($class::$method($param)), 200);
            }catch(Throwable $e){
                dd($e->getMessage());
                //report unexpected error to an error monitoring service
                $errors->add("server_error","an unexpected error has occurred, please contact a dev with the following info ".$e->getMessage());
            }
        }
        $errorCode = $errors->get("server_error") ? 500 : 400;
        return response(json_encode($errors->all()),$errorCode);
    }
}
