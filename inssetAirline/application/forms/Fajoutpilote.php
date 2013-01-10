<?php
class Fajoutpilote extends Zend_Form
{
	public function init()
	{
		    	
    	/* Parametrer le formulaire */
    	$this->setMethod('post')->setAction('/drh/ajouterpersonne');
    	$this->setAttrib('id', 'FormAjoutPilote');
    	
    	/* Creer des elements de formulaire */
    	$PiloteNom= new Zend_Form_Element_Text('nomPilote');
    	$PiloteNom ->setLabel('Nom du pilote');
    	$PiloteNom ->setRequired(true);
    	$PiloteNom->setAttrib('id', 'formpilote');
    	$PiloteNom -> autocomplete = 'off';
    	$PiloteNom -> addValidator('Alpha');
    	
    	$PilotePrenom = new Zend_Form_Element_Text('prenomPilote');
    	$PilotePrenom ->setLabel('Prenom du pilote');
    	$PilotePrenom->setAttrib('id', 'formpilote');
    	$PilotePrenom ->setRequired(TRUE);
    	$PilotePrenom-> autocomplete = 'off';
    	$PilotePrenom-> addValidator('Alpha');
    	
    	$PiloteAdresse = new Zend_Form_Element_Text('adressePilote');
    	$PiloteAdresse ->setLabel('Adresse du pilote');
    	$PiloteAdresse->setAttrib('id', 'formpilote');
    	$PiloteAdresse-> autocomplete = 'off';
    	
    	$PiloteTelephone = new Zend_Form_Element_Text('telephonePilote');
    	$PiloteTelephone ->setLabel('Téléphone du pilote');
    	$PiloteTelephone->setAttrib('id', 'formpilote');
    	$PiloteTelephone-> autocomplete = 'off';
    	$PiloteTelephone-> addValidator('Int');
    	
    	
    	$PiloteMail = new Zend_Form_Element_Text('mailPilote');
    	$PiloteMail ->setLabel('Mail du pilote');
    	$PiloteMail->setAttrib('id', 'formpilote');
    	$PiloteMail->addValidator('EmailAddress');
    	$PiloteMail-> autocomplete = 'off';
    	
    	$aeroport = new Aeroport;
    	$lesAeroport = $aeroport->fetchAll();
    	$aeroport = new Zend_Form_Element_Select('aeroport');
    	$aeroport ->setLabel('Choisir un aeroport');
    	foreach ($lesAeroport as $unAeroport ) {
    		$tableauAeroport[$unAeroport -> idAeroport] = ucfirst($unAeroport->nomAeroport);
    	} // permet de construite mes données de mon select
    	 
    	$aeroport->setMultiOptions($tableauAeroport); // remplit ma liste deroulante
		$aeroport->setAttrib('id', 'listederoulanteajout');
		
    	$pSubmit = new Zend_Form_Element_Submit('Envoyer');
    	$pSubmit->setAttrib('id', 'boutonajoutpersonne');
    	
    	
    	/* On ajoute les elements au formulaire */
    	$this->addElement($PiloteNom);
    	$this->addElement($PilotePrenom);
    	$this->addElement($PiloteAdresse);
    	$this->addElement($PiloteTelephone);
    	$this->addElement($PiloteMail);
     	$this->addElement($aeroport);
    	$this->addElement($pSubmit);
		
	}
	


} 