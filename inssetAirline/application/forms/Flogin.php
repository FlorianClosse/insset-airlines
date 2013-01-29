<?php
class Flogin extends Zend_Form
{
	
	public function init(){
		/* Parametrer le formulaire */
    	$this->setMethod('post')->setAction('/index/login');
    	$this->setAttrib('id', 'form');
	
    	
    	
    	$decoratorElem = array ('ViewHelper', 'Description', array ('HtmlTag', array ('tag' => 'td' ) ), array ('Label', array ('tag' => 'td', 'align' => 'left' ) ) ); // définition du décorateur pour l'alignement du champ et de son label
    	$decoratorElem2 = array ('ViewHelper', 'Description', array ('HtmlTag', array ('tag' => 'tr' ) ) ); // définition du décorateur pour l'alignement du champ et de son label
    	   
    	
		$email = new  Zend_Form_Element_Text('email');
		$email ->setLabel('Email :');
		$email->setDecorators($decoratorElem);
		
		$password = new Zend_Form_Element_Password('password');
		$password->setDecorators($decoratorElem);
		$password->setLabel('Mot de passe : ')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim');
	
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setDecorators($decoratorElem2);
		$submit->setAttrib('id', 'submitbutton')
		->setLabel('Se connecter');
	
		$elements = array($email,$password, $submit);
		$this->addElements($elements);
	
// 		$this->setDecorators(array(
// 				'FormElements',
// 				array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
// 				array('Errors', array('placement' => 'apend')),
// 				'Form'
// 		));
	}
	
}
