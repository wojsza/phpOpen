<?php
defined('SYSPATH') or die('No direct script access.');

class Helper_Barcode
{
    public static function generate_barcode($type, $id, $factor = 1, $backgroundColor = '#FFFFFF', $barHeight = 50, $fontSize = 10)
    {
        $code = self::create_barcode_code($type, $id);

        $barcodeOptions = array('text' => $code, 'factor' => $factor, 'backgroundColor' => $backgroundColor, 'barHeight' => $barHeight, 'fontSize' => $fontSize);

        $rendererOptions = array('imageType' => 'png');

        $image = Zend\Barcode\Barcode::factory('ean13', 'image', $barcodeOptions, $rendererOptions)->draw();
        
        return $image;
    }
    
    private static function create_barcode_code($type, $id)
    {
        $code = str_pad($id, 10, '0', STR_PAD_LEFT);
        return $type.$code;
    } 
    
    public static function temp_barcode($type, $id)
    {
        $filepath = DOCROOT.'application/files/bar_code/'.$type.'_'.$id.'_barcode.png';
        
        if(!file_exists($filepath))
        {
            $barcode = self::generate_barcode($type, $id);
            file_put_contents($filepath, null);
            imagepng($barcode, $filepath);
        }
        
        return $filepath;
    }
    
    /**
     * DEPRACATED. To be removed
     * @return boolean
     */
    public static function remove_temp_barcode()
    {
        return true;
    }
}
