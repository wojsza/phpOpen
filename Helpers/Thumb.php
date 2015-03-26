<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Prosty resizer.
 */

class Helper_Thumb
{
    
    public static function create($image_path, $category, $mode, $image_name = null)
    {
        if (file_exists($image_path))
        {
            //sprawdzam, czy docelowe katalogi istnieja
            $destination_path = self::get_default_directory().$category.'/'.$mode;
            if (is_dir($destination_path))
            {
                try
                {
                    $thumb = Image::factory($image_path);
                }
                catch (Kohana_Exception $e)
                {
                    throw new HTTP_Exception_404('Helper_Thumb: file not valid!');
                }
                
                $mode = self::explode_mode($mode);
                $resize_type = $mode[1];
                $resize_width_value = $mode[2];
                $resize_height_value = $mode[3] ? $mode[3] : $mode[2];
                
                if ($resize_type == 'fit')
                {
                    $thumb->resize($resize_width_value, $resize_height_value);
                }
                
                if ($resize_type == 'fill')
                {
                    $image_ratio = $thumb->width / $thumb->height;
                    $thumb_ratio = $resize_width_value / $resize_height_value;
                    if ($image_ratio > $thumb_ratio)
                    {
                        $thumb->resize(NULL, $resize_height_value);
                    }
                    else
                    {
                        $thumb->resize($resize_width_value, NULL);
                    }
                    $thumb->crop($resize_width_value, $resize_height_value);
                }
                
                $thumb->save($destination_path.'/'.$image_name);
                return $destination_path.'/'.$image_name;
                
            }
            else
            {
                throw new HTTP_Exception_404('Helper_Thumb: $category and $mode path not created');
            }
        }
        else
        {
            throw new HTTP_Exception_404('Helper_Thumb: $image_path not valid');
        }
    }
    
    public static function explode_mode($mode)
    {
        $valid = preg_match('/^([a-zA-Z]*)_([0-9]*)x([0-9]*)$/', $mode, $matches);
        if ($valid)
        {
            return $matches;
        }
        else
        {
            return false;
        }
    }
    
    public static function get_default_directory()
    {
        return DOCROOT.'assets/thumb/';
    }
    
    /*
     * @todo: W późniejszym terminie zgrać dodawanie / usuwanie z bazą danych...
     */
    public static function delete($filename, $directory)
    {
        $main_dir = self::get_default_directory().$directory.'/';
		$thumbs_dirs = array();
		if (is_dir($main_dir))
        {
			if ($dh = opendir($main_dir))
            {
				while (($file = readdir($dh)) !== false)
                {
					if ($file != '.' && $file != '..' && filetype($main_dir . $file) == 'dir')
                    {
						$thumbs_dirs[] = $file;
					}
				}
				closedir($dh);
			}
		}
        
		if (count($thumbs_dirs) > 0)
        {
			foreach ($thumbs_dirs as $dir) {
				if (file_exists($main_dir.$dir.'/'.$filename))
                {
					unlink($main_dir.$dir.'/'.$filename);
				}
			}
		}
		return true;
    }
    
}