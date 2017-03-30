<?php

namespace Codeheures\LaravelUtils\Traits\Tools;

use Illuminate\Support\Facades\DB;

trait Database
{
    /**
     *
     * Return the list of possibles enum values on column
     *
     * @param $table
     * @param $column
     * @return array
     */
    public static function getEnumValues($table, $column) {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_add($enum, $v, $v);
        }
        return $enum;
    }

    /**
     *
     * Return a count of element for multiple where clauses on a table
     *
     * @param $table
     * @param array $wheres
     * @return mixed
     */
    public static function getCountItems($table, $wheres = []) {

        $query = DB::table($table);

        if(count($wheres)>0){
            foreach ($wheres as $key => $where){
                $query = $query->where($key, $where);
            }
        }

        $count = $query->count();
        return $count;
    }
}