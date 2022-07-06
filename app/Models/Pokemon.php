<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PokemonType;
use App\Models\Type;


class Pokemon extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pokemon';
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

    public function evolutionMatchup(){
        return $this->hasOne(EvolutionMatchup::class, 'pok_id','pok_id');
    }
    public function baseStats(){
        return $this->hasOne(BaseStat::class,'pok_id','pok_id');
    }
    public function pokemonType(){
        return $this->hasMany(PokemonType::class,'pok_id','pok_id');
    }
    
    public static function getPokemonTypesById($id){
        $raw_types = PokemonType::where('pok_id',$id)->get();
        $types = [];
        foreach($raw_types as $raw_type){
            $types[] = Type::find($raw_type->type_id)->type_name;
        }
        return implode("-",$types);
    }


    public static function getPokemonById($id){
        $raw_info = Pokemon::find($id)->toArray();
        $raw_info['type'] = Pokemon::getPokemonTypesById($id);
        $convertedInfo = [];
        foreach($raw_info as $key => $value){
            if(!str_contains($key,'id')){
                $newKey = str_replace('pok_','',$key);
            }else{
                $newKey = $key;
            }
            $convertedInfo[$newKey] = $value;
        }
        return $convertedInfo;
    }
}
