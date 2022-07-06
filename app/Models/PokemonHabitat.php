<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonHabitat extends Model implements IQueryAugmenter
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pokemon_habitats';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'hab_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    public function evolutionMatchups(){
        return $this->hasMany(EvolutionMatchup::class,'hab_id','hab_id');
    }
    public static function joinQueryWithPokemon($query){
        $habitatInfo = QueryAugmenterHelper::getInfoForQuery(PokemonHabitat::class);
        $evolutionInfo = QueryAugmenterHelper::getInfoForQuery(EvolutionMatchup::class);
        $pokemonInfo = QueryAugmenterHelper::getInfoForQuery(Pokemon::class);

        if(!QueryAugmenterHelper::hasJoin($query,$evolutionInfo["table"])){
            $query->join($evolutionInfo["table"], $evolutionInfo["getPrimaryKey"],$pokemonInfo["getPrimaryKey"]);
        }
        if(!QueryAugmenterHelper::hasJoin($query,$habitatInfo["table"])){
            $query->join($habitatInfo["table"],$habitatInfo["getPrimaryKey"],$evolutionInfo["table"].".".$habitatInfo["primaryKey"]);
        }
        return $query;
    }
    public static function whereQueryWithPokemon($query, $data){
        $habitatInfo = QueryAugmenterHelper::getInfoForQuery(PokemonHabitat::class);
        foreach($data as $key => $value){
            $query->where($habitatInfo["table"].".".$key,$value);
        }
        return $query;
    }
}



