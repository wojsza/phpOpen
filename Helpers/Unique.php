<?php
class Helper_Unique
{
    public static function check_unique($value, $operator, $column, $model)
    {
        $check = ORM::factory($model)->where($column, $operator, $value)->count_all();
        
        if($check > 0 || empty($value))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}
