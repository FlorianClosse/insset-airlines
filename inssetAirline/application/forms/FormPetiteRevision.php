<?php
class FormPetiteRevision extends Zend_Form
{
	public function init()
	{
		if(isset($_GET['idAvion']) && isset($_GET['statut']))
		{
			$avion = new Avion();
			$lavion = $avion->selectOne($_GET['idAvion']); 
			
			$this->setMethod('POST');
			$this->setAction('/maintenance/plannifier');
			$this->setAttrib('id', 'formPetiteRevision');
			$this->clearDecorators();
			
			$ts = (mktime() + 4838400); //On récupère le TimeStamp dans 8 semaines
	
			$dateprevue = new Zend_Form_Element_Text('datePrevue');
			$dateprevue->setLabel('Date Prévue');
			$dateprevue->setAttrib('id','datepicker');
			$dateprevue->setValue(date('Y-m-d', $ts));
			$dateprevue->setRequired(true);
			$this -> addElement($dateprevue);
				
			$statut = new Zend_Form_Element_Hidden('statut');
			$statut->setValue($_GET['statut']);
			$this->addElement($statut);
			
			$idAvion = new Zend_Form_Element_Hidden('idAvion');
			$idAvion->setValue($_GET['idAvion']);
			$this->addElement($idAvion);
			
			$ajout = new Zend_Form_Element_Submit('envoyer');
			$ajout -> setLabel('Ajouter');
			$this -> addElement($ajout);
		}
	}
}