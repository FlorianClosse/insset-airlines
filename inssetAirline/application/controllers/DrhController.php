<?php

class DrhController extends Zend_Controller_Action
{
	public function init() {
	
	}
	
    public function indexAction(){
    	if(isset($_POST['Envoyer']))
    	{
	    	$listepilote = New Pilote();
	    	$Pilote = $listepilote->createRow();
	    	$Pilote->idPilote = '';
	    	$Pilote->nomPilote = $_POST['nomPilote'];
	    	$Pilote->prenomPilote = $_POST['prenomPilote'];
	    	$Pilote->adresse = $_POST['adressePilote'];
	    	$Pilote->telephone = $_POST['telephonePilote'];
	    	$Pilote->email = $_POST['mailPilote'];
	    	$Pilote->idAeroportEmbauche = $_POST['aeroport'];
	    	$Pilote->save();
    	}
    }
    
    public function ajouterpersonneAction(){
    	/* Créer un objet formulaire */
    	$FormAjoutPilote = new Zend_Form();
    	
    	/* Parametrer le formulaire */
    	$FormAjoutPilote->setMethod('post')->setAction('/drh/index');
    	$FormAjoutPilote->setAttrib('id', 'FormAjoutPilote');
    	
    	/* Creer des elements de formulaire */
    	$PiloteNom= new Zend_Form_Element_Text('nomPilote');
    	$PiloteNom ->setLabel('Nom du pilote');
    	$PiloteNom ->setRequired(TRUE);
    	
    	$PilotePrenom = new Zend_Form_Element_Text('prenomPilote');
    	$PilotePrenom ->setLabel('Prenom du pilote');
    	$PilotePrenom ->setRequired(TRUE);
    	
    	$PiloteAdresse = new Zend_Form_Element_Text('adressePilote');
    	$PiloteAdresse ->setLabel('Adresse du pilote');
    	
    	$PiloteTelephone = new Zend_Form_Element_Text('telephonePilote');
    	$PiloteTelephone ->setLabel('Téléphone du pilote');
    	
    	$PiloteMail = new Zend_Form_Element_Text('mailPilote');
    	$PiloteMail ->setLabel('Mail du pilote');
    	
    	
    	$aeroport = new Aeroport;
    	$lesAeroport = $aeroport->fetchAll();
    	$aeroport = new Zend_Form_Element_Select('aeroport');
    	$aeroport ->setLabel('Choisir un aeroport');
    	foreach ($lesAeroport as $unAeroport ) {
    		$tableauAeroport[$unAeroport -> idAeroport] = ucfirst($unAeroport->nomAeroport);
    	} // permet de construite mes données de mon select
    	 
    	$aeroport->setMultiOptions($tableauAeroport); // remplit ma liste deroulante
    	 
    	$pSubmit = new Zend_Form_Element_Submit('Envoyer');
    	$pReset = new Zend_Form_Element_Reset('Reset');
    	
    	/* On ajoute les elements au formulaire */
    	$FormAjoutPilote->addElement($PiloteNom);
    	$FormAjoutPilote->addElement($PilotePrenom);
    	$FormAjoutPilote->addElement($PiloteAdresse);
    	$FormAjoutPilote->addElement($PiloteTelephone);
    	$FormAjoutPilote->addElement($PiloteMail);
    	$FormAjoutPilote->addElement($aeroport);
    	$FormAjoutPilote->addElement($pSubmit);
    	$FormAjoutPilote->addElement($pReset);
    	
    	/* Effectuer le rendu du formulaire */
    	echo $FormAjoutPilote;
    } 
}

