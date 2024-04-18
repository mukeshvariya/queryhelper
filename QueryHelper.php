<?php

namespace QueryHelper;

use Illuminate\Support\Str;

class QueryHelper
{
    /**
     * Summary of leftJoin
     * 
     * This is helpful to create leftJoin with simple way rather than having a complex syntex.
     * 
     * @param mixed $query - the object of the model class
     * @param mixed $relationClass - the relation class
     * @param mixed $foreignKeyId - foreign key id, you can use own localId as well
     * @param mixed $localId - join relation id, you can use own localId as well
     * @return void - It simply be a prt of the $query
     */
    public static function leftJoin($query, $relationClass, $foreignKeyId = null, $localId = "id")
    {
        $query->leftJoin(
            app()->make($relationClass)->getTable(),
            function ($join) use ($query, $relationClass, $foreignKeyId, $localId) {
                $onClass = get_class($query->getModel());
                $foreignKeyId = !$foreignKeyId ? Str::lower(Str::of($relationClass)->explode('\\')->last()) . "_id" : $foreignKeyId;

                $join->on(app()->make($onClass)->getTable() . "." . $foreignKeyId, app()->make($relationClass)->getTable() . "." . $localId);
            }
        );
    }

    /**
     * Summary of recordManager
     * 
     * This is helpful to get user details for general columns created_by and updated_by in Laravel
     * 
     * @param mixed $query - the object of the model class
     * @param mixed $fromClass - from where you want the fromClass details
     * @param mixed $localId - join relation id, you can use own localId as well
     * @return void - It simply be a part of $query
     * 
     * Example: to read columns would be tableName_creator_first_name, 
     * 
     * tableName_creator_last_name, user_creator_first_name, user_creator_last_name
     */
    public static function recordManager($query, $fromClass, $localId = "id")
    {
        $withClass = get_class($query->getModel());

        $query->leftJoin(
            app()->make($fromClass)->getTable() . " as " . app()->make($fromClass)->getTable() . "_creator",
            function ($join) use ($withClass, $fromClass, $localId) {
                $join->on(app()->make($withClass)->getTable() . ".created_by", app()->make($fromClass)->getTable() . "_creator." . $localId);
            }
        );

        $query->leftJoin(
            app()->make($fromClass)->getTable() . " as " . app()->make($fromClass)->getTable() . "_updator",
            function ($join) use ($withClass, $fromClass, $localId) {
                $join->on(app()->make($withClass)->getTable() . ".updated_by", app()->make($fromClass)->getTable() . "_updator." . $localId);
            }
        );
    }
}
