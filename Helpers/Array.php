<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Array
{	
	public static function search_array($value, $key, $array)
	{
		foreach($array as $elem)
		{
			if($elem[$key] === $value)
			{
				return $elem;
			}
		}
		return null;
	}
	
	public static function is_in_array($value, $key, $array)
	{
		$result = self::search_array($value, $key, $array);
		return isset($result);
	}
    
    public static function add_please_select(array $array)
    {
        $please_select[NULL] = Kohana::message('filter', 'please_select');
        return $please_select + $array;
    }
}