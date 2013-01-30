<?php
class FormAjoutVille extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAttrib('id', 'forms');
		$this->clearDecorators();
		
		if(isset($_GET['idVille']))
		{
			$idAeroport = new Zend_Form_Element_Hidden('idVille');
			$idAeroport->setValue($_GET['idVille']);
			$this -> addElement($idAeroport);
			$this->setAction('/admin/modifierville');
		}
		else
		{
			$this->setAction('/admin/ajoutville');
		}
		
		$nomville = new Zend_Form_Element_Text('nomVille');
		$nomville->setLabel('* Nom de la ville :');
		$nomville->addValidator('StringLength', true, array('max' => 200));
		$nomville->setRequired(true);
		$this -> addElement($nomville);
		
		$cp = new Zend_Form_Element_Text('cpVille');
		$cp->setLabel('* Code postal :');
		$cp->setRequired(true);
		$this -> addElement($cp);
			
		$pays = new Pays();
		$lespays = $pays->fetchAll();
		foreach ($lespays as $unpays )
		{
			$listepays[$unpays['idPays']] = ucfirst($unpays['nomPays']);
		}
		
		$idPays = new Zend_Form_Element_Select('idPays');
		$idPays ->setLabel('* Pays :');
		$idPays->addMultiOptions($listepays);
		$this->addElement($idPays);
		
		if(isset($_GET['idVille']))
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