<?php

class CommercialController extends Zend_Controller_Action
{
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
		$lesReservations = $reservation->fetchAll();
		$compteur=0;
		
		foreach ($lesReservations as $uneReservation)
		{
			if($uneReservation->statutReservation == 'en attente')
			{
				$compteur=$compteur+1;
			
				$tableauReservations[$compteur][0] = $uneReservation->idReservation;
				$tableauReservations[$compteur][1] = $uneReservation->statutReservation;
				$tableauReservations[$compteur][2] = $uneReservation->idJournal;
			}
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
			$x = $_SESSION['nbplacedispo'] ; $y = $data['place'];
			
			echo 'Nombre de place choisies : '.$data['place'].'<br>';
			if($y < $x)
			{				
				echo 'Nombre de places restantes : '.$resultat = $x - $y.'<br>';				
				
				foreach($lesjournaldebord as $unjournaldebord)
				{
					if($_SESSION['idjournaldebord'] == $unjournaldebord['idJournalDeBord'])
					{
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
				echo 'Nombre de places disponibles :'.$x;
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
	
}