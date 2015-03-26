<?php
class Helper_RandomNumber {
    
    public static function generator($maxq)
    {
        $number = null;
        for ($i = 1; $i <= $maxq; $i++) 
        {
            $number .= self::random_digits($i);
        }
        
        return $number;
    }
    
    private static function random_digits($digits) 
    {
        if ($digits <= 0) 
        {
            return '';
        }

        return mt_rand(0, 9);
    }
}
