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
		$commentaire = new CommentaireVol();
		$lesCommentaires = $commentaire->fetchAll();
		
		$vol = new Vol;
		$lesVols = $vol->fetchAll();
		
		if(isset($_POST['valider']))
		{
			foreach($lesVols as $unVol)
			{
				if(isset($_POST[$unVol->idVol]))
				{
					if($_POST[$unVol->idVol] == 1)
					{
						$idVolSelectionne= $unVol->idVol;
									    
						foreach ($lesCommentaires as $unCommentaire)
						{		
							if($idVolSelectionne == $unCommentaire->idVol)
							{
								$compteur=$compteur+1;
								$tableauCom[$compteur][0] = $unCommentaire->idCommentaireVol;
								$tableauCom[$compteur][1] = $unCommentaire->idJournalDeBord;
								$tableauCom[$compteur][2] = $unCommentaire->titre;
								$tableauCom[$compteur][3] = $unCommentaire->commentaire;
								$tableauCom[$compteur][4] = $unCommentaire->idVol;							
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
							$commentaire = new CommentaireVol();
								
							$comvol = $commentaire->createRow();
							$comvol->idCommentaireVol = '';
							$comvol->idJournalDeBord = $_POST['journaldebord'];
							$comvol->commentaire = $_POST['NewCom'];
							$comvol->titre = $_POST['NewTitre'];
							$comvol->idVol = $_POST['vol'];
						
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
		$vol = new Vol;
		$lesVols = $vol->fetchAll();
		    	
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
    		
    	foreach ($lesVols as $unVol)
    	{
    		$tableau[] = $unVol->numVol;
    	}    		
    	
    	$this->view->tableau = $tableau;    		

    	//on crée le formulaire
    	$formulaireAfficherVol = new Zend_Form;
    	$formulaireAfficherVol -> setMethod('post');
    	$formulaireAfficherVol -> setAction('/logistique/index/');
    	$formulaireAfficherVol -> setAttrib('id','formulaireAfficherVol');
    	$formulaireAfficherVol -> addDecorators($decorateurTableau);
    		 
    	foreach($lesVols as $unVol)
    	{    			
    		$caseACocher = new Zend_Form_Element_Checkbox($unVol -> idVol);
    		$caseACocher -> setValue($unVol -> idVol);
    		$caseACocher -> setDecorators($decorateurCase);
    		$formulaireAfficherVol -> addElement($caseACocher);    			
    	}    		
    	//on crée le bouton submit
    	$valider = new Zend_Form_Element_Submit('valider');
    	$valider -> setDecorators($decorateurBoutonValider);
    	$formulaireAfficherVol -> addElement($valider);
    		 
    	//on envoie les vols a la vue
    	$this->view->lesVols = $lesVols;
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
			
			$vol = new vol;
			$lesVols = $vol->fetchAll();
			$vol = new Zend_Form_Element_Select('vol');
			$vol ->setLabel('Choisir un numero vol');
			foreach ($lesVols as $unVol )
			{
				$tableauVols[$unVol -> idVol] = ucfirst($unVol->numVol);
			}		
 			$vol->setMultiOptions($tableauVols);
			
 			$journalDeBord = new JournalDeBord();
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
			$FormAjoutCommentaire->addElement($vol);
 			$FormAjoutCommentaire->addElement($journalDeBord);
			$FormAjoutCommentaire->addElement($NewCommentaire);
			$FormAjoutCommentaire->addElement($boutonSubmit);
			$FormAjoutCommentaire->addElement($boutonReset);
			
			//affiche le formulaire
			echo $FormAjoutCommentaire;
		
	}	
}