<?php
class FormAjoutAvion extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAction('/maintenance/ajoutavion');
		$this->setAttrib('id', 'formAjoutAvion');
		$this->clearDecorators();
		
		$deco= array(
				array('ViewHelper'),
				array('Errors'),
				array('HtmlTag'),
				array('Label')
		);
		
		$immatriculation = new Zend_Form_Element_Text('immatriculation');
		$immatriculation->setLabel('Immatriculation de l\'avion');
		$immatriculation->addValidator('StringLength', true, array('max' => 200));
		$immatriculation->setRequired(true);
		$immatriculation->setDecorators($deco);
		$this -> addElement($immatriculation);
		
		$dateMisEnService = new Zend_Form_Element_Text('dateMisEnService');
		$dateMisEnService->setAttrib('id','datepicker');
		$dateMisEnService->addValidator('Date');
		$dateMisEnService->setRequired(true);
		$this -> addElement($dateMisEnService);
			
		$statut = new Zend_Form_Element_Select('statut');
		$statut ->setLabel('Statut de l\'avion');
		$statut->addMultiOptions(array('1'=>'en service','2'=>'en révision'));
		$this->addElement($statut);
			
		$aeroport = new Aeroport;
		$lesAeroports = $aeroport->fetchAll();
		foreach ($lesAeroports as $unAeroport )
		{
			$listeAeroport[$unAeroport['idAeroport']] = ucfirst($unAeroport['nomAeroport']);
		}
		
		$objmodele = new Modele;
		$lesModeles = $objmodele->fetchAll();
		$modele = new Zend_Form_Element_Select('modele');
		$modele ->setLabel('Modele de l\'avion');
		foreach ($lesModeles as $unModele )
		{
			$listeModele[$unModele['idModele']] = ucfirst($unModele['nomModele']);
		}
		$modele->addMultiOptions($listeModele);
		$this->addElement($modele);
		
		
		$localisation = new Zend_Form_Element_Select('localisation');
		$localisation ->setLabel('Localisation de l\'avion');
		$localisation->addMultiOptions($listeAeroport);
		$this->addElement($localisation);
		
		$aeroportdattache = new Zend_Form_Element_Select('aeroportdattache');
		$aeroportdattache ->setLabel('Aeroport d\'attache de l\'avion');
		$aeroportdattache->addMultiOptions($listeAeroport);
		$this->addElement($aeroportdattache);
		
		$reset = new Zend_Form_Element_Reset('Reset');
		$this->addElement($reset);
		
		$ajout = new Zend_Form_Element_Submit('envoyer');
		$ajout -> setLabel('Ajouter');
		$this -> addElement($ajout);
	}
}