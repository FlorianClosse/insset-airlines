<?php
class FfiltreReservationArrivee extends Zend_Form
{
	public function init()
	{
				
		//Paramétre le formulaire
		$this->setMethod('post')->setAction('/commercial/index?valeur=afficher');		
		$this->setAttrib('id', 'FormFiltreReservation');
		
		
		$aeroportD = new Aeroport;
 		$lesAeroportD = $aeroportD->fetchAll(); 		
 		
 		$aeroportA = new Aeroport;
 		$lesAeroportA = $aeroportA->fetchAll();
 		
 		$aeroportA = new Zend_Form_Element_Select('aeroportA');
 		$aeroportA ->setLabel('Choisir un aeroport d\'arrivé');
 		
 		foreach ($lesAeroportA as $unAeroportA )
 		{
 			$tableauAeroportA[$unAeroportA -> idAeroport] = ucfirst($unAeroportA->nomAeroport);
 		}
 		$aeroportA->setMultiOptions($tableauAeroportA);
		
 		
 		
		$bSubmitA = new Zend_Form_Element_Submit('FiltrerA');
		$bSubmitA->setAttrib('id', 'boutonfiltreA');
		$bSubmitA->setLabel('Filtrer');	
		
		
		$bSubmitVider = new Zend_Form_Element_Submit('Vider');
		$bSubmitVider->setAttrib('id', 'boutonvider');
		$bSubmitVider->setLabel('Vider les filtres');
		
		/* On ajoute les elements au formulaire */		
		$this->addElement($aeroportA);
		$this->addElement($bSubmitA);
		$this->addElement($bSubmitVider);
	}
	
}