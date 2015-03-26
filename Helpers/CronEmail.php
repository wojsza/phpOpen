<?php
defined('SYSPATH') or die('No direct script access.');

class Helper_CronEmail
{
    public static function format_email($email_info, $email_value)
    {
        $email_data = array_combine($email_info, $email_value);
        
        $email = null;
        foreach($email_data as $key=>$val)
        {
            $email .= $key.$val."<br />\xA";
        }
         
        return $email;
    }
    
    public static function cron_send_email($email, $to_email, $title)
    {
        $email_data = array('title' => $title,'message' => $email);
		
		$logic_cron_email = new Logic_Cron_Email($email_data, $to_email);
		$logic_cron_email->send();
        
        return true;
    }
    
    public static function url_generate($controler, $action, $id)
    {
        $invoice_url = Route::get('default')->url('default', array('controller' => $controler, 'action' => $action, 'id' => $id), 'http');
        $invoice_url_view = View::factory('cron/components/url')->bind('invoice_url', $invoice_url);

        return $invoice_url_view;
    }
}
?>
