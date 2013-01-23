<?php

class LogistiqueController extends Zend_Controller_Action
{
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
		if(isset($_POST['EnvoyerCommentaire']))
		{
							$commentaire = new CommentaireVol;
								
							$comvol = $commentaire->createRow();
							$comvol->idCommentaireVol = '';
							$comvol->idJournalDeBord = $_POST['journaldebord'];
							$comvol->commentaire = $_POST['NewCom'];
							$comvol->titre = $_POST['NewTitre'];							
						
							if(!empty($comvol->commentaire))
							{
								$comvol->save();
								echo "Commentaire ajouté";
							}
							else
							{
								echo"Erreur d'ajout";
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
			// Créer un objet formulaire 
			$FormAjoutCommentaire = new Zend_Form();
			 
			// Parametrer le formulaire 
			$FormAjoutCommentaire->setMethod('post')->setAction('/logistique/index');
			$FormAjoutCommentaire->setAttrib('id', 'FormAjoutCommentaire');
			
			// Creer de l'elements de formulaire 
			$NewCommentaire= new Zend_Form_Element_Textarea('NewCom');
			$NewCommentaire ->setLabel('Taper votre commentaire');
			$NewCommentaire->setAttrib('id', 'formcommentaire');
			$NewCommentaire ->setRequired(TRUE);
			
			$NewTitre= new Zend_Form_Element_Text('NewTitre');
			$NewTitre ->setLabel('Taper votre titre');
			$NewTitre->setAttrib('id', 'formcommentaire');
			$NewTitre ->setRequired(TRUE);			
						
 			$journalDeBord = new JournalDeBord;
 			$lesjournaldebord = $journalDeBord->fetchAll();
			$journalDeBord = new Zend_Form_Element_Select('journaldebord');
			$journalDeBord ->setLabel('Choisir un id journal de bord');
			foreach ($lesjournaldebord as $unjournaldebord )
			{
				$tableaujournaldebord[$unjournaldebord -> idJournalDeBord] = $unjournaldebord -> idJournalDeBord ;
			}
				
			$journalDeBord->setMultiOptions($tableaujournaldebord);
			
			
			$boutonSubmit = new Zend_Form_Element_Submit('EnvoyerCommentaire');
			$boutonReset = new Zend_Form_Element_Reset('Reset');
			
			$FormAjoutCommentaire->addElement($NewTitre);			
 			$FormAjoutCommentaire->addElement($journalDeBord);
			$FormAjoutCommentaire->addElement($NewCommentaire);
			$FormAjoutCommentaire->addElement($boutonSubmit);
			$FormAjoutCommentaire->addElement($boutonReset);
			
			//affiche le formulaire
			echo $FormAjoutCommentaire;
		
	}	
}