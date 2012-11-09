<?php

class MaintenanceController extends Zend_Controller_Action
{
	public function indexAction()
    {
    
    }
    
    public function ajoutavionAction()
    {
    	if(isset($_POST['Envoyer']))
    	{
    		$db=Zend_Db::factory(Zend_Registry::get('config')->database);
//     		$data=array(	'numImmatriculation'=> $_POST['immatriculation'],
//     						'dateMisEnService'=>$_POST['dateMisEnService'],
//     						'nombreHeureTotale'=>0,
//     						'nbHeureVolDepuisGrandeRevision'=>0,
//     						'nbHeureVolDepuisPetiteRevision'=>0,
//     						'statut'=>$_POST['statut'],
//     						'modele'=>$_POST['modele']
//     					);
//     		$db->inssert(avion,$data);
    		$message='L\'avion a bien été ajouté';
    		$this->view->message = $message;
    	}
    	else
    	{
	    	/* Créer un objet formulaire */
	    	$formAjoutAvion = new Zend_Form();
	    	
	    	/* Parametrer le formulaire */
	    	$formAjoutAvion->setMethod('post')->setAction('/maintenance/ajoutavion');
	    	$formAjoutAvion->setAttrib('id', 'formAjoutAvion');
	    	
	    	/* Creer des elements de formulaire */
	    	$immatriculation= new Zend_Form_Element_Text('immatriculation');
	    	$immatriculation ->setLabel('Immatriculation de l\'avion');
	    	$immatriculation ->setRequired(TRUE);
	    	$formAjoutAvion->addElement($immatriculation);
	    	
	    	$dateMisEnService = new Zend_Form_Element_Text('dateMisEnService');
	    	$dateMisEnService ->setLabel('Date de mise en service');
	    	$dateMisEnService ->setRequired(TRUE);
	    	$dateMisEnService->addValidator('Date');
	    	$formAjoutAvion->addElement($dateMisEnService);
	    	
	    	$statut = new Zend_Form_Element_Select('statut');
	    	$statut ->setLabel('Statut de l\'avion');
	    	$statut->addMultiOptions(array('1'=>'en service','2'=>'en révision'));
	    	$formAjoutAvion->addElement($statut);
	    	
	    	$objmodele = new Modele;
	    	$lesModeles = $objmodele->fetchAll();
	    	foreach ($lesModeles as $unModele ) 
	    	{
	    		$listeModele[$unModele['idModele']] = ucfirst($unModele['nomModele']);
	    	}
	    	$modele = new Zend_Form_Element_Select('modele');
	    	$modele ->setLabel('Modele de l\'avion');
	    	$modele->addMultiOptions($listeModele);
	    	$formAjoutAvion->addElement($modele);
	    	
	    	$aeroport = new Aeroport;
	    	$lesAeroports = $aeroport->fetchAll();
	    	foreach ($lesAeroports as $unAeroport ) 
	    	{
	    		$listeAeroport[$unAeroport['idAeroport']] = ucfirst($unAeroport['nomAeroport']);
	    	}
	    	$localisation = new Zend_Form_Element_Select('localisation');
	    	$localisation ->setLabel('Localisation de l\'avion');
	    	$localisation->addMultiOptions($listeAeroport);
	    	$formAjoutAvion->addElement($localisation);
	    	
	    	$aeroportdattache = new Zend_Form_Element_Select('aeroportdattache');
	    	$aeroportdattache ->setLabel('Aeroport d\'attache de l\'avion');
	    	$aeroportdattache->addMultiOptions($listeAeroport);
	    	$formAjoutAvion->addElement($aeroportdattache);
	    	 
	    	$submit = new Zend_Form_Element_Submit('Envoyer');
	    	$formAjoutAvion->addElement($submit);
	    	
	    	$reset = new Zend_Form_Element_Reset('Reset');
	    	$formAjoutAvion->addElement($reset);
		
	    	$this->view->formajoutavion = $formAjoutAvion;
    	}
    } 
}

?>