<?php
class FormFiltreMaintenance extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAction('/maintenance/index');
		$this->setAttrib('id', 'forms');
		$this->clearDecorators();
			
		$statut = new Zend_Form_Element_Select('statut');
		$statut ->setLabel('Statut de l\'avion');
		$statut->addMultiOptions(array('0'=>'Choisissez une valeur','actif'=>'actif','en révision'=>'en révision','en vol'=>'en vol'));
		$this->addElement($statut);
		
		$objmodele = new Modele;
		$lesModeles = $objmodele->fetchAll();
		$listeModele[0]='Choisissez une valeur';
		foreach ($lesModeles as $unModele )
		{
			$listeModele[$unModele['idModele']] = ucfirst($unModele['nomModele']);
		}
		
		$modele = new Zend_Form_Element_Select('idModele');
		$modele ->setLabel('Modele de l\'avion');
		$modele->addMultiOptions($listeModele);
		$this->addElement($modele);		
		
		$aeroport = new Aeroport;
		$lesAeroports = $aeroport->fetchAll();
		$listeAeroport[0]='Choisissez une valeur';
		foreach ($lesAeroports as $unAeroport )
		{
			$listeAeroport[$unAeroport['idAeroport']] = ucfirst($unAeroport['nomAeroport']);
		}
		
		$localisation = new Zend_Form_Element_Select('localisation');
		$localisation ->setLabel('Localisation de l\'avion');
		$localisation->addMultiOptions($listeAeroport);
		$this->addElement($localisation);
		
		$aeroportdattache = new Zend_Form_Element_Select('idAeroportDattache');
		$aeroportdattache ->setLabel('Aeroport d\'attache de l\'avion');
		$aeroportdattache->addMultiOptions($listeAeroport);
		$this->addElement($aeroportdattache);
		
		$ajout = new Zend_Form_Element_Submit('envoyer');
		$ajout -> setLabel('Filtrer');
		$this -> addElement($ajout);
	}
}