<?php
class FajoutReservation extends Zend_Form
{
	public function init()
	{
				
		//Paramétre le formulaire
		$this->setMethod('post')->setAction('/commercial/index?valeur=ajout');		
		$this->setAttrib('id', 'FormAjoutReservation');
		
		
		//Champ de l'ajout de place à reserver
		$place = new Zend_Form_Element_Text('place');
		$place->setLabel("Nombre de places à reserver :");		
		$place->setRequired(true);
		$place->setAttrib('id', 'formplace');
		
		$bSubmit = new Zend_Form_Element_Submit('Ajouter');
		$bSubmit->setAttrib('id', 'boutonajoutplace');
		
		/* On ajoute les elements au formulaire */
		$this->addElement($place);
		$this->addElement($bSubmit);
	}
	
}