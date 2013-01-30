<?php
class FormAjoutPays extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAttrib('id', 'forms');
		$this->clearDecorators();
		
		if(isset($_GET['idPays']))
		{
			$idPays = new Zend_Form_Element_Hidden('idPays');
			$idPays->setValue($_GET['idPays']);
			$this -> addElement($idPays);
			$this->setAction('/admin/modifierpays');
		}
		else
		{
			$this->setAction('/admin/ajoutpays');
		}
		
		$nompays = new Zend_Form_Element_Text('nomPays');
		$nompays->setLabel('* Nom du pays :');
		$nompays->addValidator('StringLength', true, array('max' => 200));
		$nompays->setRequired(true);
		$this -> addElement($nompays);
		
		if(isset($_GET['idPays']))
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