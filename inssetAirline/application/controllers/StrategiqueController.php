<?php
//Par nicolas
class StrategiqueController extends Zend_Controller_Action
{
	public function indexAction()
    {
    	$valeur = $this->_getParam('valeur');
    	if(isset($valeur))
    	{
     		switch ($valeur)
    		{
    			case "creer": 
    				$this->_helper->actionStack('creerligne', 'strategique', 'default', array());
    			break;
    			
    			case "fermer":
    				$this->_helper->actionStack('fermerligne', 'strategique', 'default', array());
    			break;
    		}	
    	}
    	
    	if(isset($_POST['boutonSubmitSupprimerVol']))
    	{
    		//supprimer un vol
	    	$vol = new Vol;
	    	$lesVols = $vol->fetchAll();
	    	
	    	foreach($lesVols as $unVol)
	    	{
	    		if(isset($_POST[$unVol->idVol]))
	    		{
	    			if($_POST[$unVol->idVol] == 1)
	    			{
	    				$vol->find($unVol->idVol)->current()->delete();
	    				$tableau[] = $unVol->numVol;
	    			}
	    		}
	    	}
	    	
	    	if(isset($tableau))
	    	{
	    		$this->view->tableau = $tableau;
	    	}
    	}
    	
    	if(isset($_POST['boutonSubmitAjouterVol']))
    	{
    		//ajouter un vol
    		$vol = new Vol;
    		$volAAjouter = $vol->createRow();
    		$volAAjouter->numVol = $_POST['numeroVol'];
    		$volAAjouter->aeroportDepart = $_POST['aeroportDepart'];
    		$volAAjouter->aeroportArrivee = $_POST['aeroportArrivee'];
    		$volAAjouter->dureeVol = fonctionConvertirMinute($_POST['dureeVol']);
    		if( $_POST['choixDuVol'] == 1)
    		{
    			$volAAjouter->datePrevu = $_POST['volALaCarte'];
    		}
    		$volAAjouter->save();
    		
    		if( $_POST['choixDuVol'] == 2)
    		{
    			$liaisonVolJour = new Liaisonvoljour;
    			foreach($_POST['ChoixDesJours'] as $unJour)
				{
					$liaisonAAjouter = $liaisonVolJour->createRow();
					$liaisonAAjouter->idVol = $volAAjouter->idVol;
					$liaisonAAjouter->idJour = $unJour+1;
					$liaisonAAjouter->save();
				}
    		}
    		
    	}
    	
    }
    
    public function creerligneAction()
    {
    	//on crée le formulaire
    	$formulaireAjout = new Zend_Form;
    	$formulaireAjout -> setAttrib('id','formulaireAjout');
    	$formulaireAjout -> setMethod('post');
    	$formulaireAjout -> setAction('/strategique/index/');
    	
    	//choix de l'aéroport de départ
    	$numeroVol = new Zend_Form_Element_Text('numeroVol');
    	$numeroVol -> setLabel('Numéro de vol');
    	$formulaireAjout -> addElement($numeroVol);
    	
    	//choix de l'aéroport de départ
    	$aeroportDepart = new Zend_Form_Element_Text('aeroportDepart');
    	$aeroportDepart -> setLabel('Aéroport de départ');
    	$aeroportDepart -> setValue(fonctionFormulaireChoixAeroport());
    	$formulaireAjout -> addElement($aeroportDepart);
    	
    	//choix de l'aéroport d'arrivée
    	$aeroportArrivee = new Zend_Form_Element_Text('aeroportArrivee');
    	$aeroportArrivee -> setLabel('Aéroport d\'arrivée');
    	$aeroportArrivee -> setValue(fonctionFormulaireChoixAeroport());
    	$formulaireAjout -> addElement($aeroportArrivee);
    	
    	//zone de saisie de la durée du vol
    	$dureeVol = new Zend_Form_Element_Text('dureeVol');
    	$dureeVol -> setLabel('Durée du vol ( ex: 4H24 )');
    	$dureeVol -> setValue(0);
    	$formulaireAjout -> addElement($dureeVol);
    	
    	//choix du type de vol
    	$choixVol = new Zend_Form_Element_Select('choixDuVol', 
    		array('multiOptions' => array(
		        0 => '',
		        1 => 'Vol à la carte',
		        2 => 'Vol periodique',
			)));
    	$choixVol -> setLabel('Choix du vol');
    	$formulaireAjout -> addElement($choixVol);
    	
    	//zone de saisie de la date
    	$volALaCarte = new Zend_Form_Element_Text('volALaCarte');
    	$volALaCarte -> setLabel('Choisir la date de vol');
    	$formulaireAjout -> addElement($volALaCarte);
    	
    	//case a cocher des jours de la semaine
    	$jour = new Jour;
    	$lesJours = $jour->fetchAll();
    	foreach($lesJours as $unjour)
    	{
    		$multiOptions[] = $unjour['libelleJour'];
    	}
    	$choixJours = new Zend_Form_Element_MultiCheckbox(
    			'ChoixDesJours', array('multiOptions' => $multiOptions));
    	$choixJours -> setLabel('Choix des jours de vol');
    	$formulaireAjout -> addElement($choixJours);
    	 
    	//bouton d'envoie du formulaire
    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitAjouterVol');
    	$envoyer -> setLabel('Ajouter');
    	$formulaireAjout -> addElement($envoyer);
    	
    	//on envoie le formulaire a la vue
    	$this->view->formulaire = $formulaireAjout;
    }
    
    public function fermerligneAction()
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
    	$decorateurBoutonEnvoyer = array(
    			array('ViewHelper'),
    			array('Errors'),
    			array('HtmlTag', array('tag'=>'td', 'class'=>'boutonEnvoyer')),
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
    	 
    	//on récupère tous les vols contenus dans la table vol dans
    	//la variable $lesVols
    	$vol = new Vol;
    	$lesVols = $vol->fetchAll();
    	
    	//on crée le paginator
    	$pagination = Zend_Paginator::factory($lesVols);
    	$pagination->setCurrentPageNumber($this->_getParam('page'));
    	$pagination->setItemCountPerPage(3);
    	
    	//on crée le formulaire
    	$formulaireSuppression = new Zend_Form;
    	$formulaireSuppression -> setMethod('post');
    	$formulaireSuppression -> setAction('/strategique/index/');
    	$formulaireSuppression -> setAttrib('id','formulaireSuppression');
    	$formulaireSuppression -> addDecorators($decorateurTableau);

    	foreach($pagination as $unVol)
    	{
    		//on crée les cases a cocher
    		$caseACocher = new Zend_Form_Element_Checkbox($unVol -> idVol);
    		$caseACocher -> setValue($unVol -> idVol);
    		$caseACocher -> setDecorators($decorateurCase);
    		$formulaireSuppression -> addElement($caseACocher);
    		
    		//on récupère dans des tableaux pour chaque vol:
    		//l'aéroport de départ
    		$ligne = $vol->getRecuperAeroportDepart($unVol->aeroportDepart);
    		$nomAeroportDepart[$unVol->idVol] = $ligne['nomAeroport'];
    		//l'aéroport de d'arrivé
    		$ligne = $vol->getRecuperAeroportDArrivee($unVol->aeroportArrivee);
    		$nomAeroportArrivee[$unVol->idVol] = $ligne['nomAeroport'];
    		//la date du vol ou les jours de la semaine
    		$ligne = $vol->getRecuperDateDeVol($unVol->idVol);
    		$jourOuDateDuVol[$unVol->idVol] = $ligne;
    		//la durée du vol en heures
    		$ligne = fonctionConvertirHeure($unVol->dureeVol);
    		$duree[$unVol->idVol] = $ligne;
    	}
    	 
    	//on crée le bouton submit
    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitSupprimerVol');
    	$envoyer -> setLabel('Supprimer');
    	$envoyer -> setDecorators($decorateurBoutonEnvoyer);
    	$formulaireSuppression -> addElement($envoyer);
    	 
    	//on envoie les vols a la vue
    	$this->view->lesVols = $pagination;
    	//on envoie les noms d'aeroport de depart
    	$this->view->lesAeroportsDeDepart = $nomAeroportDepart;
    	//on envoie les noms d'aeroport d'arrivee
    	$this->view->lesAeroportsDArrivee = $nomAeroportArrivee;
    	//on envoie les dates de départs ou les jours prévu
    	$this->view->lesJourEtDateDeVol = $jourOuDateDuVol;
    	//on envoie la durée des vols
    	$this->view->duree = $duree;
    	//on envoie le formulaire a la vue
    	$this->view->formulaire = $formulaireSuppression;
    
    }

}