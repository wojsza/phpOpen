<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Numeric
{
    public static function replace_decimal_point($value_str)
    {
//            $locale_info = localeconv();
//            $decimal_point = $locale_info['decimal_point'];
//            $value_str = str_replace(',', $decimal_point, $value_str);
//            $value_str = str_replace('.', $decimal_point, $value_str);
        
        if(is_array($value_str))
        {
            $value_str_coma = array();
            foreach($value_str as $value)
            {
                $value_str_coma[] = str_replace(",", ".", $value);
            }
            
            return $value_str_coma;
        }
        else
        {
            $value_str = str_replace(',', '.', $value_str);
            
            return $value_str;
        }

    }

	public static function parse_float($floatString)
	{
		$LocaleInfo = localeconv();
		$floatString = str_replace($LocaleInfo["mon_thousands_sep"] , "", $floatString);
		$floatString = str_replace($LocaleInfo["mon_decimal_point"] , ".", $floatString);
		return floatval($floatString);
	}
    
    public static function remove_spaces($number)
    {
        return str_replace(' ', '', $number);
    }
    
    public static function float($string)
    {
        return floatval(self::replace_decimal_point(self::remove_spaces($string)));
    }
    
    public static function int($string)
    {
        return intval(self::replace_decimal_point(self::remove_spaces($string)));
    }
	
}