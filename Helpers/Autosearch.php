<?php defined('SYSPATH') OR die('No direct access allowed.');

class Helper_Autosearch {
    
    public static function autosearch($term, $logic, $method, $result=null)
    {
        $result = self::get_autosearch($term, $logic, $method, $result); 

        if(empty($result))
        {
            $result[] = array('id' => null, 'value'=> '', 'label' => 'Wartość o podanych parametrach nie istnieje');
        }
        
        return $result;
    }
    
    private static function get_autosearch($term, $logic, $method, $result_array)
    {
        $logic_object = new $logic();
        $orm_result = is_array($term) ? $logic_object->$method(Arr::get($term, "term"), Arr::get($term, "extra")) : $logic_object->$method($term);

        foreach($orm_result as $value)
        { 
            $id = $value->$result_array[0];
            $label = null;
            foreach($result_array as $val)
            {
                if($val != 'id' && $val != 'user_id')
                { 
                    $label .= $value->$val." ";
                }
            }

            $result[] = array('id' => $id, 'value'=> $label, 'label' => $label);
        }
        return $result;
    }
}
