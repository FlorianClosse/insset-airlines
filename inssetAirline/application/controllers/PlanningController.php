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
    	if ($this->_getParam('retour') == 'oui')
    	{
    		unset($_SESSION['aeroportCreerPlanning']);
    	}
    	
    	if(isset($_POST['boutonSubmitChoixAeroport']))
    	{
    		$_SESSION['aeroportCreerPlanning'] = $_POST['numeroAeroport'];
    	}
    	
    	if(!isset($_SESSION['aeroportCreerPlanning']))
    	{
	    	$formulaireChoix = new Zend_Form;
	    	$formulaireChoix -> setAttrib('id','formulaireChoixAeroport');
	    	$formulaireChoix -> setMethod('post');
	    	$formulaireChoix -> setAction('/planning/creerplanning');
	    	
	    	$numeroAeroport = new Zend_Form_Element_Text('numeroAeroport');
	    	$numeroAeroport -> setLabel('choisir votre aéroport');
	    	$formulaireChoix -> addElement($numeroAeroport);
	    	
	    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitChoixAeroport');
	    	$envoyer -> setLabel('Ajouter');
	    	$formulaireChoix -> addElement($envoyer);
	    	
	    	$this->view->formulaire = $formulaireChoix;
	    }
    	else
    	{
    		$aeroport = $_SESSION['aeroportCreerPlanning'];
    		echo $aujourdhui = date('Y-m-j');
    		$vol = new Vol();
    		$lesVols = $vol->getRecuperLesVolsAujourdHui($aujourdhui, $aeroport);
    		foreach($lesVols as $unVol)
    		{
    			echo $unVol['idVol'].'<br/>';
    		}
    	}
    }
    public function modifierplanningAction()
    {
    	
    }
}