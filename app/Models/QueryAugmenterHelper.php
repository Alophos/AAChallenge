<?php

namespace App\Models;

class QueryAugmenterHelper
{
    public static function getInfoForQuery($class){
        $helper = new $class();
        return [
            "table" => $helper->getTable(),
            "primaryKey" => $helper->getKeyName(),
            "getPrimaryKey" => $helper->getTable().".".$helper->getKeyName()
        ];
    }
    public static function hasJoin(\Illuminate\Database\Query\Builder $Builder, $table)
    {
        if(isset($Builder->joins)){
            foreach($Builder->joins as $JoinClause)
            {
                if($JoinClause->table == $table)
                {
                    return true;
                }
            }
            return false;
        }else{
            return false;
        }
    }
}