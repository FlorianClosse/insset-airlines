<?php
class FfiltreReservationArrivee extends Zend_Form
{
	public function init()
	{
				
		//Paramétre le formulaire
		$this->setMethod('post')->setAction('/commercial/index?valeur=afficher');		
		$this->setAttrib('id', 'forms');
		
		
		$aeroportD = new Aeroport;
 		$lesAeroportD = $aeroportD->fetchAll(); 		
 		
 		$aeroportA = new Aeroport;
 		$lesAeroportA = $aeroportA->fetchAll();
 		
 		$aeroportA = new Zend_Form_Element_Select('aeroportA'); 			
 		
		$bSubmitA = new Zend_Form_Element_Submit('FiltrerA');
		$bSubmitA->setAttrib('id', 'boutonfiltreA');
		$bSubmitA->setLabel('Filtrer');			
		
		/* On ajoute les elements au formulaire */		
		$this->addElement(fonctionAeroport('aeroportA'));
		$this->addElement($bSubmitA);
		
	}
	
}