<?php
class Fdeco extends Zend_Form
{
	public function init(){
		/* Parametrer le formulaire */
    	$this->setMethod('post')->setAction('/index/deco');
    	$this->setAttrib('id', 'form');
    	
  	 	$decoratorElem2 = array ('ViewHelper', 'Description', array ('HtmlTag', array ('tag' => 'tr' ) ) ); // définition du décorateur pour l'alignement du champ et de son label
    	   
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setDecorators($decoratorElem2);
		$submit->setAttrib('id', 'submitbutton')
		->setAttrib('class','submitbuttonedeco')
		->setLabel('');
	
		$elements = array($submit);
		$this->addElements($elements);
	
	}
	
}