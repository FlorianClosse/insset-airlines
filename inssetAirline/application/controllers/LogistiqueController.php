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
		
		if(isset($valeur))
		{
			switch ($valeur)
			{				 
				case "ajout":
					$this->_helper->actionStack('ajoutcommentaire', 'logistique', 'default', array());
				break;
				case "afficher":
					$this->_helper->actionStack('affichercommentaire', 'logistique', 'default', array());
				break;				
			}
		}		
		
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
		$journal = new JournalDeBord;
		$lesJournaux = $journal->getVolEnCour();
		
		
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

    	//on crée le formulaire
    	$formulaireAfficherVol = new Zend_Form();
    	$formulaireAfficherVol -> setMethod('post');
    	$formulaireAfficherVol -> setAction('/logistique/index/');
    	$formulaireAfficherVol -> setAttrib('id','formulaireAfficherVol');
    	$formulaireAfficherVol -> addDecorators($decorateurTableau);
    		 
    	foreach($lesJournaux as $unJournal)
    	{    			
    		$caseACocher = new Zend_Form_Element_Checkbox($unJournal['idJournalDeBord']);
    		$caseACocher -> setValue($unJournal['idJournalDeBord']);
    		$caseACocher -> setDecorators($decorateurCase);    		
    		$formulaireAfficherVol -> addElement($caseACocher);      		
    	} 
    		
    	//on crée le bouton submit
    	$valider = new Zend_Form_Element_Submit('valider');
    	$valider -> setDecorators($decorateurBoutonValider);
    	$formulaireAfficherVol -> addElement($valider);
    	
    	$lesNumVol = $journal->getNumeroVol();
    	
    	$compteur = 0;
    	foreach ($lesNumVol as $unNumVol )
    	{
    		$compteur = $compteur + 1;
    		$listeNumVol[$compteur][0] = $unNumVol['numVol'].'<br>'; 
    		$this->view->listeNumVol = $listeNumVol; 
    		
    	}   	
    		 
    	//on envoie les vols a la vue
    	$this->view->lesJournaux = $lesJournaux;
    	$this->view->formulaire = $formulaireAfficherVol;    	
  
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