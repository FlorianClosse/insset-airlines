<?php

class LogistiqueController extends Zend_Controller_Action
{
	public function init(){
		$this->_helper->actionStack('login', 'index', 'default', array());
	}
	
	public function preDispatch()
	{
		
		// Ne rend plus aucune action de ce contrôleur
		$auth = Zend_Auth::getInstance();
		if (!$auth->hasIdentity())
		{
			$this->_redirect('/index/login');
		}
		
	if($_SESSION['Zend_Auth']['storage']->service != 9){
			if($_SESSION['Zend_Auth']['storage']->service != 4){
				$this->_redirect('/index');
			}
		}
	}
	
	public function indexAction()
	{					
		$valeur = $this->_getParam('valeur');
		
		
		$this->_helper->actionStack('affichercommentaire', 'logistique', 'default', array());
			
		
		//******** affichage de commentaire (bouton valider) ********
		$compteur = 0;		
		$commentaire = new CommentaireVol;
		$lesCommentaires = $commentaire->fetchAll();
				
		if(isset($_POST['valider']))
		{
			foreach($lesCommentaires as $unCommentaires)
			{
				if(isset($_POST[$unCommentaires->idJournalDeBord]))
				{
					if($_POST[$unCommentaires->idJournalDeBord] == 1)
					{
						$idVolSelectionne= $unCommentaires->idJournalDeBord;
									    
						foreach ($lesCommentaires as $unCommentaire)
						{		
							if($idVolSelectionne == $unCommentaire->idJournalDeBord)
							{
								$compteur=$compteur+1;
								$tableauCom[$compteur][0] = $unCommentaire->idCommentaireVol;
								$tableauCom[$compteur][1] = $unCommentaire->idJournalDeBord;
								$tableauCom[$compteur][2] = $unCommentaire->titre;
								$tableauCom[$compteur][3] = $unCommentaire->commentaire;															
							}
						}
						$this->view->compteur = $compteur;
					}
				}
			}
			if(isset($tableauCom))
			{
				$this->view->tableauCom = $tableauCom;
			}
			else
			{
				echo 'Il n\'y a pas de commentaire pour ce vol';
			}
		}		
	}
	
	//***** fonction afficher*****
	public function affichercommentaireAction()
	{		
    	//decorateur des cases a cocher
    	$decorateurCase = array(
    			array('ViewHelper'),
    			array('Errors'),
    			array('HtmlTag', array('tag'=>'td')),
    			array(
    					array('tr' => 'HtmlTag'),
    					array('tag'=> 'tr')
    				  )
    	);
    	//decorateur du bouton submit
    	$decorateurBoutonValider = array(
    			array('ViewHelper'),
    			array('Errors'),
    			array('HtmlTag', array('tag'=>'td', 'class'=>'boutonValider')),
    			array(
    					array('tr' => 'HtmlTag'),
    					array('tag'=> 'tr'),
    				  )
    	);    		
    	//decorateur du bouton formulaire complet
    	$decorateurTableau = array(
    			array('FormElements'),
    			array('HtmlTag', array('tag'=>'table', 'id'=>'tableauCaseACocherVol'))
    	); 
    	
    	$journal = new JournalDeBord;    	
		$lesJournaux = $journal->getVolEnCour();

		$aeroport = new Aeroport();
		
		$formFiltreDepart = new FfiltreLogistiqueDepart();
		$formFiltreArrivee = new FfiltreLogistiqueArrivee();
		
		if(isset($_POST['Vider']))
		{
			unset($_SESSION['depart']);
			unset($_SESSION['arrivee']);
			$this->_redirect('/logistique/index?valeur=afficher');
		}
		
		if(isset($_POST['aeroportD']))
			$_SESSION['depart'] = $_POST['aeroportD'];
		
		if(isset($_POST['aeroportA']))
			$_SESSION['arrivee'] = $_POST['aeroportA'];
		
		
		if(isset($_SESSION['depart']) && isset($_SESSION['arrivee']))
		{
			$lesJournaux = $journal-> getAeroportDepartArrivee($_SESSION['depart'],$_SESSION['arrivee']);
		}
		else
		{
			if(isset($_SESSION['depart']))
			{
				$lesJournaux = $journal-> getAeroportDepart($_SESSION['depart']);
			}
			else
			{
				if(isset($_SESSION['arrivee']))
				{
					$lesJournaux = $journal-> getAeroportArrivee($_SESSION['arrivee']);
				}
				else
				{
					$lesJournaux = $journal->getVolEnCour();
				}
			}
		}
		
		
		$this->view->formFiltreDepart = $formFiltreDepart;
		$this->view->formFiltreArrivee = $formFiltreArrivee;
				
		$page=$this->_getParam('page',1);
		$paginator = Zend_Paginator::factory($lesJournaux);
		$paginator->setCurrentPageNumber($this->_getParam('page'));
		$paginator->setItemCountPerPage(10);
		$paginator->setCurrentPageNumber($page);

    	//on crée le formulaire
    	$formulaireAfficherVol = new Zend_Form();
    	$formulaireAfficherVol -> setMethod('post');
    	$formulaireAfficherVol -> setAction('/logistique/index/');
    	$formulaireAfficherVol -> setAttrib('id','forms');
    	$formulaireAfficherVol -> addDecorators($decorateurTableau);
    		 
    	foreach($paginator as $unJournal)
    	{    			
    		$caseACocher = new Zend_Form_Element_Checkbox($unJournal['idJournalDeBord']);
    		$caseACocher->setAttrib('id', 'forms');
    		$caseACocher -> setValue($unJournal['idJournalDeBord']);
    		$caseACocher -> setDecorators($decorateurCase);    		
    		$formulaireAfficherVol -> addElement($caseACocher);

    		$idJournal[$unJournal['idJournalDeBord']] = $unJournal['idJournalDeBord'];
    		$numVol[$unJournal['idJournalDeBord']] = $unJournal['numVol'];
    		
    		$aeroportDepart = $unJournal['aeroportDepart'];
    		$aeroportArrivee = $unJournal['aeroportArrivee'];
    		$unAeroportD = $aeroport->find($aeroportDepart)->current();
    		$unAeroportA = $aeroport->find($aeroportArrivee)->current();
    			
    		$depart[$unJournal['idJournalDeBord']] = $unAeroportD['nomAeroport'];
    		$arrivee[$unJournal['idJournalDeBord']] = $unAeroportA['nomAeroport'];
    	} 
    	
    	//on crée le bouton submit
    	$valider = new Zend_Form_Element_Submit('valider');
    	$valider->setAttrib('id', 'forms');
    	$valider -> setDecorators($decorateurBoutonValider);
    	$formulaireAfficherVol -> addElement($valider);    	 	
    		 
    	//on envoie les vols a la vue
    	$this->view->lesJournaux = $lesJournaux;     	
    	$this->view->paginator = $paginator;
    	$this->view->formulaire = $formulaireAfficherVol; 
    	if(isset($idJournal))
    	$this->view->idJournal = $idJournal;
    	if(isset($depart))
    	$this->view->numVol = $numVol;
    	  
    	if(isset($depart))
    		$this->view->depart = $depart;
    	if(isset($arrivee))
    		$this->view->arrivee = $arrivee;
  
	}
	
	//***** fonction ajouter*****
	public function ajoutcommentaireAction()
	{
		$formAjoutCommentaire = new Fajoutcommentairelogistique;
		$commentaire = new CommentaireVol;
		
		$id = $this->_getParam('idJournalDeBord');
		$formAjoutCommentaire->journaldebord->setValue($id);
		
		
		if(isset($_POST['Envoyer']))
		{			
		
			$comvol = $commentaire->createRow();
			$comvol->idCommentaireVol = '';
			$comvol->idJournalDeBord = $_POST['journaldebord'];
			$comvol->commentaire = $_POST['NewCom'];
			$comvol->titre = $_POST['NewTitre'];			
			if(!empty($comvol->commentaire))
			{
				$comvol->save();
				$this->_redirect('/logistique/index?valeur=afficher');
				
			}
			else
			{
				echo"Erreur d'ajout";
			}
		}
		else 
		{
			$this->view->formAjoutCommentaire = $formAjoutCommentaire;
		}	
		
	}	

}