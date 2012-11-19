<?php 

class TechniqueController extends Zend_Controller_Action
{
	public function indexAction()
    {
    	//on crée le formulaire
    	$formulaireChoix = new Zend_Form;
    	$formulaireChoix -> setAttrib('id','formulaireChoixAeroport');
    	$formulaireChoix -> setMethod('post');
    	$formulaireChoix -> setAction('/technique/index/');
    	//choix de l'aéroport de départ
    	$numeroVol = new Zend_Form_Element_Text('numeroVol');
    	$numeroVol -> setLabel('Numéro de vol');
    	$formulaireChoix -> addElement($numeroVol);
    	//bouton d'envoie du formulaire
    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitChoixAeroport');
    	$envoyer -> setLabel('Ajouter');
    	$formulaireChoix -> addElement($envoyer);
    	//on envoie le formulaire a la vue
    	$this->view->formulaire = $formulaireChoix;
    	
    	
    	if(isset($_POST['boutonSubmitChoixAeroport']))
    	{
    		$_SESSION['aeroport'] = $_POST['numeroVol'];
    	}
    	if(isset($_SESSION['aeroport']))
    	{
    		$this->_helper->actionStack('menu', 'technique', 'default', array());
    	}
   	}
    
    public function menuAction()
    {
    	$valeur = $this->_getParam('valeur');
    	if(isset($valeur))
    	{
    		switch ($valeur)
    		{
    			case "decollage":
    				$this->_helper->actionStack('decollage', 'technique', 'default', array());
    				break;
    	
    			case "atterissage":
    				$this->_helper->actionStack('atterissage', 'technique', 'default', array());
    				break;
    		}
    	} 
    }
    
    public function decollageAction()
    {
    	$journalDeBord = new Journaldebord;
    	
    		$lesVols = $journalDeBord->fetchAll();
    	
    	
	    //$lesVols = $journalDeBord->getRecuperLesVolsAujourdHuiDeMonAeroport(2);
	    foreach($lesVols as $unVol)
	    {
	    	var_dump($unVol);
	    }
    }
    
    public function atterissageAction()
    {
    	 
    }
}