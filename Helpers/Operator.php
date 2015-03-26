<?php

class Helper_Operator
{
    public static function lt($a, $b)
    {
        return $a < $b;
    }
    
    public static function bt($a, $b)
    {
        return $a > $b;
    }
	
	public static function ltq($a, $b)
    {
        return $a <= $b;
    }
    
    public static function btq($a, $b)
    {
        return $a >= $b;
    }
    
    public static function plus($a, $b)
    {
        return $a + $b;
    }
    
    public static function minus($a, $b)
    {
        return $a - $b;
    }
	
	public static function multiply($a, $b)
	{
		return $a * $b;
	}
	
	public static function divide($a, $b)
	{
		return $a / $b;
	}
}