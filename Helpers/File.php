<?php defined('SYSPATH') or die('No direct script access.');

class Helper_File
{
    public static function get_unique_filename($filename)
    {
        $unique_filename = Text::random(NULL, 16).'_'.$filename;
        $unique_filename = self::sanitize_filename($unique_filename);
        return $unique_filename;
    }
    
    public static function sanitize_filename($name, $separator = '-')
    {
        // Transliterate non-ASCII characters
        $name = UTF8::transliterate_to_ascii($name);


        // Replace all separator characters and whitespace by a single separator
        $name = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $name);

        // Trim separators from the beginning and end
        return trim($name, $separator);
    }
    
    public static function format_filesize($bytes, $precision = 2) 
    { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
         $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 
}