<?php

class MaintenanceController extends Zend_Controller_Action
{
	public function indexAction()
    {
    	$valeur = $this->_getParam('valeur');
    	if(isset($valeur))
    	{
     		switch ($valeur)
    		{
    			case "creer": 
    				$this->_helper->actionStack('creeravion', 'maintenance', 'default', array());
    			break;
    		}	
    	}
    	
    	if(isset($_POST['Envoyer']))
    	{
	    	$avion = New Pilote();
	    	$unAvion = $avion->createRow();
	    	$unAvion->immatriculation = $_POST['immatriculation'];
	    	$unAvion->date = $_POST['dateMisEnService'];
	    	$unAvion->modele = $_POST['modele'];
	    	$unAvion->save();
    	}    	
    }
    
    public function ajoutavionAction()
    {
    	
    	/* Créer un objet formulaire */
    	$formAjoutAvion = new Zend_Form();
    	
    	/* Parametrer le formulaire */
    	$formAjoutAvion->setMethod('post')->setAction('/maintenance/index');
    	$formAjoutAvion->setAttrib('id', 'formAjoutAvion');
    	
    	/* Creer des elements de formulaire */
    	$immatriculation= new Zend_Form_Element_Text('immatriculation');
    	$immatriculation ->setLabel('Immatriculation de l\'avion');
    	$immatriculation ->setRequired(TRUE);
    	$formAjoutAvion->addElement($immatriculation);
    	
    	$dateMisEnService = new Zend_Form_Element_Text('dateMisEnService');
    	$dateMisEnService ->setLabel('Date de mise en service');
    	$dateMisEnService ->setRequired(TRUE);
    	$formAjoutAvion->addElement($dateMisEnService);
    	
//     	$objmodele = new Modele;
//     	$lesModeles = $objmodele->fetchAll();
    	$modele = new Zend_Form_Element_Select('modele');
    	$modele ->setLabel('Modele de l\'avion');
    	$modele->addMultiOptions(array('1'=>'airbus','2'=>'747'));
    	$formAjoutAvion->addElement($modele);
    	   	
//     	foreach ($lesAeroport as $unAeroport ) {
//     		$tableauAeroport[$unAeroport -> idAeroport] = ucfirst($unAeroport->nomAeroport);
//     	} // permet de construite mes données de mon select
    	 
    	$submit = new Zend_Form_Element_Submit('Envoyer');
    	$formAjoutAvion->addElement($submit);
    	
    	$reset = new Zend_Form_Element_Reset('Reset');
    	$formAjoutAvion->addElement($reset);
	
    	/* Effectuer le rendu du formulaire */
    	echo $formAjoutAvion;
    } 
}

?>