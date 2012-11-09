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
	    	if(!empty($Pilote->nomPilote)){
	    	 	$Pilote->save();
	    	}
	    	else{
	    		echo" dans le cul";
	    	}
    	}
    	
    	if(isset($_POST['EnvoyerBrevet'])){
    		$listepilotebrevet = New liaisonPiloteBrevet();
    		$brevet = $listepilotebrevet->createRow();
    		$brevet->idPilote = $_POST['pilote'];
    		$brevet->idBrevet = $_POST['brevet'];
    		$date = $_POST['datepicker'];
    		$brevet->dateDobtention= $date;
    		$brevet->save();
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
    	$PiloteNom->setAttrib('id', 'formpilote');
    	$PiloteNom ->setRequired(TRUE);
    	
    	
    	$PilotePrenom = new Zend_Form_Element_Text('prenomPilote');
    	$PilotePrenom ->setLabel('Prenom du pilote');
    	$PilotePrenom->setAttrib('id', 'formpilote');
    	$PilotePrenom ->setRequired(TRUE);
    	
    	$PiloteAdresse = new Zend_Form_Element_Text('adressePilote');
    	$PiloteAdresse ->setLabel('Adresse du pilote');
    	$PiloteAdresse->setAttrib('id', 'formpilote');
    	
    	$PiloteTelephone = new Zend_Form_Element_Text('telephonePilote');
    	$PiloteTelephone ->setLabel('Téléphone du pilote');
    	$PiloteTelephone->setAttrib('id', 'formpilote');
    	
    	$PiloteMail = new Zend_Form_Element_Text('mailPilote');
    	$PiloteMail ->setLabel('Mail du pilote');
    	$PiloteMail->setAttrib('id', 'formpilote');
    	
    	
//     	$aeroport = new Aeroport;
//     	$lesAeroport = $aeroport->fetchAll();
//     	$aeroport = new Zend_Form_Element_Select('aeroport');
//     	$aeroport ->setLabel('Choisir un aeroport');
//     	foreach ($lesAeroport as $unAeroport ) {
//     		$tableauAeroport[$unAeroport -> idAeroport] = ucfirst($unAeroport->nomAeroport);
//     	} // permet de construite mes données de mon select
    	 
//     	$aeroport->setMultiOptions($tableauAeroport); // remplit ma liste deroulante
    	
    	
    	$pays = new Pays;
    	$lesPays = $pays->fetchAll();
    	$pays = new Zend_Form_Element_Select('pays');
    	$pays ->setLabel('Choisir un pays');
    	$pays->setAttrib('id', 'listePaysId');
    	foreach ($lesPays as $unPays ) {
    		$tableauPays[$unPays -> idPays] = ucfirst($unPays->nomPays);
    	} // permet de construite mes données de mon select
    	$pays->setMultiOptions($tableauPays); // remplit ma liste deroulante
    	
    	?><select name="listeVille" id="listeVilleId" disabled="true"></select><?php 
    	

    	$pSubmit = new Zend_Form_Element_Submit('Envoyer');
    	$pReset = new Zend_Form_Element_Reset('Reset');
    	
    	
    	/* On ajoute les elements au formulaire */
    	$FormAjoutPilote->addElement($PiloteNom);
    	$FormAjoutPilote->addElement($PilotePrenom);
    	$FormAjoutPilote->addElement($PiloteAdresse);
    	$FormAjoutPilote->addElement($PiloteTelephone);
    	$FormAjoutPilote->addElement($PiloteMail);
//     	$FormAjoutPilote->addElement($aeroport);
    	$FormAjoutPilote->addElement($pays);
    	$FormAjoutPilote->addElement($pSubmit);
    	$FormAjoutPilote->addElement($pReset);
    	
    	/* Effectuer le rendu du formulaire */
    	echo $FormAjoutPilote;
    } 
    
    public function brevetAction(){
    	/* Créer un objet formulaire */
    	$formbrevet = new Zend_Form();
    	 
    	/* Parametrer le formulaire */
    	$formbrevet->setMethod('post')->setAction('/drh/index');
    	$formbrevet->setAttrib('id', 'formbrevet');

    	$pilote = new Pilote;
    	$lesPilotes = $pilote->fetchAll();
    	$pilote = new Zend_Form_Element_Select('pilote');
    	$pilote ->setLabel('Choisir un pilote');
    	foreach ($lesPilotes as $unPilote ) {
    		$tableauPilote[$unPilote -> idPilote] = ucfirst($unPilote->nomPilote);
    	} // permet de construite mes données de mon select
    	
    	$pilote->setMultiOptions($tableauPilote); // remplit ma liste deroulante
    	
    	$brevet = new Brevet;
    	$lesBrevets = $brevet->fetchAll();
    	$brevet = new Zend_Form_Element_Select('brevet');
    	$brevet ->setLabel('Choisir un brevet');
    	foreach ($lesBrevets as $unBrevet ) {
    		$tableauBrevet[$unBrevet -> idBrevet] = ucfirst($unBrevet->nomBrevet);
    	} // permet de construite mes données de mon select
    	 
    	$brevet->setMultiOptions($tableauBrevet); // remplit ma liste deroulante
    	
    	$datepicker = new Zend_Form_Element_Text('datepicker');
    	$datepicker ->setLabel('Choisir la date d\'obtention');
    	$datepicker->setAttrib('id', 'datepicker');
    	
    	$pSubmit = new Zend_Form_Element_Submit('EnvoyerBrevet');
    	$pReset = new Zend_Form_Element_Reset('Reset');
    	 
    	/* On ajoute les elements au formulaire */
    	$formbrevet->addElement($pilote);
    	$formbrevet->addElement($brevet);
    	$formbrevet->addElement($datepicker);
    	$formbrevet->addElement($pSubmit);
    	$formbrevet->addElement($pReset);
    	 
    	/* Effectuer le rendu du formulaire */
    	echo $formbrevet;
    }
}

