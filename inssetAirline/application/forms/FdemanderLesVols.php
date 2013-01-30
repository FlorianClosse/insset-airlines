<?php
class FdemanderLesVols extends Zend_Form
{
	public function init()
	{
		/* Parametrer le formulaire */
		$this->setMethod('post')->setAction('/commercial/index?valeur=ajout');
		$this->setAttrib('id', 'forms');
		 
		/* Creer des elements de formulaire */
 		
 		$aeroportD = new Aeroport;
 		$lesAeroportD = $aeroportD->fetchAll();
 		
 		$aeroportD = new Zend_Form_Element_Select('aeroportD');
 		$aeroportD ->setLabel('Choisir un aeroport de départ');
 		
 		
 		$aeroportA = new Aeroport;
 		$lesAeroportA = $aeroportA->fetchAll();
 		
 		$aeroportA = new Zend_Form_Element_Select('aeroportA');
 				
 		
 		

 		$date = new Zend_Form_Element_Text('datepicker');
		$date ->setLabel('Date ');
		$date ->setRequired(TRUE);
		$date ->addValidator('Date');
 		
 		$bSubmit = new Zend_Form_Element_Submit('Envoyer');
 		$bSubmit->setAttrib('id', 'demander');
 		
 		$boutonReset = new Zend_Form_Element_Reset('Reset');		
		
		$this->addElement($date);		
		$this->addElement(fonctionAeroport('aeroportD'));		
		$this->addElement(fonctionAeroport('aeroportA'));
		$this->addElement($bSubmit);
		$this->addElement($boutonReset);
	}
}