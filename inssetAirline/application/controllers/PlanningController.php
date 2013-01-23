<?php 

class PlanningController extends Zend_Controller_Action
{
	public function indexAction()
    {
    	$valeur = $this->_getParam('valeur');
    	if(isset($valeur))
    	{
    		switch ($valeur)
    		{
    			case "creer":
    				$this->_helper->actionStack('creerplanning', 'planning', 'default', array());
    				break;
    				 
    			case "fermer":
    				$this->_helper->actionStack('modifierplanning', 'planning', 'default', array());
    				break;
    		}
    	}
    }
    public function creerplanningAction()
    {
    	
    }
    public function modifierplanningAction()
    {
    	
    }
}