<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //Menu par Nicolas 
        $this->_helper->actionStack('login', 'index', 'default', array());
        
        $menu = $this->_getParam('menu');
        if(isset($menu))
        {
        	switch ($menu)
        	{
        		case "commercial":
        			$this->_helper->actionStack('index', 'commercial', 'default', array());
        			break;
        			 
        		case "strategique":
        			$this->_helper->actionStack('index', 'strategique', 'default', array());
        			break;
        		
        		case "technique":
        			$this->_helper->actionStack('index', 'technique', 'default', array());
        			break;
        		
        		case "logistique":
        			$this->_helper->actionStack('index', 'logistique', 'default', array());
        			break;
        		
        		case "drh":
        			$this->_helper->actionStack('index', 'drh', 'default', array());
        			break;
        		
        		case "maintenance":
        			$this->_helper->actionStack('index', 'maintenance', 'default', array());
        			break;
        	}
        }
    }
    public function loginAction(){
    	$this->_helper->viewRenderer->setResponseSegment('login');
    }

}

