<?php defined('SYSPATH') or die('No direct script access.');

class Helper_User
{	
	
	public static function has_role($role_name)
	{
		$user = Auth::instance()->get_user();
		if ($user->loaded())
		{
			if ($user->roles->where('name', '=', $role_name)->count_all())
			{
				return true;
			}
		}
		return false;
	}
}