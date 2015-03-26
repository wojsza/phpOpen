<?php

class Helper_MultipleFileValidator {

	public $errors = array();
	public $filtered_array = array();
	
	private $array = array();
	private $result = array();
	private $field;
	private $rules;

	public static function factory(array $array, $field)
	{
		return new Helper_MultipleFileValidator($array, $field);
	}

	public function __construct($array, $field)
	{
		$this->array[$field] = Helper_PostArrayHTML::convert_array($array[$field]);
		$this->field = $field;
	}

	public function set_rules()
	{
		$this->rules = func_get_args();
	}

	public function validate($filter = false)
	{
		foreach ($this->array[$this->field] as $key => $file)
		{
			$prop[$this->field] = $file;
			
			$validations[$key] = Validation::factory($prop);
			foreach ($this->rules[0] as $rule)
			{
				$validations[$key]->rule($this->field, Arr::get($rule, "type"), Arr::get($rule, "args", null));
			}
			
			$validations[$key]->check();
			$this->result[] = $validations[$key]->errors();
		}
		
		$this->errors = $this->errors($filter);
		return;
	}

	private function errors($filter)
	{
		$errors = array_filter($this->result);
		$not_valid_files = array();
		$result = array();
		if(!empty($errors))
		{
			foreach($errors as $error)
			{
				$type = $error[$this->field][0];
				$file_name = $error[$this->field][1][0]['name'];
				$result[$type][] = $this->set_error($type, $file_name);
				array_push($not_valid_files, $file_name);
			}
		}
		
		$this->result_array($filter, $not_valid_files, $result);
		return $result;
	}
	
	private function result_array($filter, array $not_valid_files, array $result)
	{
		if($filter === true)
		{
			$this->filtered_array = $this->filter_array($not_valid_files);
		}
		elseif($filter === false && !empty($result))
		{
			$this->filtered_array = array();
		}
		else
		{
			$this->filtered_array = $this->array;
		}
		return;
	}
	
	private function filter_array(array $not_valid_files)
	{
		if(!empty($not_valid_files))
		{
			foreach($this->array[$this->field] as $key => $file)
			{
				$file_name = Arr::get($file, 'name');
				if(in_array($file_name, $not_valid_files))
				{
					unset($this->array[$this->field][$key]);
				}
			}
		}
		return $this->array;
	}
	
	public function set_error($type, $file_name)
	{
		switch ($type)
		{
			case 'upload::type':
				return "Nieprawidłowy typ pliku {$file_name}";
			case 'upload::size':
				return "Nieprawidłowy rozmiar pliku {$file_name}";
			default:
				return "Niezdefiniowany błąd pliku {$file_name}";
		}
	}
}
