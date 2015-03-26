<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Image
{
    
    private $image;
	private $filename;
	private $directory;
    
    public function __construct($image = null, $directory = null, $filename = null)
	{
		$this->image = $image;
		$version = Kohana::$config->load('version')->get('version');
		$this->directory = self::get_default_directory().$directory;
		$this->directory_only = $directory;
        $this->filename = $filename;
	}
    
    public static function get_default_directory()
    {
        return DOCROOT.'assets/images/';
    }
    
    public function upload_image()
	{
		if ( $this->validate_uploading_file())
		{	
            return NULL;
        }
	
		$this->generate_filename();
		
		$file = $this->save_original_file();
		
		return $this->filename;
	}	
	
	private function validate_uploading_file()
	{
		return (!Upload::valid($this->image) OR
				!Upload::not_empty($this->image) OR
				!Upload::type($this->image, array('jpg', 'jpeg', 'png', 'gif')));
	}
	
	private function generate_filename()
	{
		$this->filename = $this->image['name'];
		$this->filename = Helper_File::get_unique_filename($this->filename);
	}
	
	private function save_original_file()
	{
		if($file = Upload::save($this->image, $this->filename, $this->directory))
		{
			return $file;
		}
		return FALSE;
    }
    
    public function delete_image()
    {
        if (is_file($this->directory.'/'.$this->filename))
        {
            unlink($this->directory.'/'.$this->filename);
            Helper_Thumb::delete($this->filename, $this->directory_only);
        }
        return true;
    }
	
}
    

