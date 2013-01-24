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
    		$aujourdhui = date('Y-m-j');
    		$jour = date('N');

    		$this->view->aujourdhui = $aujourdhui;
    		$this->view->jour = $jour;
    		$this->view->aeroport = $aeroport;
    		
    		$vol = new Vol();
    		$journalDeBord = new JournalDeBord();
    		$liaisonVolJour = new LiaisonVolJour();
    		$aerop = new Aeroport();
    		
    		$lesVols = $vol->getRecuperLesVolsAujourdHui($aujourdhui, $aeroport);
    		if(!empty($lesVols))
    		{
    			foreach($lesVols as $unVol)
	    		{
	    			
	    			$journal = $journalDeBord->getRecupererSuivantDateEtVol($aujourdhui, $unVol['idVol']);
	    			$numVols[$unVol['idVol']] = $unVol['numVol'];
	    			
	    			$aeroArriveeVols[$unVol['idVol']] = $aerop->find($unVol['aeroportArrivee'])->current()->nomAeroport;
	    			$aeroDepartVols[$unVol['idVol']] = $aerop->find($unVol['aeroportDepart'])->current()->nomAeroport;
	    			$idVols[$unVol['idVol']] = $unVol['idVol'];
	    			if(isset($journal['idJournalDeBord']))
	    			{
						$journal[$unVol['idVol']] = 'existe';
	    			}
	    			else
	    			{
	    				$journal[$unVol['idVol']] = 'existe pas';
	    			}
	    			
	    		}
	    		$this->view->journalsDate = $journal;
	    		$this->view->idVolsDate = $idVols;
	    		$this->view->numVolsDate = $numVols;
	    		$this->view->aeroDepartVolsDate = $aeroDepartVols;
	    		$this->view->aeroArriveeVolsDate = $aeroArriveeVols;
	    		$this->view->lesVolsDate = $lesVols;
    		}
    		
    		$lesVols = $liaisonVolJour->getRecupererVolSuivantJour($jour);
    		if(!empty($lesVols))
    		{
	    		foreach($lesVols as $leVol)
	    		{
	    			$idVols2[$leVol['idVol']] = $leVol['idVol'];
	    			
	    			$unVol = $vol->find($leVol['idVol'])->current();
	    			$numVols2[$leVol['idVol']] = $unVol->numVol;
	    			$aeroArriveeVols2[$leVol['idVol']] = $aerop->find($unVol['aeroportArrivee'])->current()->nomAeroport;
	    			$aeroDepartVols2[$leVol['idVol']] = $aerop->find($unVol['aeroportDepart'])->current()->nomAeroport;
	    			
	    			$aeroportDepart[$leVol['idVol']] = $unVol->aeroportDepart;
	    			if($unVol->aeroportDepart == $aeroport)
	    			{
		    			
		    			$journal = $journalDeBord->getRecupererSuivantDateEtVol($aujourdhui, $unVol->idVol);
		    			if(isset($journal['idJournalDeBord']))
		    			{
		    				$journal2[$leVol['idVol']] = 'existe';
		    			}
		    			else
		    			{
		    				$journal2[$leVol['idVol']] = 'existe pas';
		    			}
	    			}
	    		}
	    		$this->view->aeroportDepart = $aeroportDepart;
	    		$this->view->journalsJour = $journal2;
	    		$this->view->idVolsJour = $idVols2;
	    		$this->view->numVolsJour = $numVols2;
	    		$this->view->aeroDepartVolsJour = $aeroDepartVols2;
	    		$this->view->aeroArriveeVolsJour = $aeroArriveeVols2;
	    		$this->view->lesVolsJour = $lesVols;
    		}	
    	}
    }
    
    public function volacreerAction()
    {
    	$journalDeBord = new JournalDeBord();
    	$avion = new Avion();
    	$vol = new Vol();
    	
    	$volAPlannifier = $this->_getParam('numerovol');
    	$dateDuVolAPlannifier = $this->_getParam('date');
    	$monAeroDepart = $vol->find($volAPlannifier)->current()->aeroportDepart;
    	
    	$lesAvions = $avion->fetchAll();
    	
    	foreach($lesAvions as $unAvion)
    	{
	    	$jdb = $journalDeBord->getRecupererLieuAvion($unAvion->idAvion);
	    	
	    	$aeroDepart = $vol->find($jdb['idVol'])->current();
	    	$aeroDepart = $aeroDepart['aeroportArrivee'];
	    	
	    	if($monAeroDepart == $aeroDepart)
	    	{
	    		$idAvion[] = $jdb['idAvion'];
	    		$idPilote[] = $jdb['idPilote'];
	    		$idPilote[] = $jdb['idCoPilote'];
	    		 
	    	}
    	}
    	$this->view->leVol = $volAPlannifier;
    	if(isset($idAvion))
    	{
    		$this->view->lesAvions = $idAvion;
    	}
    	if(isset($idPilote))
    	{
    		$this->view->lesPilotes = $idPilote;
    	}
    	
    	$this->view->datePrevu = $dateDuVolAPlannifier;
    }
    public function modifierplanningAction()
    {
    	
    }
}