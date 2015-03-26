<?php

class Helper_ModelData
{
    public static function get_model_data($model, $id, $info)
    {
        $model_prototype = "Model_".$model;
        $model = new $model_prototype($id);
        
        if(!is_array($info))
        {
            $value = $model->$info;
        }
        else
        {
            $value = null;
            foreach($info as $val)
            {
                $value .= $model->$val." ";
            }
        }
        
        return trim($value);
    }
}
