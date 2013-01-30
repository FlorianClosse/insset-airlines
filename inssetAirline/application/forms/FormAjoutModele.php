<?php
class FormAjoutModele extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAttrib('id', 'forms');
		$this->clearDecorators();
		
		if(isset($_GET['idModele']))
		{
			$idModele = new Zend_Form_Element_Hidden('idModele');
			$idModele->setValue($_GET['idModele']);
			$this -> addElement($idModele);
			$this->setAction('/admin/modifiermodele');
		}
		else
		{
			$this->setAction('/admin/ajoutmodele');
		}
		
		$nomModele = new Zend_Form_Element_Text('nomModele');
		$nomModele->setLabel('* Nom du modèle :');
		$nomModele->addValidator('StringLength', true, array('max' => 50));
		$nomModele->setRequired(true);
		$this -> addElement($nomModele);
		
		$longueurPiste = new Zend_Form_Element_Text('longueurPiste');
		$longueurPiste ->setLabel('* Longueur de la piste :');
		$longueurPiste->setRequired(true);
		$this->addElement($longueurPiste);
		
		$rayonDaction = new Zend_Form_Element_Text('rayonDaction');
		$rayonDaction ->setLabel('* Rayon d\'action :');
		$rayonDaction->setRequired(true);
		$this->addElement($rayonDaction);
		
		$nbPlace = new Zend_Form_Element_Text('nbPlace');
		$nbPlace ->setLabel('* Nombre de place :');
		$nbPlace->setRequired(true);
		$this->addElement($nbPlace);
		
		$periodePetiteRevision = new Zend_Form_Element_Text('periodePetiteRevision');
		$periodePetiteRevision ->setLabel('* Temps avant petite révision (en heure) :');
		$periodePetiteRevision->setRequired(true);
		$this->addElement($periodePetiteRevision);
		
		$periodeGrandeRevision = new Zend_Form_Element_Text('periodeGrandeRevision');
		$periodeGrandeRevision ->setLabel('* Temps avant grande révision (en heure) :');
		$periodeGrandeRevision->setRequired(true);
		$this->addElement($periodeGrandeRevision);
		
		if(isset($_GET['idModele']))
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