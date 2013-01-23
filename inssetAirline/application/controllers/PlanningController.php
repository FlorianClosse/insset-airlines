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
    		echo'!'.$aeroport.'!';
    		$aujourdhui = date('Y-m-j');
    		$jour = date('N');
    		echo '<h1>Pour le '.$aujourdhui.' pour l\'aéroport '.$aeroport.' : </h1>';
    		
    		$vol = new Vol();
    		$journalDeBord = new JournalDeBord();
    		$liaisonVolJour = new LiaisonVolJour();
    		
    		$lesVols = $vol->getRecuperLesVolsAujourdHui($aujourdhui, $aeroport);
    		foreach($lesVols as $unVol)
    		{
    			
    			$journal = $journalDeBord->getRecupererSuivantDateEtVol($aujourdhui, $unVol['idVol']);
    			if(isset($journal['idJournalDeBord']))
    			{
    				echo 'Vol : '.$unVol['numVol'].'<br/>Fait <br/>';
    			}
    			else
    			{
    				echo '<h2>Vol : '.$unVol['numVol'].'</h2>';
    				echo '<h3>Non programmé </h3>';
    			}
    			
    		}
    		echo '___________';
    		$lesVols = $liaisonVolJour->getRecupererVolSuivantJour($jour);
    		foreach($lesVols as $leVol)
    		{
    			$unVol = $vol->find($leVol['idVol'])->current();
    			if($unVol->aeroportDepart == $aeroport)
    			{
	    			
	    			$journal = $journalDeBord->getRecupererSuivantDateEtVol($aujourdhui, $unVol->idVol);
	    			if(isset($journal['idJournalDeBord']))
	    			{
	    				echo 'Vol : '.$unVol['numVol'].'<br/>Fait <br/>';
	    			}
	    			else
	    			{
	    				echo '<h2>Vol : '.$unVol['numVol'].'</h2>';
	    				echo '<h3>Non programmé </h3>';
	    			}
    			}
    		}
    	}
    }
    
    public function volacreerAction()
    {
    	
    }
    public function modifierplanningAction()
    {
    	
    }
}