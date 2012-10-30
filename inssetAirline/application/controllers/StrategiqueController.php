<?php

class StrategiqueController extends Zend_Controller_Action
{

    public function indexAction()
    {
    	$valeur = $this->_getParam('valeur');
    	if(isset($valeur))
    	{
     		switch ($valeur)
    		{
    			case "creer": 
    				$this->_helper->actionStack('creerligne', 'strategique', 'default', array());
    			break;
    			
    			case "fermer":
    				$this->_helper->actionStack('fermerligne', 'strategique', 'default', array());
    			break;
    		}	
    	}
    }
    
    public function creerligneAction()
    {
    	echo'________________________________ <br /><br /> 
    	creer une ligne <br />________________________________';
    }
    
    public function fermerligneAction()
    {
    	//on récupère tous les vols contenus dans la table vol dans
    	//la variable $lesVols
    	
    	$vol = new Vol;
    	$lesVols = $vol->fetchAll();
    	
    	$this->view->lesVols = $lesVols;
    	
    }

}