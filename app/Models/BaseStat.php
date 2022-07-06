<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseStat extends Model 
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'base_stats';
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

    public static function getBaseStatByPokemonId($id){
        return BaseStat::find($id);
    }

}
