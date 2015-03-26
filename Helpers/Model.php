<?php defined('SYSPATH') OR die('No direct access allowed.');

class Helper_Model {
    
    public static function zero_to_null($value)
    {
        if ($value === '0')
        {
            return NULL;
        }
        return $value;
    }
    
    public static function check_and_join(ORM $orm_object, $table, $on1_c1, $on1_op, $on1_c2, $on2_c1 = null, $on2_op = null, $on2_c2 = null)
    {
        if (!$orm_object->has_joined($table))
        {
            $orm_object = $orm_object->join($table, 'LEFT')
                ->on($on1_c1, DB::expr($on1_op), $on1_c2);
            if (!is_null($on2_c1) && !is_null($on2_op) && !is_null($on2_c2))
            {
                $orm_object = $orm_object->on($on2_c1, DB::expr($on2_op), $on2_c2);
            }
        }
        return $orm_object;
    }
    
    public static function check_and_where(ORM $orm_object, $table, $column, $op, $value)
    {
        //zawsze można rozwinąc o array jak zajdzie poczeba
        if (!$orm_object->has_where($table))
        {
            $orm_object->where($column, $op, $value);
        }
        return $orm_object;
    }
	
	public static function delete_related_values($table, $column, $op, $value)
	{
		return DB::delete($table)->where($column, $op, $value)->execute();
	}
}