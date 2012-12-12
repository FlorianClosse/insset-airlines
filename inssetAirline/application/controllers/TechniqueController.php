<?php 
//Par Nicolas
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
    	$numeroAeroport = new Zend_Form_Element_Text('numeroAeroport');
    	$numeroAeroport -> setLabel('choisir votre aéroport');
    	$formulaireChoix -> addElement($numeroAeroport);
    	//bouton d'envoie du formulaire
    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitChoixAeroport');
    	$envoyer -> setLabel('Ajouter');
    	$formulaireChoix -> addElement($envoyer);
    	//on envoie le formulaire a la vue
    	$this->view->formulaire = $formulaireChoix;
    	
    	
    	if(isset($_POST['boutonSubmitChoixAeroport']))
    	{
    		$_SESSION['aeroport'] = $_POST['numeroAeroport'];
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
    	$journalDeBord = new Journaldebord();
    	$vol = new Vol();
    	$avion = new Avion();
    	$aujourdhui = date('Y-m-j');
    	$monAeroport = $_SESSION['aeroport'];
    	
    	
	    $lesVols = $journalDeBord->getRecuperLesVolsAujourdHui($aujourdhui);
	    foreach($lesVols as $unVol)
	    {
	    	$idVol = $unVol['idVol'];
	    	$idJournal = $unVol['idJournalDeBord'];
	    	$leVol = $vol->find($idVol)->current();
	    	if($leVol->aeroportDepart == $monAeroport)
	    	{
	    		$idAvion = $unVol['idAvion'];
	    		$lAvion = $avion->find($idAvion)->current();
	    		if($lAvion->statut == 'actif')
	    		{
	    			$lesVolsAEnvoyer[] = $unVol;
	    			$lesLignesAEnvoyer[$idJournal] = $leVol;
	    			$lesAvionsAEnvoyer[$idJournal] = $lAvion;
	    			$lesFormulaires[$idJournal] = new FormulaireServiceTechniqueEnvoiVol($idJournal);
	    			
	    		}
	    	}
	    }
	    //on envoie les Vols a la vue
	    $this->view->lesVolsAEnvoyer = $lesVolsAEnvoyer;
	    //on envoie les lignes a la vue
	    $this->view->lesLignesAEnvoyer = $lesLignesAEnvoyer;
	    //on envoie les avions a la vue
	    $this->view->lesAvionsAEnvoyer = $lesAvionsAEnvoyer;
	    //on envoie les formulaires a la vue
	    $this->view->lesFormulaires = $lesFormulaires;
	    
    }
    
    public function atterissageAction()
    {
    	 
    }
}