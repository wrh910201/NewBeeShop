<?php

class NewBeeApp_Model_Session extends Zend_Db_Table_Abstract
{
    protected $_name = 'session';
    /**
     *  @author winsen
     *  @date 2013-09-09
     *  @params mixed $data
     *          $data = array(
     *              'appkey' => '',
     *              'user_id' => 0
     *          )
     *  @return session_key on success
     *          false on others
     *  @todo insert a session into db and get a unique session identity
     * */
    public function insertSession($data)
    {
        if(strlen($data['appkey']) < 10)
        {
            return false;
        }

        if(!is_numeric($data['user_id']))
        {
            return false;
        }

        if($data['user_id'] > 0)
        {
            $data['login_status'] = true;
        } else {
            $data['login_status'] = false;
        }
        
        $businessModel = new NewBeeApp_Model_Business();
        $select = $businessModel->select();
        $select->where('appkey = ?', $data['appkey']);
        $business = $businessModel->fetchRow($select);
        if($business)
        {
            $data['business_id'] = $business->id;
        } else {
            return false;
        }

        while(true)
        {
            $session_key = md5(date('dHis').rand(1000, 9999).'newton');
            $select = $this->select();
            $select->where('session_key = ?', $session_key);
            $row = $this->fetchRow($select);
            if(!$row)
            {
                $data['session_key'] = $session_key;
                break;
            }
        }

        $this->insert($data);
        return $session_key;
    }

    /**
     *  @author winsen
     *  @date 2013-09-09
     *  @params string session
     *  @return
     *  @todo check session_key and get user status
     */
    public function checkSession($session)
    {
        $select = $this->select();
        $select->where('session_key = ?', $session);
        $row = $this->fetchRow($select);
        if($row)
        {
            return $row;
        } else {
            return null;
        }
    }
}

