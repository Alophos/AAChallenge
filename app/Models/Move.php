<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Move extends Model implements IQueryAugmenter
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'moves';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'move_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function pokemonMoves(){
        return $this->hasMany(PokemonMove::class, 'move_id','move_id');
    }
    public static function getMovesByPokemonId($pokemonId){
        return Move::whereHas('pokemonMoves', function (Builder $query) use ($pokemonId) {
            $query->where('pok_id',$pokemonId);
        })->get();
    }
    public static function joinQueryWithPokemon($query){
        $moveInfo = QueryAugmenterHelper::getInfoForQuery(Move::class);
        $pokemonMovesInfo = QueryAugmenterHelper::getInfoForQuery(PokemonMove::class);
        $pokemonInfo = QueryAugmenterHelper::getInfoForQuery(Pokemon::class);

        if(!QueryAugmenterHelper::hasJoin($query,$pokemonMovesInfo["table"])){
            $query->join($pokemonMovesInfo["table"], $pokemonMovesInfo["getPrimaryKey"],$pokemonInfo["getPrimaryKey"]);
        }
        if(!QueryAugmenterHelper::hasJoin($query,$moveInfo["table"])){
            $query->join($moveInfo["table"],$moveInfo["getPrimaryKey"],$pokemonMovesInfo["table"].".".$moveInfo["primaryKey"]);
        }
        return $query;
    }
    public static function whereQueryWithPokemon($query, array $data)
    {
        $moveInfo = QueryAugmenterHelper::getInfoForQuery(Move::class);
        foreach($data as $key => $value){
            $query->where($moveInfo["table"].".".$key,$value);
        }
        return $query;   
    }

}
