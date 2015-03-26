<?php defined('SYSPATH') OR die('No direct access allowed.');

class Helper_PostArrayHTML {
	
	public static function convert_array($post_html_array)
	{
	   $post_array = array();  
        foreach($post_html_array as $key => $val)
        {
            if(count($val) > 1 || is_array($val))
            {
                $post_array[$key] = $val;
            }
        }
        
        $post_complete_array = array();
        array_walk($post_array, function($val,$key) use(&$post_complete_array)
        {
            foreach($val as $k=>$v)
            {
                $post_complete_array[$k][$key] = $v;
            }
        });
		
        return $post_complete_array;
    }
	
	public static function cut_array(array $result, $req_int)
	{
		foreach($result as $key=>$values)
		{
			if(count($values) != $req_int)
			{
				unset($result[$key]);
			}
		}
		
		return $result;
	}
}