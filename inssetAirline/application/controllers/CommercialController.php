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
		
		if(isset($_POST['AjouterReservation']))
		{
			$reservation = new Reservation;
		
			$reserv = $reservation->createRow();
			$reserv->idReservation = '';
			$reserv->idJournal = $_POST['journaldebord'];
			$reserv->statutReservation = $_POST['statut'];
		
			if(!empty($reserv->idJournal))
			{
				$reserv->save();
				echo "Réservation enregistrée";
			}
			else
			{
				echo"Erreur d'enregistrement";
			}
		}
	}
	
	public function afficheroptionsAction()
	{
		$reservation = new reservation();
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
	
	public function ajouteroptionsAction()
	{
		/* Créer un objet formulaire */
		$FormAjoutOption = new Zend_Form();
		 
		/* Parametrer le formulaire */
		$FormAjoutOption->setMethod('post')->setAction('/commercial/index');
		$FormAjoutOption->setAttrib('id', 'FormAjoutOption');
		 
		/* Creer des elements de formulaire */
		$journalDeBord = new Journaldebord;		
 		$lesjournaldebord = $journalDeBord->fetchAll();
 		
		$journalDeBord = new Zend_Form_Element_Select('journaldebord');
		$journalDeBord ->setLabel('Choisir un id journal de bord');
			
		foreach ($lesjournaldebord as $unjournaldebord )
		{
			$tableaujournaldebord[$unjournaldebord -> idJournalDeBord] = $unjournaldebord -> idJournalDeBord ;
		}
						
		$journalDeBord->setMultiOptions($tableaujournaldebord);
		
		$Statut = new Zend_Form_Element_Select('statut');
		$Statut ->setLabel('Choisir un statut');
		$valide='valide';$attente='attente';
 		$Statut->addMultiOption($valide, 'Validé');
 		$Statut->addMultiOption($attente, 'en attente');
 		
 		$boutonSubmit = new Zend_Form_Element_Submit('AjouterReservation');
 		$boutonReset = new Zend_Form_Element_Reset('Reset');
		
		$FormAjoutOption->addElement($Statut);
		$FormAjoutOption->addElement($journalDeBord);
		$FormAjoutOption->addElement($boutonSubmit);
		$FormAjoutOption->addElement($boutonReset);
		
		//affiche le formulaire
		echo $FormAjoutOption;
			
	}
}