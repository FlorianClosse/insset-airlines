<?php 
//Par Nicolas
class TechniqueController extends Zend_Controller_Action
{
	public function preDispatch()
	{
		$this->_helper->actionStack('login', 'index', 'default', array());
		// Ne rend plus aucune action de ce contrôleur
		$auth = Zend_Auth::getInstance();
		if (!$auth->hasIdentity())
		{
			$this->_helper->viewRenderer->setNoRender();
		}
	}
	
	public function indexAction()
    {
    	//on crée le formulaire
    	$formulaireChoix = new Zend_Form;
    	$formulaireChoix -> setAttrib('id','formulaireChoixAeroport');
    	$formulaireChoix -> setMethod('post');
    	$formulaireChoix -> setAction('/technique/index/');
    	//choix de l'aéroport de départ
    	$formulaireChoix -> addElement(fonctionAeroport('numeroAeroport'));
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
    	$journalDeBord = new JournalDeBord();
    	$vol = new Vol();
    	$avion = new Avion();
    	$aeroport = new Aeroport();
    	$aujourdhui = date('Y-m-j');
    	$monAeroport = $_SESSION['aeroport'];
    	
    	
	    $lesVols = $journalDeBord->getRecuperLesVolsDepartAujourdHui($aujourdhui);
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
	    			if(isset($_POST['ajouter'.$idJournal]))
	    			{
	    				$modifierStatut = $journalDeBord->find($idJournal)->current();
	    				$modifierStatut->statut = "en vol";
	    				$modifierStatut->save();
	    				$lAvion->statut = "en vol";
	    				$lAvion->save();
	    				$message = 'le décollage du vol '.$idJournal.' à bien été enregistré.<br/>';
	    			}
	    			else
	    			{
		    			$idAeroportArrivee = $leVol->aeroportArrivee;
		    			$lAeroport = $aeroport->find($idAeroportArrivee)->current();
		    			
		    			$lesVolsAEnvoyer[] = $unVol;
		    			$lesHorairesAEnvoyer[$idJournal] = fonctionConvertirHeure($leVol->dureeVol);
		    			$lesAeroportAEnvoyer[$idJournal] = $lAeroport;
		    			$lesAvionsAEnvoyer[$idJournal] = $lAvion;
		    			$action = 'index?valeur=decollage';
		    			$lesFormulaires[$idJournal] = new FormulaireServiceTechniqueEnvoiVol($idJournal, $action);
	    			}
	    		}
	    	}
	    }
	    if(isset($lesVolsAEnvoyer))
	    {
		    //on envoie les Vols a la vue
		    $this->view->lesVolsAEnvoyer = $lesVolsAEnvoyer;
		    //on envoie les horaires a la vue
		    $this->view->lesHorairesAEnvoyer = $lesHorairesAEnvoyer;
		    //on envoie les avions a la vue
		    $this->view->lesAvionsAEnvoyer = $lesAvionsAEnvoyer;
		    //on envoie les aeroport a la vue
		    $this->view->lesAeroportAEnvoyer = $lesAeroportAEnvoyer;
		    //on envoie les formulaires a la vue
		    $this->view->lesFormulaires = $lesFormulaires;
	    }
	    else
	    {
	    	if(isset($message))
	    	{
	    		$message = $message +'<br/>Aucun vol prévu aujourd\'hui.';
	    	}
	    	else
	    	{
	    		$message = 'Aucun vol prévu aujourd\'hui.';
	    	}
	    }
	    if(isset($message))
	    {
		    //on envoie un message  a la vue
		    $this->view->message = $message;
	    }
    }
    
    
    
    public function atterissageAction()
    {
    	$journalDeBord = new JournalDeBord();
    	$vol = new Vol();
    	$avion = new Avion();
    	$aeroport = new Aeroport();
    	$aujourdhui = date('Y-m-j');
    	$monAeroport = $_SESSION['aeroport'];
    	 
    	 
    	$lesVols = $journalDeBord->getRecuperLesVolsArriveeAujourdHui($aujourdhui);
    	foreach($lesVols as $unVol)
    	{
    		$idVol = $unVol['idVol'];
    		
    		$idJournal = $unVol['idJournalDeBord'];
    		$leVol = $vol->find($idVol)->current();
    		$aeroportDArrivee = $leVol['aeroportArrivee'];
    		
    		if($leVol->aeroportArrivee == $monAeroport)
    		{
    			$idAvion = $unVol['idAvion'];
    			$lAvion = $avion->find($idAvion)->current();
    			if($lAvion->statut == 'en vol')
    			{
    				if(isset($_POST['ajouter'.$idJournal]))
    				{
    					$modifierStatut = $journalDeBord->find($idJournal)->current();
    					$modifierStatut->statut = "fini";
    					$modifierStatut->save();
    					$lAvion->statut = "actif";
    					$lAvion->nombreHeureTotale = $lAvion->nombreHeureTotale + $leVol->dureeVol;
    					$lAvion->nbHeureVolDepuisGrandeRevision = $lAvion->nbHeureVolDepuisGrandeRevision - $leVol->dureeVol;
    					$lAvion->nbHeureVolDepuisPetiteRevision = $lAvion->nbHeureVolDepuisPetiteRevision - $leVol->dureeVol;
    					$lAvion->localisation = $aeroportDArrivee;
    					$lAvion->save();
    					$message = 'le décollage du vol '.$idJournal.' à bien été enregistré.<br/>';
    				}
    				else
    				{
    					$idAeroportDepart = $leVol->aeroportDepart;
    					$lAeroport = $aeroport->find($idAeroportDepart)->current();
    			   
    					$lesVolsAEnvoyer[] = $unVol;
    					$lesHorairesAEnvoyer[$idJournal] = fonctionConvertirHeure($leVol->dureeVol);
    					$lesAeroportAEnvoyer[$idJournal] = $lAeroport;
    					$lesAvionsAEnvoyer[$idJournal] = $lAvion;
    					$action = 'index?valeur=atterissage';
		    			$lesFormulaires[$idJournal] = new FormulaireServiceTechniqueEnvoiVol($idJournal, $action);
    				}
    			}
    		}
    	}
    	if(isset($lesVolsAEnvoyer))
    	{
    		//on envoie les Vols a la vue
    		$this->view->lesVolsAEnvoyer = $lesVolsAEnvoyer;
    		//on envoie les horaires a la vue
    		$this->view->lesHorairesAEnvoyer = $lesHorairesAEnvoyer;
    		//on envoie les avions a la vue
    		$this->view->lesAvionsAEnvoyer = $lesAvionsAEnvoyer;
    		//on envoie les aeroport a la vue
    		$this->view->lesAeroportAEnvoyer = $lesAeroportAEnvoyer;
    		//on envoie les formulaires a la vue
    		$this->view->lesFormulaires = $lesFormulaires;
    	}
    	else
    	{
    		if(isset($message))
    		{
    			$message = $message +'<br/>Aucun vol prévu aujourd\'hui.';
    		}
    		else
    		{
    			$message = 'Aucun vol prévu aujourd\'hui.';
    		}
    	}
    	if(isset($message))
    	{
    		//on envoie un message  a la vue
    		$this->view->message = $message;
    	}
    }
}