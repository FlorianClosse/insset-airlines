<?php
class FormAjoutBrevet extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAttrib('id', 'forms');
		$this->clearDecorators();
		
		if(isset($_GET['idBrevet']))
		{
			$idBrevet = new Zend_Form_Element_Hidden('idBrevet');
			$idBrevet->setValue($_GET['idBrevet']);
			$this -> addElement($idBrevet);
			$this->setAction('/admin/modifierbrevet');
		}
		else
		{
			$this->setAction('/admin/ajoutbrevet');
		}
		
		$nombrevet = new Zend_Form_Element_Text('nomBrevet');
		$nombrevet->setLabel('Nom du brevet :*');
		$nombrevet->addValidator('StringLength', true, array('max' => 200));
		$nombrevet->setRequired(true);
		$this -> addElement($nombrevet);
			
		$liste =array() ;
		for($i=1;$i<16;$i++)
		{
			if($i<10)
			{
				$liste[$i]= 0 . $i;
			}
			else
			{
				$liste[$i]=$i;
			}
		}
		
		$duree = new Zend_Form_Element_Select('dureeBrevetEnAnnee');
		$duree ->setLabel('Durée du brevet en année :*');
		$duree->addMultiOptions($liste);
		$this->addElement($duree);
		
		if(isset($_GET['idBrevet']))
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