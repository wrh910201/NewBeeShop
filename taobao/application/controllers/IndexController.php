<?php

class IndexController extends Zend_Controller_Action
{
    private $session;
    private $sessionModel;
    private $appkey;
    private $request;
    private $response;

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->request = $this->getRequest();
        $this->sessionModel = new NewBeeApp_Model_Session();
    }

    public function indexAction()
    {
        $this->appkey = $this->request->getParam('appkey');
        $this->session = $this->request->getParam('session');
        if($this->appkey != '' && $this->session == '')
        {
            $user_id = $this->request->getParam('user_id');
            if(!is_numeric($user_id))
            {
                $user_id = 0;
            }
            $data = array(
                'appkey' => $this->appkey,
                'user_id' => $user_id
            );
            $this->session = $this->sessionModel->insertSession($data);
            $this->response['session'] = $this->session;
            $this->response['process'] = 1;
        } else if($this->appkey != '' && $this->session != '') {
            $sessionInfo = $this->sessionModel->checkSession($this->session);
        } else {
            $this->response['process'] = 0;
            Custom_Controller_Plugin_Output::output($this->response, RETURN_TYPE);
        }

        // appkey , session are ready
        if($sessionInfo != null)
        {
            // do some select here
            $this->response['process'] = 1;
            $this->response['info'] = 'success';
        } else {
            $this->response['process'] = 0;
        }

        Custom_Controller_Plugin_Output::output($this->response, RETURN_TYPE);
    }


}

