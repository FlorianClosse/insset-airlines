<?php

class CommercialController extends Zend_Controller_Action
{
	
	public function init(){
		$this->_helper->actionStack('login', 'index', 'default', array());
	}
	
public function preDispatch()
	{
		
		// Ne rend plus aucune action de ce contrôleur
		$auth = Zend_Auth::getInstance();
		if (!$auth->hasIdentity())
		{
			$this->_redirect('/index/login');
		}
		if($_SESSION['Zend_Auth']['storage']->service != 9){
			if($_SESSION['Zend_Auth']['storage']->service != 1){
				$this->_redirect('/index');
			}
		}
	}
	
	public function indexAction()
	{
		$valeur = $this->_getParam('valeur');
		
		if(isset($valeur))
		{
			switch ($valeur)
			{
				case "afficher":
					$this->_helper->actionStack('afficheroptions', 'commercial', 'default', array());
					break;
				case "ajout":
					$this->_helper->actionStack('ajouteroptions', 'commercial', 'default', array());
					break;
			}
		}		
	}	
	
	public function afficheroptionsAction()
	{

		$reservation = new Reservation();
		$aeroport = new Aeroport();		
		$formFiltreDepart = new FfiltreReservationDepart();
		$formFiltreArrivee = new FfiltreReservationArrivee();
		$compteur=0;
		
		
	$viderFiltre = $this->_getParam('viderFiltre');
		if(isset($viderFiltre))
		{
			unset($_SESSION['depart']);
			unset($_SESSION['arrivee']);
			$this->_redirect('/commercial/index?valeur=afficher');
		}
		
		if(isset($_POST['aeroportD']))
			$_SESSION['depart'] = $_POST['aeroportD'];		
		
		if(isset($_POST['aeroportA']))
			$_SESSION['arrivee'] = $_POST['aeroportA'];
		
		
		if(isset($_SESSION['depart']) && isset($_SESSION['arrivee']))
		{
			$lesReservations = $reservation-> getAeroportDepartArrivee($_SESSION['depart'],$_SESSION['arrivee']);
		}
		else 
		{
			if(isset($_SESSION['depart']))
			{
				$lesReservations = $reservation-> getAeroportDepart($_SESSION['depart']);
			}
			else
			{
				if(isset($_SESSION['arrivee']))
				{
					$lesReservations = $reservation-> getAeroportArrivee($_SESSION['arrivee']);
				}
				else
				{
					$lesReservations = $reservation->getLesAeroports();
				}
			}
		}
		
		
		$this->view->formFiltreDepart = $formFiltreDepart;	
		$this->view->formFiltreArrivee = $formFiltreArrivee;
		
		$page=$this->_getParam('page',1);
		$paginator = Zend_Paginator::factory($lesReservations);
		$paginator->setCurrentPageNumber($this->_getParam('page'));
		$paginator->setItemCountPerPage(6);
		$paginator->setCurrentPageNumber($page);
			
		foreach($paginator as $uneReservation)
		{
			if($uneReservation['statutReservation'] == 'en attente')
			{
				$compteur=$compteur+1;
				$tableauReservations[$compteur][0] = $uneReservation['idReservation'];
				$tableauReservations[$compteur][1] = $uneReservation['statutReservation'];
				$tableauReservations[$compteur][2] = $uneReservation['nbPlaceReservee'];
				$tableauReservations[$compteur][3] = fonctionConvertirHeureMinutes(time()-$uneReservation['heureReservation'] );
				$tableauReservations[$compteur][4] = $uneReservation['idJournal'];
					
				$aeroportDepart = $uneReservation['aeroportDepart'];
				$aeroportArrivee = $uneReservation['aeroportArrivee'];
				$unAeroportD = $aeroport->find($aeroportDepart)->current();
				$unAeroportA = $aeroport->find($aeroportArrivee)->current();
					
				$tableauReservations[$compteur][5] = $unAeroportD['nomAeroport'];
				$tableauReservations[$compteur][6] = $unAeroportA['nomAeroport'];
			}
				
		}
			
		$this->view->compteur = $compteur;		
		
		if(isset($tableauReservations))
		{
			$this->view->tableauReservations = $tableauReservations;
			$this->view->paginator = $paginator;			
		}
		else
		{
			echo 'Il n\'y a pas de réservation';
		}
				
	}
	
	//permet de demander les vols disponibles et de reserver des places
	public function ajouteroptionsAction()
	{
		/* Créer un objet formulaire */
		$formDemanderLesVols = new FdemanderLesVols();
		$formAjoutReservation = new FajoutReservation();
		/*On instancie le model journaldebord*/
		$journal = new JournalDeBord;
		$lesjournaldebord=$journal->fetchAll();		
		
		//traitement aprés le formulaire de reservation de places
		if(isset($_POST['Ajouter']))
		{			
			$data = $this->getRequest()->getPost();
			$dispo = $_SESSION['nbplacedispo'] ; $place = $data['place'];
			
			echo 'Nombre de place choisies : '.$place.'<br>';
			if($place < $dispo)
			{				
				echo 'Nombre de places restantes : '.$resultat = $dispo - $place.'<br>';				
				
				foreach($lesjournaldebord as $unjournaldebord)
				{
					if($_SESSION['idjournaldebord'] == $unjournaldebord['idJournalDeBord'])
					{
						$reservation = new Reservation;
						$lesReservation = $reservation->fetchAll();
						$ajoutReservation = $reservation->createRow();						
						
						$ajoutReservation -> statutReservation = 'en attente';
						$ajoutReservation -> nbPlaceReservee = $place;
						$ajoutReservation -> heureReservation = time();
						$ajoutReservation -> idJournal = $unjournaldebord['idJournalDeBord'];
						$ajoutReservation -> save();					
						
						$sauvegarde = $journal->find($unjournaldebord['idJournalDeBord'])->current();
						$sauvegarde-> nbPlaceDispo = $resultat;						
						$sauvegarde->save();
						
						echo'Reservation enregistrée';
					}
				}	
			}
			else
			{
				echo'Il n\'y a pas assé de place disponible<br>';
				echo 'Nombre de places disponibles :'.$dispo;
			}
				
		}
		
		//traitement aprés le formulaire de demande de vol
		if(isset($_POST['Envoyer']))
		{		
			
			$data = $this->getRequest()->getPost();	
			
			$date = $data['datepicker'] ;
			$aeroportDepart = $data['aeroportD'];
			$aeroportArrivee = 	$data['aeroportA'];
			
			$journal = new JournalDeBord;
			$lesjournaldebord=$journal->getVol($date,$aeroportDepart,$aeroportArrivee);
		
			if(!empty($lesjournaldebord))
			{
				foreach($lesjournaldebord as $unjournaldebord)
				{
					$numeroVol = 'Numero du vol :  '. $unjournaldebord['numVol'].'<br/>';
					$nombrePlace = 'Nombre de places disponibles :  '. $unjournaldebord['nbPlaceDispo'].'<br/>';					
				}		
				$_SESSION['nbplacedispo']=$unjournaldebord['nbPlaceDispo'];
				$_SESSION['idjournaldebord']=$unjournaldebord['idJournalDeBord'];
				
				//on affiche le formulaire
				$this->view-> numeroVol = $numeroVol;
				$this->view-> nombrePlace = $nombrePlace;
				$this->view-> formAjoutReservation = $formAjoutReservation;
			}
			else
			{
				echo'Aucun vol n\'existe avec ces critéres';
			}
		}
		else 
		{	
			if(!isset($_POST['Ajouter']))
			{		
				$this->view->formDemanderLesVols = $formDemanderLesVols;
			}
		}			
	}
	
	public function supprimeroptionAction()
	{
		$reservation = new Reservation;
		$lesReservation = $reservation->fetchAll();
		
		$idReservation = $this->_getParam('idReservation');	
		
		foreach ($lesReservation as $uneReservation)
		{			
			if($idReservation ==$uneReservation->idReservation)
			{				
				$journal = new JournalDeBord;
				$lesJournaux = $journal->fetchAll();				
				
				foreach ($lesJournaux as $unJournal)
				{
					if($uneReservation->idJournal == $unJournal->idJournalDeBord )
					{
						//supprime la reservation selectionnée
						$sauvegarde= $journal->find($unJournal->idJournalDeBord)->current();
						$a = $sauvegarde->nbPlaceDispo ; 
						$b = $uneReservation->nbPlaceReservee;
						$resultat = $a+$b;
						$sauvegarde ->nbPlaceDispo = $resultat;
						$sauvegarde->save();
					}
				}
				
				//supprime la reservation selectionnée
				$reservation->find($uneReservation->idReservation)->current()->delete();
				
				//renvoi à l'index du controller commercial
				$this->_redirect('/commercial/index?valeur=afficher');
			}
		}		
	}
	
	public function modifieroptionAction()
	{
		//on instancie le model
		$reservation = new Reservation;
		$lesReservation = $reservation->fetchAll();
		
		/*On instancie le model journaldebord*/
		$journal = new JournalDeBord;
		$lesJournalDeBord=$journal->fetchAll();
		
		/* Créer un objet formulaire */
		$formModifierReservation = new FmodifierReservation();		
		
		if(isset($_POST['Modifier']))
		{
			//on récupére les variables stockés en session
			$idReservation=$_SESSION['idreservation'];
			$placeAvantModif=$_SESSION['place'];
			$idJournal=$_SESSION['idJournal'];			
						 			
			//récupére les données du post et les sauvegarde 
			$place = $this->_request->getPost('place');
			$statut = $this->_request->getPost('statut');
					
			
			foreach($lesJournalDeBord as $unJournalDeBord)
			{
				if($idJournal == $unJournalDeBord['idJournalDeBord'])
				{
					if($placeAvantModif < $place)
					{
						$resultat = $place - $placeAvantModif;						
						$placeDispo = $unJournalDeBord['nbPlaceDispo'] - $resultat;						
					}
					else
					{
						if($placeAvantModif > $place)
						{
							$resultat = $place - $placeAvantModif;
							$placeDispo = $unJournalDeBord['nbPlaceDispo'] - $resultat;							
						}
						else 
						{
							$placeDispo = $unJournalDeBord['nbPlaceDispo'];							
						}
						
					}

					$modification= $journal->find($idJournal)->current();
					$modification-> nbPlaceDispo = $placeDispo ;					
					$modification->save();
				}
			}
    		$sauvegarde = $reservation->find($idReservation)->current();
			$sauvegarde-> nbPlaceReservee = $place ;
			$sauvegarde-> statutReservation = $statut;
			$sauvegarde->save();		

			//renvoi à l'index du controller commercial
			$this->_redirect('/commercial/index?valeur=afficher');
		}
		else 
		{
			//on récupére l'id de la reservation à modifier
			$idReservation = $this->_getParam('idReservation');
			
			foreach ($lesReservation as $uneReservation)
			{
				if($idReservation == $uneReservation->idReservation)
				{
					$datas=array('statut'=>$uneReservation ->statutReservation,
							'place'=>$uneReservation ->nbPlaceReservee);					
					
					//on stock l'id de la reservation en session pour le récupérer
					$_SESSION['idreservation']=$idReservation;
					$_SESSION['place']=$uneReservation ->nbPlaceReservee;
					$_SESSION['idJournal']=$uneReservation ->idJournal;
					
					$formModifierReservation->populate($datas);
					$this->view->formModifierReservation = $formModifierReservation;
				}
			}
		}
	}
	
}
