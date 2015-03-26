<?php defined('SYSPATH') OR die('No direct access allowed.');

class Helper_String {
	
	public static function starts_with($haystack,$needle,$case=true)
	{
	   if($case)
		   return strpos($haystack, $needle, 0) === 0;

	   return stripos($haystack, $needle, 0) === 0;
	}
    
    public static function null($value)
    {
        return (empty($value) ? NULL : $value);
    }
    
    public static function implode($glue, $array)
    {
		if ( is_array($array))
		{
			if (count($array) == 1)
			{
				return reset($array);
			}
			return implode($glue, $array);
		}
		return $array;
    }
	
	public static function label($class, $text)
    {
        $label = View::factory('components/label_universal')
                 ->bind('class', $class)
                 ->bind('text', $text)
                 ->render();
        
        return $label;
    }
	
}