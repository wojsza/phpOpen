<?php defined('SYSPATH') OR die('No direct access allowed.');

class Helper_Date {
    public static function validate($parm)
    {
        if(!preg_match( "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $parm)) 
        {
            return false;
        }
        return true;
    }
    
    public static function get_today($add_period = false, $start_date = null)
    {
        $date_object = new DateTime($start_date);
        
        if($add_period !== false)
        {
            $date_object->modify($add_period);
        }
        
        $date_today = $date_object->format('Y-m-d');
        
        return $date_today;
    }
    
    public static function get_month_name_eng($today)
    {
        $date = new DateTime($today);
        return $date->format('F');
    }
    
    public static function days_between($date1, $date2 = null, $format = '%a')
    {
        if ($date2 == null) 
		{
            $date2 = new DateTime();
		}
			
        if (is_a($date1, DateTime))
        {
            $date1 = $date1->format('Y-m-d H:i:s');
        }
        
        if (isset($date2) && is_a($date2, DateTime))
        {
            $date2 = $date2->format('Y-m-d H:i:s');
        }
        
        if (Valid::date($date1) && Valid::date($date2))
        {
            $date2 = new DateTime($date2);
            $date1 = new DateTime($date1);
            $difference = $date2->diff($date1)->format($format);
            return $difference;
        }
        return false;
    }
    
    public static function get_year($date)
    {
        $date = new DateTime($date);
        return $date->format('Y');
    }
    
    public static function get_month($date)
    {
        $dateObj = new DateTime($date);
        return $dateObj->format('m');
    }
    
    public static function month_list($limit = false)
    {
        $list = array();
        $months = $limit === false ? 12 : date('m', strtotime('-1 month'));
        
        for ($m = 1; $m <= $months; $m++) 
        {
             $list[$m] = self::get_month_name($m);
        }
        
        return $list;
    }
    
    public static function get_month_name($month_nbr)
    {
        $months = array(
            '1' => 'Styczeń',
            '2' => 'Luty',
            '3' => 'Marzec',
            '4' => 'Kwiecień',
            '5' => 'Maj',
            '6' => 'Czerwiec',
            '7' => 'Lipiec',
            '8' => 'Sierpień',
            '9' => 'Wrzesień',
            '10' => 'Październik',
            '11' => 'Listopad',
            '12' => 'Grudzień',
        );
        if (array_key_exists(ltrim($month_nbr, 0), $months))
        {
            return $months[ltrim($month_nbr, 0)];
        }
        return false;
    }
	
	public static function get_translate_month_name($month_nbr)
    {
        $months = array(
            'January' => 'Styczeń',
            'February' => 'Luty',
            'March' => 'Marzec',
            'April' => 'Kwiecień',
            'May' => 'Maj',
            'June' => 'Czerwiec',
            'July' => 'Lipiec',
            'August' => 'Sierpień',
            'September' => 'Wrzesień',
            'October' => 'Październik',
            'November' => 'Listopad',
            'December' => 'Grudzień',
        );
        if (array_key_exists(ltrim($month_nbr, 0), $months))
        {
            return $months[ltrim($month_nbr, 0)];
        }
        return false;
    }
    
    public static function now ($date = null)
    {
        $date = new DateTime();
        return $date->format('Y-m-d H:i:s');
    }
    
    public static function days_ago($days)
    {
        $date = new DateTime();
        $date->modify('-'.$days.' day');
        return $date->format('Y-m-d');
    }
    
    public static function null_if_zeros($date)
    {
        if ($date == '0000-00-00' || self::validate($date) === false)
            return NULL;
        
        return $date;
    }
	
	public static function check_dates($date_one, $op, $date_two)
	{
		return Helper_Operator::$op($date_one, $date_two);
	}
}