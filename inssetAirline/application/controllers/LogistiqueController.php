<?php

class LogistiqueController extends Zend_Controller_Action
{
	public function indexAction()
	{		
		$compteur = 0;
		
		$commentaire = new Commentairevol;
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
    	else
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
	}
}