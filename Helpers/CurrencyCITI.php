<?php 

class Helper_CurrencyCITI {
	
	public function get_acutual_exchange($term)
	{
        $today = Helper_Date::get_today();
        $month_name = Helper_Date::get_month_name_eng($today);
        $year = Helper_Date::get_year($today);
        
        //$url = "http://www.online.citibank.pl/retail/files/kursy/CB_FX_".$year."_".$month_name.".xml?a=".Helper_RandomNumber::generator(13);
        $url = "https://www.online.citibank.pl/retail/files/kursy/Blue_FX_".$year."_".$month_name.".xml?a=".Helper_RandomNumber::generator(13);
        
        $file_headers = @get_headers($url);
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') 
        {
            $data = false;
        }
        else 
        {
            $xml = file_get_contents($url);
            $source = new SimpleXMLElement($xml);
            
            $data = array();
            foreach($source->kurs as $exchange)
            {
                $symbol = (string)Arr::get($exchange, "waluta");
                $published_date = (string)Arr::get($exchange, "data");
                $course = (string)Arr::get($exchange, "sprzedaz");
                $time = (string)Arr::get($exchange, "godz");
                
                if($symbol == $term && $published_date == $today)
                {
                    $data[] = array("symbol" => $symbol, 
                                    "course" => $course, 
                                    "time" => $time);
                }
            }
        }
        
        return $data; 
    }
    
}

