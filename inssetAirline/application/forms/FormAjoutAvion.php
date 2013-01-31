<?php
class FormAjoutAvion extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		
		$this->setAttrib('id', 'forms');
		$this->clearDecorators();
		
		if(isset($_GET['idAvion']))
		{
			$idAvion = new Zend_Form_Element_Hidden('idAvion');
			$idAvion->setValue($_GET['idAvion']);
			$this -> addElement($idAvion);
			$this->setAction('/maintenance/modifier');
		}
		else
		{
			$this->setAction('/maintenance/ajout');
		}
		
		$immatriculation = new Zend_Form_Element_Text('numImmatriculation');
		$immatriculation->setLabel('* Immatriculation de l\'avion :');
		$immatriculation->addValidator('StringLength', true, array('max' => 200));
		$immatriculation->setRequired(true);
		$this -> addElement($immatriculation);
		
		$dateMisEnService = new Zend_Form_Element_Text('dateMisEnService');
		$dateMisEnService->setLabel('* Date de mis en service :');
		$dateMisEnService->setAttrib('id','datepicker');
		$dateMisEnService->setRequired(true);
		$this -> addElement($dateMisEnService);
			
		$statut = new Zend_Form_Element_Select('statut');
		$statut ->setLabel('* Statut de l\'avion :');
		$statut->addMultiOptions(array('actif'=>'actif','en révision'=>'en révision','en vol'=>'en vol'));
		$this->addElement($statut);
		
		$objmodele = new Modele;
		$lesModeles = $objmodele->fetchAll();
		$modele = new Zend_Form_Element_Select('idModele');
		$modele ->setLabel('* Modèle de l\'avion :');
		foreach ($lesModeles as $unModele )
		{
			$listeModele[$unModele['idModele']] = ucfirst($unModele['nomModele']);
		}
		$modele->addMultiOptions($listeModele);
		$this->addElement($modele);
		
		
		$localisation = new Zend_Form_Element_Select('localisation');
		$this->addElement(fonctionAeroport('localisation')->setLabel('* Localisation de l\'avion :'));
		
		$aeroportdattache = new Zend_Form_Element_Select('idAeroportDattache');
		$this->addElement(fonctionAeroport('idAeroportDattache')->setLabel('* Aeroport d\'attache de l\'avion :'));
		
		$reset = new Zend_Form_Element_Reset('Reset');
		$this->addElement($reset);
		
		if(isset($_GET['idAvion']))
		{
			$ajout = new Zend_Form_Element_Submit('envoyer');
			$ajout -> setLabel('Modifier');
			$this -> addElement($ajout);
		}
		else
		{
			$ajout = new Zend_Form_Element_Submit('envoyer');
			$ajout -> setLabel('Ajouter');
			$this -> addElement($ajout);
		}
	}
}