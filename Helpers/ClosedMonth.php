<?php defined('SYSPATH') OR die('No direct access allowed.');

class Helper_ClosedMonth {
    
    static private $_instance;
    private $closed_months_arr;
    
    public static function instance()
    {
        if(!self::$_instance) 
        {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    public function __construct()
    {
        $this->closed_months_arr = Logic_MonthClose::get_closed_months();
    }
    
    public function check_closed_date($date)
    {
        $month = (int)Helper_Date::get_month($date);
        $year = (int)Helper_Date::get_year($date);
        
        foreach($this->closed_months_arr as $value)
        {
            if($value->year == $year && $value->month == $month && 
                    !Priv::instance()->has_any('monthClose/open', array(Priv::METHOD_ALLOW)))
            {
                return false;
            }
        }
        
        return true;
    }
}