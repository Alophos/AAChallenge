<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PokemonType extends Model
{
    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pokemon_types';
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
    use HasFactory;

    public function pokemon(){
        return $this->belongsTo(Pokemon::class,'pok_id','pok_id');
    }

    public function type(){
        return $this->belongsTo(Type::class, 'type_id', 'type_id');
    }
}
