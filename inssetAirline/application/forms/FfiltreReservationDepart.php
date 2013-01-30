<?php
class FfiltreReservationDepart extends Zend_Form
{
	public function init()
	{
				
		//Paramétre le formulaire
		$this->setMethod('post')->setAction('/commercial/index?valeur=afficher');		
		$this->setAttrib('id', 'forms');
		
		
		$aeroportD = new Aeroport;
 		$lesAeroportD = $aeroportD->fetchAll();
 		
 		$aeroportD = new Zend_Form_Element_Select('aeroportD'); 		
 		
		$bSubmitD = new Zend_Form_Element_Submit('FiltrerD');
		$bSubmitD->setAttrib('id', 'boutonfiltreD');
		$bSubmitD->setLabel('Filtrer');			
		
		
		/* On ajoute les elements au formulaire */
		$this->addElement(fonctionAeroport('aeroportD'));
		$this->addElement($bSubmitD);	
		
	}
	
}