<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model implements IQueryAugmenter
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table = 'types';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'type_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function pokemonTypes(){
        return $this->hasMany(PokemonType::class,'type_id', 'type_id');
    }
    public static function joinQueryWithPokemon($query){
        $typeInfo = QueryAugmenterHelper::getInfoForQuery(Type::class);
        $pokemonTypeInfo = QueryAugmenterHelper::getInfoForQuery(PokemonType::class);
        $pokemonInfo = QueryAugmenterHelper::getInfoForQuery(Pokemon::class);

        if(!QueryAugmenterHelper::hasJoin($query,$pokemonTypeInfo["table"])){
            $query->join($pokemonTypeInfo["table"], $pokemonTypeInfo["getPrimaryKey"],$pokemonInfo["getPrimaryKey"]);
        }
        if(!QueryAugmenterHelper::hasJoin($query,$typeInfo["table"])){
            $query->join($typeInfo["table"],$typeInfo["getPrimaryKey"],$pokemonTypeInfo["table"].".".$typeInfo["primaryKey"]);
        }
        return $query;
    }
    public static function whereQueryWithPokemon($query, array $data)
    {
        $typeInfo = QueryAugmenterHelper::getInfoForQuery(Type::class);
        foreach($data as $key => $value){
            if($key != "type_name"){
                $query->where($typeInfo["table"].".".$key,$value);
            }
        }
        return $query;   
    }
}
