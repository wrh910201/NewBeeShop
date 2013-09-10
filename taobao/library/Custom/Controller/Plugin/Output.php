<?php
class Custom_Controller_Plugin_Output extends Zend_Controller_Plugin_Abstract
{
    public static function output($data, $rec_type = 2)
    {
        if(!is_array($data))
        {
            echo 'data is not an array!';
            return;
        }
        $response = '';

        switch($rec_type)
        {
        case '0' :
            $response = $data;
            print_r($response);
            return;
        case '1' :
            $response = Zend_JSON::encode($data);
            break;
        default  :
            $response = base64_encode(Zend_JSON::encode($data));
            break;
        }
        echo $response;
    }
}
