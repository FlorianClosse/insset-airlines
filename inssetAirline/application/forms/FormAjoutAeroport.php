<?php
class FormAjoutAeroport extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAttrib('id', 'forms');
		$this->clearDecorators();
		
		if(isset($_GET['idAeroport']))
		{
			$idAeroport = new Zend_Form_Element_Hidden('idAeroport');
			$idAeroport->setValue($_GET['idAeroport']);
			$this -> addElement($idAeroport);
			$this->setAction('/admin/modifieraeroport');
		}
		else
		{
			$this->setAction('/admin/ajoutaeroport');
		}
		
		$nomAeroport = new Zend_Form_Element_Text('nomAeroport');
		$nomAeroport->setLabel('* Nom de l\'aéroport :');
		$nomAeroport->addValidator('StringLength', true, array('max' => 200));
		$nomAeroport->setRequired(true);
		$this -> addElement($nomAeroport);
		
		$trigramme = new Zend_Form_Element_Text('trigramme');
		$trigramme->setLabel('* Trigramme :');
		$trigramme->setRequired(true);
		$this -> addElement($trigramme);
			
		$longueurPiste = new Zend_Form_Element_Text('longueurPiste');
		$longueurPiste ->setLabel('* Longueur de la piste :');
		$longueurPiste->setRequired(true);
		$this->addElement($longueurPiste);
			
		$ville = new Ville();
		$lesvilles = $ville->fetchAll();
		foreach ($lesvilles as $uneville )
		{
			$listeville[$uneville['idVille']] = ucfirst($uneville['nomVille']);
		}
		
		$idVille = new Zend_Form_Element_Select('idVille');
		$idVille ->setLabel('* Ville :');
		$idVille->addMultiOptions($listeville);
		$this->addElement($idVille);
		
		if(isset($_GET['idAeroport']))
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