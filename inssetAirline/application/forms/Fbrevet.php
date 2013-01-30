<?php
class Fbrevet extends Zend_Form
{
	public function init()
	{
		/* Parametrer le formulaire */
		$this->setMethod('post')->setAction('/drh/index');
		$this->setAttrib('id', 'forms');
		
		$pilote = new Pilote;
		
		$lesPilotes = $pilote->fetchAll();
		
		$pilote = new Zend_Form_Element_Select('pilote');
		$pilote ->setLabel('Choisir un pilote');
		foreach ($lesPilotes as $unPilote ) {
			$tableauPilote[$unPilote -> idPilote] = ucfirst($unPilote->nomPilote);
		} // permet de construite mes données de mon select
		
		if(!isset($tableauPilote))
		{
			$tableauPilote = array();
		}
		$pilote->setMultiOptions($tableauPilote); // remplit ma liste deroulante
		$pilote->setAttrib('id', 'listederoulantebrevet');
		
		
		$brevet = new Brevet;
		
		$lesBrevets = $brevet->fetchAll();
		
		$brevet = new Zend_Form_Element_Select('brevet');
		$brevet ->setLabel('Choisir un brevet');
		foreach ($lesBrevets as $unBrevet ) {
			$tableauBrevet[$unBrevet -> idBrevet] = ucfirst($unBrevet->nomBrevet);
		} // permet de construite mes données de mon select
		
		if(!isset($tableauBrevet))
		{
			$tableauBrevet = array();
		}
		$brevet->setMultiOptions($tableauBrevet); // remplit ma liste deroulante
		$brevet->setAttrib('id', 'listederoulantebrevet');
		
		$datepicker = new Zend_Form_Element_Text('datepicker');
		$datepicker ->setLabel('Choisir la date d\'obtention');
		$datepicker ->setRequired(true);
		$datepicker -> autocomplete = 'off'; 
		$datepicker->setAttrib('id', 'datepicker');
		 
		$pSubmit = new Zend_Form_Element_Submit('EnvoyerBrevet');
		$pSubmit ->setLabel('Valider');
		$pSubmit->setAttrib('id', 'EnvoyerBrevet');

		/* On ajoute les elements au formulaire */
		$this->addElement($pilote);
		$this->addElement($brevet);
		$this->addElement($datepicker);
		$this->addElement($pSubmit);
		
	}
	


} 