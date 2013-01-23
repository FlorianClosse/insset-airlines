<?php
class Fajoutpilote extends Zend_Form
{
	public function init()
	{

		// traduction des messages d'erreur de validation
		$french = array(
				'notAlnum' => "'%value%' ne contient pas que des lettres et/ou des chiffres.",
				'notAlpha' => "'%value%' ne contient pas que des lettres.",
				'notBetween' => "'%value%' n'est pas compris entre %min% et %max% inclus.",
				'notBetweenStrict' => "'%value%' n'est pas compris entre %min% et %max% exclus.",
				'dateNotYYYY-MM-DD'=> "'%value%' n'est pas une date au format AAAA-MM-JJ (exemple : 2000-12-31).",
				'dateInvalid' => "'%value%' n'est pas une date valide.",
				'dateFalseFormat' => "'%value%' n'est pas une date valide au format JJ/MM/AAAA (exemple : 31/12/2000).",
				'notDigits' => "'%value%' ne contient pas que des chiffres.",
				'emailAddressInvalid' => "'%value%' n'est pas une adresse mail valide selon le format adresse@domaine.",
				'emailAddressInvalidHostname' => "'%hostname%' n'est pas un domaine valide pour l'adresse mail '%value%'.",
				'emailAddressInvalidMxRecord' => "'%hostname%' n'accepte pas l'adresse mail '%value%'.",
				'emailAddressDotAtom' => "'%localPart%' ne respecte pas le format dot-atom.",
				'emailAddressQuotedString' => "'%localPart%' ne respecte pas le format quoted-string.",
				'emailAddressInvalidLocalPart' => "'%localPart%' n'est pas une adresse individuelle valide.",
				'notFloat' => "'%value%' n'est pas un nombre décimal.",
				'notGreaterThan' => "'%value%' n'est pas strictement supérieur à '%min%'.",
				'notInt'=> "'%value%' n'est pas un nombre entier.",
				'notLessThan' => "'%value%' n'est pas strictement inférieur à '%max%'.",
				'isEmpty' => "Ce champ est vide : vous devez le compléter.",
				'stringEmpty' => "Ce champ est vide : vous devez le compléter.",
				'regexNotMatch' => "'%value%' ne respecte pas le format '%pattern%'.",
				'stringLengthTooShort' => "'%value%' fait moins de %min% caractères.",
				'stringLengthTooLong' => "'%value%' fait plus de %max% caractères."
		);
		
		$translate = new Zend_Translate('array', $french, 'fr');
		$this->setTranslator($translate);
		
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
