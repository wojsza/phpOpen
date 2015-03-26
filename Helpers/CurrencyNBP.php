<?php defined('SYSPATH') OR die('No direct access allowed.');

class Helper_CurrencyNBP {
	
	public static function get_acutual_exchange($term)
	{
        $url = "http://www.nbp.pl/kursy/xml/LastA.xml";
        
        $file_headers = @get_headers($url);
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') 
        {
            $data = false;
        }
        else 
        {
            $today = Helper_Date::get_today();
            
            $xml = file_get_contents($url);
            $source = new SimpleXMLElement($xml);
            $result_symbol = $source->xpath('pozycja[kod_waluty="'.$term.'"]');
            
            if($source->data_publikacji == $today)
            {
                $data = $result_symbol;
                if(empty($result_symbol))
                {
                    $data = false;
                }
            }
            else
            {
                $data = false;
            }
        }
        
        return $data;
    }
    
}
