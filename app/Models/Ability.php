<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ability extends Model implements IQueryAugmenter
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'abilities';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'abil_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function pokemonAbilities(){
        return $this->hasMany(PokemonAbility::class, 'abil_id','abil_id');
    }
    public static function getAbilitiesByPokemonId($pokemonId){
        return Ability::whereHas('pokemonAbilities', function (Builder $query) use ($pokemonId) {
            $query->where('pok_id',$pokemonId);
        })->get();
    }
    public static function joinQueryWithPokemon($query){
        $abilityInfo = QueryAugmenterHelper::getInfoForQuery(Ability::class);
        $pokemonAbilityInfo = QueryAugmenterHelper::getInfoForQuery(PokemonAbility::class);
        $pokemonInfo = QueryAugmenterHelper::getInfoForQuery(Pokemon::class);

        if(!QueryAugmenterHelper::hasJoin($query,$pokemonAbilityInfo["table"])){
            $query->join($pokemonAbilityInfo["table"], $pokemonAbilityInfo["getPrimaryKey"],$pokemonInfo["getPrimaryKey"]);
        }
        if(!QueryAugmenterHelper::hasJoin($query,$abilityInfo["table"])){
            $query->join($abilityInfo["table"],$abilityInfo["getPrimaryKey"],$pokemonAbilityInfo["table"].".".$abilityInfo["primaryKey"]);
        }
        return $query;
    }
    public static function whereQueryWithPokemon($query, array $data)
    {
        $abilityInfo = QueryAugmenterHelper::getInfoForQuery(Ability::class);
        foreach($data as $key => $value){
            $query->where($abilityInfo["table"].".".$key,$value);
        }
        return $query;   
    }
}
