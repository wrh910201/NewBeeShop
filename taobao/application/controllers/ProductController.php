<?php

class ProductController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        $data = array('id'=>1);
        Custom_Controller_Plugin_Output::output($data , 1);
    }


}

