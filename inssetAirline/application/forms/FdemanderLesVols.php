<?php
class FdemanderLesVols extends Zend_Form
{
	public function init()
	{
		/* Parametrer le formulaire */
		$this->setMethod('post')->setAction('/commercial/index?valeur=ajout');
		$this->setAttrib('id', 'FormAjoutOption');
		 
		/* Creer des elements de formulaire */
 		
 		$aeroportD = new Aeroport;
 		$lesAeroportD = $aeroportD->fetchAll();
 		
 		$aeroportD = new Zend_Form_Element_Select('aeroportD');
 		$aeroportD ->setLabel('Choisir un aeroport de départ');
 		
 		foreach ($lesAeroportD as $unAeroportD ) 
 		{
 			$tableauAeroportD[$unAeroportD -> idAeroport] = ucfirst($unAeroportD->nomAeroport);
 		}
 		$aeroportD->setMultiOptions($tableauAeroportD);
 		
 		$aeroportA = new Aeroport;
 		$lesAeroportA = $aeroportA->fetchAll();
 		
 		$aeroportA = new Zend_Form_Element_Select('aeroportA');
 		$aeroportA ->setLabel('Choisir un aeroport d\'arrivé');
 		
 		foreach ($lesAeroportA as $unAeroportA )
 		{
 			$tableauAeroportA[$unAeroportA -> idAeroport] = ucfirst($unAeroportA->nomAeroport);
 		}
 		$aeroportA->setMultiOptions($tableauAeroportA);
 		
//  		$paysDe = new Pays;
//  		$lesPaysD = $paysDe->fetchAll();
 		
//  		$paysD = new Zend_Form_Element_Select('paysD');
//  		$paysD ->setLabel('Choisir un Pays de départ');
//  		foreach ($lesPaysD as $unPaysD)
//  		{
//  			$tableauPaysD[$unPaysD -> idPays] = $unPaysD->nomPays;
//  		}
//  		$paysD->setMultiOptions($tableauPaysD);
 		
//  		$paysAe = new Pays;
//  		$lesPaysA = $paysAe->fetchAll();
//  		$paysA = new Zend_Form_Element_Select('paysA');
//  		$paysA ->setLabel('Choisir un Pays d\'arrivé');
//  		foreach ($lesPaysA as $unPaysA)
//  		{
//  			$tableauPaysA[$unPaysA -> idPays] = $unPaysA->nomPays;
//  		} 		
//  		$paysA->setMultiOptions($tableauPaysA);  			
 		
 		$date = new Zend_Form_Element_Text('datepicker');
		$date ->setLabel('Date ');
		$date ->setRequired(TRUE);
		$date ->addValidator('Date');
 		
 		$bSubmit = new Zend_Form_Element_Submit('Envoyer');
 		$bSubmit->setAttrib('id', 'demander');
 		
 		$boutonReset = new Zend_Form_Element_Reset('Reset');		
		
		$this->addElement($date);
		//$this->addElement($paysD);
		$this->addElement($aeroportD);		
		//$this->addElement($paysA);
		$this->addElement($aeroportA);
		$this->addElement($bSubmit);
		$this->addElement($boutonReset);
	}
}