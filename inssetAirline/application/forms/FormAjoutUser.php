<?php
class FormAjoutUser extends Zend_Form
{
	public function init()
	{
		require_once 'Fast_Pass_Mnemo.php';
		$this->setMethod('POST');
		$this->setAttrib('id', 'forms');
		$this->clearDecorators();
		
		if(isset($_GET['idUser']))
		{
			$idUser = new Zend_Form_Element_Hidden('idUser');
			$idUser->setValue($_GET['idUser']);
			$this -> addElement($idUser);
			$this->setAction('/admin/modifieruser');
		}
		else
		{
			$this->setAction('/admin/ajoutuser');
		}
		
		$nomuser = new Zend_Form_Element_Text('nomUser');
		$nomuser->setLabel('Nom de l\'utilisateur :*');
		$nomuser->setRequired(true);
		$this -> addElement($nomuser);
		
		$prenomuser = new Zend_Form_Element_Text('prenomUser');
		$prenomuser->setLabel('Prénom de l\'utilisateur :*');
		$prenomuser->setRequired(true);
		$this -> addElement($prenomuser);
		
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('Email :*');
		$email->addValidator('StringLength', true, array('max' => 100));
		$email->addValidator('EmailAddress');
		$email->setRequired(true);
		$this->addElement($email);
		
		$password = Fast_Pass_Mnemo::getOne(12);
		
		$mdp = new Zend_Form_Element_Text('motDePasse');
		$mdp->setLabel('Mot de passe :*');
		$mdp->addValidator('StringLength', true, array('max' => 32));
		$mdp->setRequired(true);
		$mdp->setValue($password);
		$this->addElement($mdp);
		
		$datenaissance = new Zend_Form_Element_Text('dateNaissance');
		$datenaissance->setLabel('Date de naissance de l\'utilisateur :*');
		$datenaissance->setAttrib('id','datepicker');
		$datenaissance->setRequired(true);
		$this -> addElement($datenaissance);
		
		$service = new Service();
		$lesservices = $service->selectAll();
		foreach ($lesservices as $unservice )
		{
			$listeService[$unservice['idService']] = ucfirst($unservice['nomService']);
		}
		$idservice = new Zend_Form_Element_Select('service');
		$idservice ->setLabel('Service de l\'utilisateur :*');
		$idservice->addMultiOptions($listeService);
		$this->addElement($idservice);
		
		$aeroport = new Aeroport;
		$lesAeroports = $aeroport->fetchAll();
		foreach ($lesAeroports as $unAeroport )
		{
			$listeAeroport[$unAeroport['idAeroport']] = ucfirst($unAeroport['nomAeroport']);
		}
		$idaeroport = new Zend_Form_Element_Select('idAeroport');
		$idaeroport ->setLabel('Aéroport de l\'utilisateur :*');
		$idaeroport->addMultiOptions($listeAeroport);
		$this->addElement($idaeroport);
		
		if(isset($_GET['idUser']))
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