<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Role
{
	/**
	 * Pobiera role po nazwie. W przypadku nie odnalezienia roli zwrace bool false;
	 * @param type $role_name
	 * @return boolean
	 */
    public static function get_by_name($role_name)
	{
		$role = ORM::factory('Role')->where('name', '=', $role_name)->find();
		if ($role->loaded())
		{
			return $role;
		}
		return false;
	}
	
	public static function user_has_role_name(Model_User $user, $role_name)
	{
		$role = self::get_by_name($role_name);
		if ($user->has('roles', $role))
		{
			return true;
		}
		return false;
	}
}