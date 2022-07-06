<?php

namespace App\Models;

interface IQueryAugmenter
{
    //TODO buscar tipo de query
    public static function whereQueryWithPokemon($query, array $data);
    public static function joinQueryWithPokemon($query);
    
}