<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    function _initOutput()
    {
        Zend_Loader::loadClass('Custom_Controller_Plugin_Output');
    }

}

