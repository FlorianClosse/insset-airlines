<?php
class FfiltreReservationDepart extends Zend_Form
{
	public function init()
	{
				
		//Paramétre le formulaire
		$this->setMethod('post')->setAction('/commercial/index?valeur=afficher');		
		$this->setAttrib('id', 'FormFiltreReservation');
		
		
		$aeroportD = new Aeroport;
 		$lesAeroportD = $aeroportD->fetchAll();
 		
 		$aeroportD = new Zend_Form_Element_Select('aeroportD');
 		$aeroportD ->setLabel('Choisir un aeroport de départ');
 		
 		foreach ($lesAeroportD as $unAeroportD ) 
 		{
 			$tableauAeroportD[$unAeroportD -> idAeroport] = ucfirst($unAeroportD->nomAeroport);
 		}
 		$aeroportD->setMultiOptions($tableauAeroportD);			
 		
 		
		$bSubmitD = new Zend_Form_Element_Submit('FiltrerD');
		$bSubmitD->setAttrib('id', 'boutonfiltreD');
		$bSubmitD->setLabel('Filtrer');			
		
		
		/* On ajoute les elements au formulaire */
		$this->addElement($aeroportD);
		$this->addElement($bSubmitD);	
		
	}
	
}