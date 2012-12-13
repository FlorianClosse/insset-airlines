<?php

class FormulaireServiceTechniqueEnvoiVol extends Zend_Form
{
	private $identifiant;
	private $action;
	
	public function __construct ($identifiant, $action)
	{
		$this -> setIdentifiant($identifiant);
		$this -> setAction($action);
	
		$decorateurBouton=array(
				array('ViewHelper'),
				array('Errors'),
				array(
						array('DivTag'=>'HtmlTag'),
						array('tag'=>'div','class'=>'boutonFormulaire')
				)
		);
		
		$decorateurFormulaire=array('FormElements','Form');
			
		$this -> setDecorators($decorateurFormulaire);
		$this -> setMethod('post');
		$this -> setAction($this->action);
		$this -> setAttrib('id','formulaire'.$this->identifiant);

		$bouton = new Zend_Form_Element_Submit('ajouter'.$this->identifiant);
		$bouton -> setLabel('Envoyer');
		$bouton -> setDecorators($decorateurBouton);
		$this -> addElement($bouton);
	}

	public function setIdentifiant($identifiant)
	{
		$this->identifiant = $identifiant;
	}
	
	public function setAction($action)
	{
		$this->action = $action;
	}
}