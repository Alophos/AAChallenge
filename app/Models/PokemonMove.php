<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonMove extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pokemon_moves';
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

    public function move(){
        return $this->belongsTo(Move::class, 'move_id','move_id');
    }
}
