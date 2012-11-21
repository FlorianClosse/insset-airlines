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
		$this->view->tableauReservations = $tableauReservations;
		
		if(isset($tableauReservations))
		{
			$this->view->tableauReservations = $tableauReservations;
		}
		else
		{
			echo 'Il n\'y a pas de réservation';
		}
		
	}
}