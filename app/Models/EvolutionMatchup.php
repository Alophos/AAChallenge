<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvolutionMatchup extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pokemon_evolution_matchup';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pok_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function pokemon(){
        return $this->belongsTo(Pokemon::class,'pok_id','pok_id');
    }
    public function habitat(){
        return $this->belongsTo(PokemonHabitat::class,'hab_id','hab_id');
    }
    public static function getBaseByPokemonId($id){
        $evolutionRelation = EvolutionMatchup::where('pok_id',$id)->first();
        $idBase = null;
        if(isset($evolutionRelation)){
            $idBase = $evolutionRelation->evolves_from_species_id;
        }
        if($idBase == null){
            return Pokemon::getPokemonById($id);
        }
        return EvolutionMatchup::getBaseByPokemonId($idBase);
    }
    public static function getEvolutionsByPokemonId($id, $first=true, &$evolutions=[]){
        $evolutionRelation = EvolutionMatchup::where('evolves_from_species_id',$id)->first();
        $idEvolution = null;
        if(isset($evolutionRelation)){
            $idEvolution = $evolutionRelation->pok_id;
            $evolution = Pokemon::getPokemonById($idEvolution);
            $evolutions[] = $evolution;
            EvolutionMatchup::getEvolutionsByPokemonId($idEvolution, false, $evolutions);
        }
        if($first){
            return $evolutions;
        }
    }
}
