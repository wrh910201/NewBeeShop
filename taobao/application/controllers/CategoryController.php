<?php

class CategoryController extends Zend_Controller_Action
{

    private $request = null;
    private $session;
    private $response;
    private $categoryModel;
    private $sessionModel;
    private $productModel;

    public function init()
    {
        $this->request = $this->getRequest();
        $this->session = $this->request->getParam('session');
        $this->response = array('process'=>0, 'products' => array(), 'item' => array());
        $this->_helper->viewRenderer->setNoRender(true);

        $this->sessionModel = new NewBeeApp_Model_Session();
        $this->categoryModel = new NewBeeApp_Model_Category();
        $this->productModel = new NewBeeApp_Model_Products();
    }

    public function indexAction()
    {
    }

    public function listAction()
    {
        $first_load = $this->request->getParam('first_load');
        $this->response['item'] = $this->categoryModel->getCategoryTree();
        $this->response['products'] = $this->productModel->getProducts('`is_hot`=1'); 
        $this->response['process'] = 1;
        Custom_Controller_Plugin_Output::output($this->response, RETURN_TYPE);
    }


}



