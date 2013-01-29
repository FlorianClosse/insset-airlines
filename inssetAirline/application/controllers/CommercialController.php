<?php

class CommercialController extends Zend_Controller_Action
{
	
	
	public function preDispatch()
	{
		$this->_helper->actionStack('login', 'index', 'default', array());
		// Ne rend plus aucune action de ce contrôleur
		$auth = Zend_Auth::getInstance();
		if (!$auth->hasIdentity())
		{
			$this->_redirect('/index/login');
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
		$lesReservations = $reservation->getLesAeroports();
		
		$aeroport = new Aeroport();
		
		
		$compteur=0;
		
		/* Créer un objet formulaire */
		$formFiltre = new FfiltreReservation();
		echo $formFiltre;	
		
		if(isset($_SESSION['boutonArrivee']) && isset($_SESSION['boutonDepart']))
		{
						
			if(isset($_SESSION['arrivee']) && isset($_SESSION['depart']))
			{
				$arrive = $_SESSION['arrivee'];
				$depart = $_SESSION['depart'];
				
				$filtreArriveeDepart = $reservation-> getAeroportDepartArrivee($depart,$arrive);
					
				foreach($filtreArriveeDepart as $unFiltreArriveeDepart)
				{					
						$compteur=$compteur+1;
						$tableauReservations[$compteur][0] = $unFiltreArriveeDepart['idReservation'];
						$tableauReservations[$compteur][1] = $unFiltreArriveeDepart['statutReservation'];
						$tableauReservations[$compteur][2] = $unFiltreArriveeDepart['nbPlaceReservee'];
						$tableauReservations[$compteur][3] = fonctionConvertirHeureMinutes(time()-$unFiltreArriveeDepart['heureReservation'] );
						$tableauReservations[$compteur][4] = $unFiltreArriveeDepart['idJournal'];
							
						$aeroportDepart = $unFiltreArriveeDepart['aeroportDepart'];
						$aeroportArrivee = $unFiltreArriveeDepart['aeroportArrivee'];
						$unAeroportD = $aeroport->find($aeroportDepart)->current();
						$unAeroportA = $aeroport->find($aeroportArrivee)->current();
							
						$tableauReservations[$compteur][5] = $unAeroportD['nomAeroport'];
						$tableauReservations[$compteur][6] = $unAeroportA['nomAeroport'];
					
				}
			}
		}
		else 
		{
			if(isset($_POST['FiltrerD']) && !isset($_POST['FiltrerA']))
			{
				$_SESSION['depart'] = $_POST['aeroportD'];
					
				$_SESSION['boutonDepart'] = $_POST['FiltrerD'];
					
					
				if(isset($_SESSION['depart']))
				{
					$depart = $_SESSION['depart'];
					$filtreDepart = $reservation-> getAeroportDepart($depart);
			
					foreach($filtreDepart as $unFiltreDepart)
					{
						if($unFiltreDepart['statutReservation'] == 'en attente')
						{
							$compteur=$compteur+1;
							$tableauReservations[$compteur][0] = $unFiltreDepart['idReservation'];
							$tableauReservations[$compteur][1] = $unFiltreDepart['statutReservation'];
							$tableauReservations[$compteur][2] = $unFiltreDepart['nbPlaceReservee'];
							$tableauReservations[$compteur][3] = fonctionConvertirHeureMinutes(time()-$unFiltreDepart['heureReservation'] );
							$tableauReservations[$compteur][4] = $unFiltreDepart['idJournal'];
								
							$aeroportDepart = $unFiltreDepart['aeroportDepart'];
							$aeroportArrivee = $unFiltreDepart['aeroportArrivee'];
							$unAeroportD = $aeroport->find($aeroportDepart)->current();
							$unAeroportA = $aeroport->find($aeroportArrivee)->current();
								
							$tableauReservations[$compteur][5] = $unAeroportD['nomAeroport'];
							$tableauReservations[$compteur][6] = $unAeroportA['nomAeroport'];
						}
					}
			
				}
			}
				
			if(isset($_POST['FiltrerA']) && !isset($_POST['FiltrerD']))
			{
				$_SESSION['arrivee'] = $_POST['aeroportA'];
					
				$_SESSION['boutonArrivee'] = $_POST['FiltrerA'];
					
				if(isset($_SESSION['arrivee']))
				{
					$arrive = $_SESSION['arrivee'];
					$filtreArrivee = $reservation-> getAeroportArrivee($arrive);
						
					foreach($filtreArrivee as $unFiltreArrivee)
					{
						if($unFiltreArrivee['statutReservation'] == 'en attente')
						{
							$compteur=$compteur+1;
							$tableauReservations[$compteur][0] = $unFiltreArrivee['idReservation'];
							$tableauReservations[$compteur][1] = $unFiltreArrivee['statutReservation'];
							$tableauReservations[$compteur][2] = $unFiltreArrivee['nbPlaceReservee'];
							$tableauReservations[$compteur][3] = fonctionConvertirHeureMinutes(time()-$unFiltreArrivee['heureReservation'] );
							$tableauReservations[$compteur][4] = $unFiltreArrivee['idJournal'];
								
							$aeroportDepart = $unFiltreArrivee['aeroportDepart'];
							$aeroportArrivee = $unFiltreArrivee['aeroportArrivee'];
							$unAeroportD = $aeroport->find($aeroportDepart)->current();
							$unAeroportA = $aeroport->find($aeroportArrivee)->current();
								
							$tableauReservations[$compteur][5] = $unAeroportD['nomAeroport'];
							$tableauReservations[$compteur][6] = $unAeroportA['nomAeroport'];
						}
					}
				}
			}
				
		}
	
		if(!isset($_SESSION['boutonDepart']) && !isset($_SESSION['boutonArrivee']))
		{
			foreach ($lesReservations as $uneReservation)
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
		}

		if(isset($_POST['Vider']))
		{
			unset($_SESSION['boutonDepart']);
			unset($_SESSION['boutonArrivee']);
			unset($_POST['vider']);
			unset($_POST['FiltrerA']);
			unset($_POST['FiltrerD']);	
			$this->_redirect('/commercial/index?valeur=afficher');
		}
		
		$this->view->compteur = $compteur;		
		
		if(isset($tableauReservations))
		{
			$this->view->tableauReservations = $tableauReservations;
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
					echo'Numero du vol :  '. $unjournaldebord['numVol'].'<br/>';
					echo'Nombre de places disponibles :  '. $unjournaldebord['nbPlaceDispo'].'<br/>';					
				}		
				$_SESSION['nbplacedispo']=$unjournaldebord['nbPlaceDispo'];
				$_SESSION['idjournaldebord']=$unjournaldebord['idJournalDeBord'];
				
				//on affiche le formulaire
				echo $formAjoutReservation;
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
				//on affiche le formulaire
				echo $formDemanderLesVols;				
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
						$placeDispo = $unJournalDeBord['nbPlaceDispo'] + $resultat;
					}
					else
					{
						if($placeAvantModif > $place)
						{
							$resultat = $place - $placeAvantModif;
							$placeDispo = $unJournalDeBord['nbPlaceDispo'] + $resultat;
						}
						$placeDispo = $unJournalDeBord['nbPlaceDispo'];
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
						
					echo 'Id de reservation : '.$uneReservation ->idReservation;
					
					//on stock l'id de la reservation en session pour le récupérer
					$_SESSION['idreservation']=$idReservation;
					$_SESSION['place']=$uneReservation ->nbPlaceReservee;
					$_SESSION['idJournal']=$uneReservation ->idJournal;
					
					$formModifierReservation->populate($datas);
					echo $formModifierReservation;
				}
			}
		}
	}
	
}