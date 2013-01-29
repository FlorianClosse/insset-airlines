<?php
class FmodifierReservation extends Zend_Form
{
	public function init()
	{
				
		//Paramétre le formulaire
		$this->setMethod('post')->setAction('/commercial/modifieroption');		
		$this->setAttrib('id', 'FormModifierReservation');
		
		
		//Champ de l'ajout de place à reserver
		$place = new Zend_Form_Element_Text('place');
		$place->setLabel("Nombre de places à reserver :");		
		$place->setRequired(true);
		$place->setAttrib('id', 'formplace');
		
		$statut = new Zend_Form_Element_Select('statut');
		$statut ->setLabel('Choisir un statut');
		$valide='valide';$attente='en attente';
  		$statut->addMultiOption($valide, 'Validé');
  		$statut->addMultiOption($attente, 'en attente');
  		
		$bSubmit = new Zend_Form_Element_Submit('Modifier');
		$bSubmit->setAttrib('id', 'boutonmodifier');
		
		/* On ajoute les elements au formulaire */
		$this->addElement($place);
		$this->addElement($statut);
		$this->addElement($bSubmit);
	}
	
}