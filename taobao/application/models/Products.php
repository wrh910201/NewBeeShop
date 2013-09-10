<?php

class NewBeeApp_Model_Products extends Zend_Db_Table_Abstract
{
    protected $_name = 'products';
    
    /**
     *  @author winsen
     *  @date 2013-09-09
     *  @params mixed where
     *          string order
     *          int    limit
     *  @return mixed products on success
     *          null on others
     */
    public function getProducts($where = null, $order = null, $limit = null)
    {
        $select = $this->select();

        if(is_string($where))
        {
            $select->where($where);    
        }

        if(is_array($where))
        {
            foreach($where as $key=>$value)
            {
                $select->where($key.'=?', $value);
            }
        }

        if($order)
        {
            $select->order($order);
        }

        if($limit)
        {
            $select->limit($limit);
        }

        $result = $this->fetchAll($select);
        
        if($result)
        {
            return $result;
        } else {
            return null;
        }
    }

    public function switchStruct($products)
    {
        
    }
}

