<?php

class NewBeeApp_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'category';

     /**
     *  @author winsen
     *  @date 2013-09-09
     *  @params mixed where 
     *          string order [ASC|DESC]
     *          numeric limit
     *  @return mixed categoryTree on success
     *          null on failed
     */
    public function getCategoryTree($where = null, $order = null, $limit = null)
    {
        $select = $this->select();

        if(is_array($where))
        {
            foreach($where as $key=>$value)
            {
                $select->where($key.'=?', $value);
            }    
        }

        if(is_string($where))
        {
            $select->where($where);
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

        if(count($result) > 0)
        {
            return $this->encodeTree($result);
        } else {
            return null;
        }
    }
    
    /**
     *  @author winsen
     *  @date 2013-09-09
     *  @params mixed result
     *  @return mixed tree
     *  @todo change the category array into the struct of tree with parent_id=id
     */
    private function encodeTree($result)
    {
        $tree = array();
        foreach($result as $item)
        {
            switch($item['level'])
            {
            case 1 : 
                $tree[$item['id']] = $item->toArray();
                break;
            case 2 :
                $tree[$item['parent_id']]['item'][$item['id']] = $item->toArray();
                break;
            case 3 :
                $path = $item['path'];
                $dept = explode(',', $path);
                $tree[$dept[0]]['item'][$dept[1]]['item'][$item['id']] = $item->toArray();
                break; 
            default :
                break;
            }
        }

        $response = $this->cleanNode($tree);
//        print_r($response);

        return $response;
    }

    /**
     *  @author winsen
     *  @date 2013-09-09
     *  @params mixed tree
     *  @return mixed response
     *  @todo change the tree's identity into auto increment
     */
    private function cleanNode($tree)
    {
        foreach($tree as $key=>$node)
        {
            if(isset($node['item']))
            {
//                echo 'begin recursion';
                $tree[$key]['item'] = $this->cleanNode($node['item']);
//                echo 'end recursion';
            }
        }
        
        $response = array();
        foreach($tree as $item)
        {
            $response[] = $item;
        }

        return $response;
    }
}

