<?php
class FfiltreLogistiqueArrivee extends Zend_Form
{
	public function init()
	{
				
		//Paramétre le formulaire
		$this->setMethod('post')->setAction('/logistique/index?valeur=afficher');		
		$this->setAttrib('id', 'forms');
		
		
		$aeroportD = new Aeroport;
 		$lesAeroportD = $aeroportD->fetchAll(); 		
 		
 		$aeroportA = new Aeroport;
 		$lesAeroportA = $aeroportA->fetchAll();
 		
 		$aeroportA = new Zend_Form_Element_Select('aeroportA'); 			
 		
		$bSubmitA = new Zend_Form_Element_Submit('FiltrerA');
		$bSubmitA->setAttrib('id', 'boutonfiltreA');
		$bSubmitA->setLabel('Filtrer');	
		
		
		$bSubmitVider = new Zend_Form_Element_Submit('Vider');
		$bSubmitVider->setAttrib('id', 'boutonvider');
		$bSubmitVider->setLabel('Vider les filtres');
		
		/* On ajoute les elements au formulaire */		
		$this->addElement(fonctionAeroport('aeroportA'));
		$this->addElement($bSubmitA);
		$this->addElement($bSubmitVider);
	}
	
}