<?php
class Fajoutcommentairelogistique extends Zend_Form
{
	public function init()
	{
			 
		// Parametrer le formulaire
		$this->setMethod('post')->setAction('/logistique/ajoutcommentaire');
		$this->setAttrib('id', 'FormAjoutCommentaire');
		
		// Creer de l'elements de formulaire
		$NewCommentaire= new Zend_Form_Element_Textarea('NewCom');
		$NewCommentaire ->setLabel('Taper votre commentaire');
		$NewCommentaire->setAttrib('id', 'formcommentaire');
		$NewCommentaire ->setRequired(TRUE);
		 
		$NewTitre= new Zend_Form_Element_Text('NewTitre');
		$NewTitre ->setLabel('Taper votre titre');
		$NewTitre->setAttrib('id', 'formcommentaire');
		$NewTitre ->setRequired(TRUE);		 
		 

 		$journalDeBord = new Zend_Form_Element_Hidden('journaldebord');
	
		 
		 
		$boutonSubmit = new Zend_Form_Element_Submit('Envoyer');
		$boutonReset = new Zend_Form_Element_Reset('Reset');
		 
		$this->addElement($NewTitre);
		$this->addElement($journalDeBord);
		$this->addElement($NewCommentaire);
		$this->addElement($boutonSubmit);
		$this->addElement($boutonReset);
	}
}