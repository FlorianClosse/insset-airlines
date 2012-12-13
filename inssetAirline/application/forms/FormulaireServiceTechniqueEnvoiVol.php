<?php

class FormulaireServiceTechniqueEnvoiVol extends Zend_Form
{
	private $identifiant;
	
	public function __construct ($identifiant)
	{
		$this -> setIdentifiant($identifiant);
	
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
		$this -> setAction('index?valeur=decollage');
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
}