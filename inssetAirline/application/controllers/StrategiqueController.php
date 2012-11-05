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
    	
    	if(isset($_POST['envoyer']))
    	{
    		//supprimer un vol
	    	$vol = new Vol;
	    	$lesVols = $vol->fetchAll();
	    	
	    	foreach($lesVols as $unVol)
	    	{
	    		if(isset($_POST[$unVol->idVol]))
	    		{
	    			if($_POST[$unVol->idVol] == 1)
	    			{
	    				$vol->find($unVol->idVol)->current()->delete();
	    				$tableau[] = $unVol->numVol;
	    			}
	    		}
	    	}
	    	$this->view->tableau = $tableau;
    	}
    	
    }
    
    public function creerligneAction()
    {
    	echo'________________________________ <br /><br /> 
    	creer une ligne <br />________________________________';
    }
    
    public function fermerligneAction()
    {
    	//decorateur des cases a cocher
    	$decorateurCase = array(
    			array('ViewHelper'),
    			array('Errors'),
    			array('HtmlTag', array('tag'=>'td')),
    			array(
    					array('tr' => 'HtmlTag'),
    					array('tag'=> 'tr')
    			)
    	);
    	//decorateur du bouton submit
    	$decorateurBoutonEnvoyer = array(
    			array('ViewHelper'),
    			array('Errors'),
    			array('HtmlTag', array('tag'=>'td', 'class'=>'boutonEnvoyer')),
    			array(
    					array('tr' => 'HtmlTag'),
    					array('tag'=> 'tr'),
    			)
    	);
    	 
    	//decorateur du bouton formulaire complet
    	$decorateurTableau = array(
    			array('FormElements'),
    			array('HtmlTag', array('tag'=>'table', 'id'=>'tableauCaseACocherVol'))
    	);
    	 
    	 
    	//on récupère tous les vols contenus dans la table vol dans
    	//la variable $lesVols
    	$vol = new Vol;
    	$lesVols = $vol->fetchAll();
    	 
    	//on crée le formulaire
    	$formulaireSuppression = new Zend_Form;
    	$formulaireSuppression -> setMethod('post');
    	$formulaireSuppression -> setAction('/strategique/index/');
    	$formulaireSuppression -> setAttrib('id','formulaireSuppression');
    	$formulaireSuppression -> addDecorators($decorateurTableau);
    	 
    	//on crée les cases a cocher
    	foreach($lesVols as $unVol)
    	{
    		$caseACocher = new Zend_Form_Element_Checkbox($unVol -> idVol);
    		$caseACocher -> setValue($unVol -> idVol);
    		$caseACocher -> setDecorators($decorateurCase);
    		$formulaireSuppression -> addElement($caseACocher);
    	}
    	 
    	//on crée le bouton submit
    	$envoyer = new Zend_Form_Element_Submit('envoyer');
    	$envoyer -> setDecorators($decorateurBoutonEnvoyer);
    	$formulaireSuppression -> addElement($envoyer);
    	 
    	//on envoie les vols a la vue
    	$this->view->lesVols = $lesVols;
    	//on envoie le formulaire a la vue
    	$this->view->formulaire = $formulaireSuppression;
    
    }

}