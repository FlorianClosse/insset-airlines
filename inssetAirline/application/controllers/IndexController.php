<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_helper->actionStack('login', 'index', 'default', array());
    }
    public function loginAction(){
    	$this->_helper->viewRenderer->setResponseSegment('login');
    }

}

