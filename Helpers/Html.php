<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Html
{
	public static function to_list($collection, $key_field, $value_field)
	{
		$list = array();
		if (!empty($collection))
		{
			foreach ($collection as $object)
			{
				if (isset($object->$key_field))
				{
					$list[$object->$key_field] = $object->$value_field;
				}
			}	
		}
		return $list;
	}
}