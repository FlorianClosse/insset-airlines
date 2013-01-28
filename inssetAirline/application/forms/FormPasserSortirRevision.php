<?php
class FormPasserSortirRevision extends Zend_Form
{
	public function init()
	{
		if(isset($_GET['idAvion']) && isset($_GET['action']))
		{
			$avion = new Avion();
			$lavion = $avion->selectOne($_GET['idAvion']); 
			
			$revision = new Revision();
			$plannifie = $revision->isPlannifie($_GET['idAvion']);
			
			$this->setMethod('POST');
			$this->setAction('/maintenance/gererrevision');
			$this->setAttrib('id', 'formPasserSortirRevision');
			$this->clearDecorators();
			
			$idRevision = new Zend_Form_Element_Hidden('idRevision');
			$idRevision->setValue($plannifie[0]['idRevision']);
			$this->addElement($idRevision);
			
			$action = new Zend_Form_Element_Hidden('action');
			$action->setValue($_GET['action']);
			$this->addElement($action);
			
			$idAvion = new Zend_Form_Element_Hidden('idAvion');
			$idAvion->setValue($_GET['idAvion']);
			$this->addElement($idAvion);
	
			$statut = new Zend_Form_Element_Select('statut');
			$statut ->setLabel('Statut de l\'avion');
			$statut->addMultiOptions(array('actif'=>'actif','en révision'=>'en révision','en vol'=>'en vol'));
			$this->addElement($statut);
			
			$ajout = new Zend_Form_Element_Submit('envoyer');
			$ajout -> setLabel('Ajouter');
			$this -> addElement($ajout);
		}
	}
}