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
    			$liaisonVolJour = new LiaisonVolJour();
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
    	$resultat =  $this->_getParam('filtreStategique');
    	if(isset($resultat))
    	{
    		$_SESSION['filtreStategique'] = $resultat;
    	}
    	else
    	{
    		if(isset($_SESSION['filtreStategique']))
    		{
    			$resultat = $_SESSION['filtreStategique'];
    		}
    		else 
    		{
    			$resultat = "defaut";
    		}
    	}
    	
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
    	
    	
    	$vol = new Vol;
    	$lesVols = $vol->fetchAll();
    	
    	if(!isset($_SESSION['donneesFiltreStrategique']))
    	{
    		$_SESSION['donneesFiltreStrategique']= 0;
    	}
    	
    	switch ($resultat)
    	{
    		case "defaut":
    			$_SESSION['donneesFiltreStrategique']= 0;
    			unset($_SESSION['aeroportDepartFiltreStrategique']);
    			unset($_SESSION['aeroportArriveeFiltreStrategique']);
    			break;
    			
    		case "aeroportDepart":
    			if ($_SESSION['donneesFiltreStrategique'] < 1)
    			{
    				$_SESSION['donneesFiltreStrategique'] = $_SESSION['donneesFiltreStrategique'] +1;
    			}
    			if ($_SESSION['donneesFiltreStrategique'] = 1)
    			{
    				if (isset($_SESSION['aeroportArriveeFiltreStrategique']))
    				{
    					$_SESSION['donneesFiltreStrategique'] = $_SESSION['donneesFiltreStrategique'] +1;
    				}
    			}
    			if(isset($_POST['aeroportDepart']))
    			{
    				$_SESSION['aeroportDepartFiltreStrategique'] = $_POST['aeroportDepart'];
    			}
    			break;
    			
    		case "aeroportArrivee":
    			if ($_SESSION['donneesFiltreStrategique'] < 1)
    			{
    				$_SESSION['donneesFiltreStrategique'] = $_SESSION['donneesFiltreStrategique'] +1;
    			}
    			if ($_SESSION['donneesFiltreStrategique'] = 1)
    			{
	    			if (isset($_SESSION['aeroportDepartFiltreStrategique']))
	    			{
	    				$_SESSION['donneesFiltreStrategique'] = $_SESSION['donneesFiltreStrategique'] +1;
	    			}
    			}
    			if(isset($_POST['aeroportArrivee']))
    			{
    				$_SESSION['aeroportArriveeFiltreStrategique'] = $_POST['aeroportArrivee'];
    			}
    			break;
    	}
    	//on récupère tous les vols contenus dans la table vol dans
    	//la variable $lesVols
    	
    	
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
    		$ligne1 = $vol->getRecuperAeroportDepart($unVol->aeroportDepart);
    		$ligne2 = $vol->getRecuperAeroportDArrivee($unVol->aeroportArrivee);
    		$ligne3 = $vol->getRecuperDateDeVol($unVol->idVol);
    		$ligne4 = fonctionConvertirHeure($unVol->dureeVol);
    			
    		
    		if ($_SESSION['donneesFiltreStrategique'] == 0)
    		{
    			//on crée les cases a cocher
    			$caseACocher = new Zend_Form_Element_Checkbox($unVol -> idVol);
    			$caseACocher -> setValue($unVol -> idVol);
    			$caseACocher -> setDecorators($decorateurCase);
    			$formulaireSuppression -> addElement($caseACocher);
    			
    			//on récupère dans des tableaux pour chaque vol:
    			//l'aéroport de départ
    			$nomAeroportDepart[$unVol->idVol] = $ligne1['nomAeroport'];
    			//l'aéroport de d'arrivé
    			$nomAeroportArrivee[$unVol->idVol] = $ligne2['nomAeroport'];
    			//la date du vol ou les jours de la semaine
    			$jourOuDateDuVol[$unVol->idVol] = $ligne3;
    			//la durée du vol en heures
    			$duree[$unVol->idVol] = $ligne4;
    			
    			$numVol[$unVol->idVol] = $unVol->numVol;
    			$idVol[$unVol->idVol] = $unVol->idVol;   		
    		}
    		if ($_SESSION['donneesFiltreStrategique'] == 1)
    		{
    			if(isset($_SESSION['aeroportDepartFiltreStrategique']))
    			{
    				if($_SESSION['aeroportDepartFiltreStrategique'] == $ligne1['idAeroport'])
    				{
    					//on crée les cases a cocher
    					$caseACocher = new Zend_Form_Element_Checkbox($unVol -> idVol);
    					$caseACocher -> setValue($unVol -> idVol);
    					$caseACocher -> setDecorators($decorateurCase);
    					$formulaireSuppression -> addElement($caseACocher);
    					
    					//on récupère dans des tableaux pour chaque vol:
    					//l'aéroport de départ
    					$nomAeroportDepart[$unVol->idVol] = $ligne1['nomAeroport'];
    					//l'aéroport de d'arrivé
    					$nomAeroportArrivee[$unVol->idVol] = $ligne2['nomAeroport'];
    					//la date du vol ou les jours de la semaine
    					$jourOuDateDuVol[$unVol->idVol] = $ligne3;
    					//la durée du vol en heures
    					$duree[$unVol->idVol] = $ligne4;
    					$numVol[$unVol->idVol] = $unVol->numVol;
    					$idVol[$unVol->idVol] = $unVol->idVol;
    				}
    			}
    			if(isset($_SESSION['aeroportArriveeFiltreStrategique']))
    			{
    				if($_SESSION['aeroportArriveeFiltreStrategique'] == $ligne2['idAeroport'])
    				{
    					//on crée les cases a cocher
    					$caseACocher = new Zend_Form_Element_Checkbox($unVol -> idVol);
    					$caseACocher -> setValue($unVol -> idVol);
    					$caseACocher -> setDecorators($decorateurCase);
    					$formulaireSuppression -> addElement($caseACocher);
    					
    					//on récupère dans des tableaux pour chaque vol:
    					//l'aéroport de départ
    					$nomAeroportDepart[$unVol->idVol] = $ligne1['nomAeroport'];
    					//l'aéroport de d'arrivé
    					$nomAeroportArrivee[$unVol->idVol] = $ligne2['nomAeroport'];
    					//la date du vol ou les jours de la semaine
    					$jourOuDateDuVol[$unVol->idVol] = $ligne3;
    					//la durée du vol en heures
    					$duree[$unVol->idVol] = $ligne4;
    					$numVol[$unVol->idVol] = $unVol->numVol;
    					$idVol[$unVol->idVol] = $unVol->idVol;
    				}	
    			}
    		}
    		if ($_SESSION['donneesFiltreStrategique'] == 2)
    		{
    			if($_SESSION['aeroportDepartFiltreStrategique'] == $ligne1['idAeroport'])
    			{
    				if($_SESSION['aeroportArriveeFiltreStrategique'] == $ligne2['idAeroport'])
    				{
    					//on crée les cases a cocher
    					$caseACocher = new Zend_Form_Element_Checkbox($unVol -> idVol);
    					$caseACocher -> setValue($unVol -> idVol);
    					$caseACocher -> setDecorators($decorateurCase);
    					$formulaireSuppression -> addElement($caseACocher);
    					
    					//on récupère dans des tableaux pour chaque vol:
    					//l'aéroport de départ
    					$nomAeroportDepart[$unVol->idVol] = $ligne1['nomAeroport'];
    					//l'aéroport de d'arrivé
    					$nomAeroportArrivee[$unVol->idVol] = $ligne2['nomAeroport'];
    					//la date du vol ou les jours de la semaine
    					$jourOuDateDuVol[$unVol->idVol] = $ligne3;
    					//la durée du vol en heures
    					$duree[$unVol->idVol] = $ligne4;
    					$numVol[$unVol->idVol] = $unVol->numVol;
    					$idVol[$unVol->idVol] = $unVol->idVol;
    				}
    			}
    		}	
    	}
    	//on crée le bouton submit
    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitSupprimerVol');
    	$envoyer -> setLabel('Supprimer');
    	$envoyer -> setDecorators($decorateurBoutonEnvoyer);
    	$formulaireSuppression -> addElement($envoyer);
    	
    	
    	
    	
    	
    	
    	//on crée le formulaire filtre
    	$formFiltAeroDepart = new Zend_Form;
    	$formFiltAeroDepart -> setAttrib('id','formFiltAeroDepart');
    	$formFiltAeroDepart -> setMethod('post');
    	$formFiltAeroDepart -> setAction('/strategique/index?valeur=fermer&filtreStategique=aeroportDepart');
    	 
    	//choix de l'aéroport de départ
    	$aeroportDepart = new Zend_Form_Element_Text('aeroportDepart');
    	$aeroportDepart -> setLabel('Aéroport de départ');
    	$aeroportDepart -> setValue(fonctionFormulaireChoixAeroport());
    	$formFiltAeroDepart -> addElement($aeroportDepart);
    	
    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitFiltAeroDepart');
    	$envoyer -> setLabel('Filtrer');
    	$formFiltAeroDepart -> addElement($envoyer);
    	
    	
    	$formFiltAeroArrivee = new Zend_Form;
    	$formFiltAeroArrivee -> setAttrib('id','formFiltAeroArrivee');
    	$formFiltAeroArrivee -> setMethod('post');
    	$formFiltAeroArrivee -> setAction('/strategique/index?valeur=fermer&filtreStategique=aeroportArrivee');
    	
    	//choix de l'aéroport de départ
    	$aeroportArrivee = new Zend_Form_Element_Text('aeroportArrivee');
    	$aeroportArrivee -> setLabel('Aéroport d\'arrivée');
    	$aeroportArrivee -> setValue(fonctionFormulaireChoixAeroport());
    	$formFiltAeroArrivee -> addElement($aeroportArrivee);
    	 
    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitFiltAeroArrivee');
    	$envoyer -> setLabel('Filtrer');
    	$formFiltAeroArrivee -> addElement($envoyer);
    	 
    	
    	$this->view->formFiltAeroArrivee = $formFiltAeroArrivee;
    	//on envoie le formulaire a la vue
    	$this->view->formFiltAeroDepart = $formFiltAeroDepart;
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
    	
    	$this->view->idVol = $idVol;
    	$this->view->numVol = $numVol;
    	//on envoie le formulaire a la vue
    	$this->view->formulaire = $formulaireSuppression;
    
    }

}