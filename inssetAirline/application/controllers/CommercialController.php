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
	
	public function ajouteroptionsAction()
	{
		/* Créer un objet formulaire */
		$FormAjoutOption = new Zend_Form();
		 
		/* Parametrer le formulaire */
		$FormAjoutOption->setMethod('post')->setAction('/commercial/index');
		$FormAjoutOption->setAttrib('id', 'FormAjoutOption');
		 
		/* Creer des elements de formulaire */
		$journalDeBord = new JournalDeBord;		
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
		$valide='valide';$attente='en attente';
 		$Statut->addMultiOption($valide, 'Validé');
 		$Statut->addMultiOption($attente, 'en attente');
 		
 		$aeroportD = new Aeroport;
 		$lesAeroportD = $aeroportD->fetchAll();
 		$aeroportD = new Zend_Form_Element_Select('aeroportD');
 		$aeroportD ->setLabel('Choisir un aeroport de départ');
 		foreach ($lesAeroportD as $unAeroportD ) 
 		{
 			$tableauAeroportD[$unAeroportD -> idAeroport] = ucfirst($unAeroportD->nomAeroport);
 		}
 		$aeroportD->setMultiOptions($tableauAeroportD);
 		
 		$aeroportA = new Aeroport;
 		$lesAeroportA = $aeroportA->fetchAll();
 		$aeroportA = new Zend_Form_Element_Select('aeroportA');
 		$aeroportA ->setLabel('Choisir un aeroport d\'arrivé');
 		foreach ($lesAeroportA as $unAeroportA )
 		{
 			$tableauAeroportA[$unAeroportA -> idAeroport] = ucfirst($unAeroportA->nomAeroport);
 		}
 		$aeroportA->setMultiOptions($tableauAeroportA);
 		
 		$paysDe = new Pays;
 		$lesPaysD = $paysDe->fetchAll();
 		
 		$paysD = new Zend_Form_Element_Select('paysD');
 		$paysD ->setLabel('Choisir un Pays de départ');
 		foreach ($lesPaysD as $unPaysD)
 		{
 			$tableauPaysD[$unPaysD -> idPays] = $unPaysD->nomPays;
 		}
 		$paysD->setMultiOptions($tableauPaysD);
 		
 		$paysAe = new Pays;
 		$lesPaysA = $paysAe->fetchAll();
 		$paysA = new Zend_Form_Element_Select('paysA');
 		$paysA ->setLabel('Choisir un Pays d\'arrivé');
 		foreach ($lesPaysA as $unPaysA)
 		{
 			$tableauPaysA[$unPaysA -> idPays] = $unPaysA->nomPays;
 		} 		
 		$paysA->setMultiOptions($tableauPaysA);  			
 		
 		$date = new Zend_Form_Element_Text('datepicker');
		$date ->setLabel('Date ');
		$date ->setRequired(TRUE);
		$date ->addValidator('Date');
 		
 		$boutonSubmit = new Zend_Form_Element_Submit('AjouterReservation');
 		$boutonReset = new Zend_Form_Element_Reset('Reset');
		
		$FormAjoutOption->addElement($Statut);		
		$FormAjoutOption->addElement($date);
		$FormAjoutOption->addElement($paysD);
		$FormAjoutOption->addElement($aeroportD);
		$FormAjoutOption->addElement($journalDeBord);
		$FormAjoutOption->addElement($paysA);
		$FormAjoutOption->addElement($aeroportA);
		$FormAjoutOption->addElement($boutonSubmit);
		$FormAjoutOption->addElement($boutonReset);
		
		//affiche le formulaire
		echo $FormAjoutOption;
			
	}
}