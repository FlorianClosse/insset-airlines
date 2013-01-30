<?php
class FormFiltreMaintenance extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAction('/maintenance/index');
		$this->setAttrib('id', 'formfiltremaintenance');
		$this->clearDecorators();
			
		
		$decoratorElem = array ('ViewHelper', 'Description', array ('HtmlTag', array ('tag' => 'td' ) ), array ('Label', array ('tag' => 'td', 'align' => 'left' ) ) ); // définition du décorateur pour l'alignement du champ et de son label
		$decoratorElem2 = array ('ViewHelper', 'Description', array ('HtmlTag', array ('tag' => 'tr' ) ) ); // définition du décorateur pour l'alignement du champ et de son label
		   
		$statut = new Zend_Form_Element_Select('statut');
		$statut ->setLabel('Statut');
		$statut->addMultiOptions(array('0'=>'Choisissez une valeur','actif'=>'actif','en révision'=>'en révision','en vol'=>'en vol'));
		$this->addElement($statut);
		$statut->setDecorators($decoratorElem);
		
		$objmodele = new Modele;
		$lesModeles = $objmodele->fetchAll();
		$listeModele[0]='Choisissez une valeur';
		foreach ($lesModeles as $unModele )
		{
			$listeModele[$unModele['idModele']] = ucfirst($unModele['nomModele']);
		}
		
		$modele = new Zend_Form_Element_Select('idModele');
		$modele ->setLabel('Modele');
		$modele->setDecorators($decoratorElem);
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
		$localisation ->setLabel('Localisation');
		$localisation->setDecorators($decoratorElem);
		$localisation->addMultiOptions($listeAeroport);
		$this->addElement($localisation);
		
		$aeroportdattache = new Zend_Form_Element_Select('idAeroportDattache');
		$aeroportdattache ->setLabel('Aeroport d\'attache');
		$aeroportdattache->setDecorators($decoratorElem);
		$aeroportdattache->addMultiOptions($listeAeroport);
		$this->addElement($aeroportdattache);
		
		$ajout = new Zend_Form_Element_Submit('envoyer');
		$ajout -> setLabel('Filtrer');
		$this -> addElement($ajout);
	}
}