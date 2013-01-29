<?php 

class PlanningController extends Zend_Controller_Action
{
	public function indexAction()
    {
    	$valeur = $this->_getParam('valeur');
    	if(isset($valeur))
    	{
    		switch ($valeur)
    		{
    			case "creer":
    				$this->_helper->actionStack('creerplanning', 'planning', 'default', array());
    				break;
    				 
    			case "fermer":
    				$this->_helper->actionStack('modifierplanning', 'planning', 'default', array());
    				break;
    		}
    	}
    	
    }
    public function creerplanningAction()
    {
    	$maintenance = $this->_getParam('maintenance');
    	if(isset($maintenance))
    	{
    		$date = $this->_getParam('date');
    		$depart = $this->_getParam('depart');
    		$arrivee = $this->_getParam('arrivee');
    		$lavion = $this->_getParam('avion');
    		$nom = 'indefini';
    		
    		$vol = new Vol();
    		$monVol = $vol->getRecuperUnVolAvecDateDepartArriveeEtNom($date, $depart, $arrivee, $nom);
    		 	 	 	 	 	 	
    		$Redirect= $this->_helper->getHelper('Redirector');
    		$Redirect->gotoURL('planning/volacreer?numerovol='.$monVol['idVol'].'&date='.$date.'&piloteChoisi=oui&avion='.$lavion);
    	}
    	else
    	{
	    	$levol = $this->_getParam('vol');
	    	if(isset($levol))
	    	{
	    		if($levol == 'creer')
	    		{
	    			$message = "Le vol à été enregistré.";
	    		}
	    		$this->view->message = $message;
	    	}
	    	if ($this->_getParam('retour') == 'oui')
	    	{
	    		unset($_SESSION['aeroportCreerPlanning']);
	    	}
	    	
	    	
	    	
	    	if(isset($_POST['boutonSubmitChoixAeroport']))
	    	{
	    		$_SESSION['aeroportCreerPlanning'] = $_POST['aeroport'];
	    	}
	    	
	    	if(!isset($_SESSION['aeroportCreerPlanning']))
	    	{
		    	$formulaireChoix = new Zend_Form;
		    	$formulaireChoix -> setAttrib('id','formulaireChoixAeroport');
		    	$formulaireChoix -> setMethod('post');
		    	$formulaireChoix -> setAction('/planning/creerplanning');
		    	
		    	$formulaireChoix->addElement(fonctionAeroport('aeroport'));
		    	
		    	$envoyer = new Zend_Form_Element_Submit('boutonSubmitChoixAeroport');
		    	$envoyer -> setLabel('Ajouter');
		    	$formulaireChoix -> addElement($envoyer);
		    	
		    	$this->view->formulaire = $formulaireChoix;
		    }
	    	else
	    	{
		    	$aeroport = $_SESSION['aeroportCreerPlanning'];
		    	$vol = new Vol();
		    	$journalDeBord = new JournalDeBord();
		    	$liaisonVolJour = new LiaisonVolJour();
		    	$aerop = new Aeroport();
		    	$avion = new Avion();
		    	$revision = new Revision();
		    	
		    	
		    	$recupDate = $this->_getParam('date');
		    	
		    	if(!isset($recupDate))
		    	{
			    	
			    	$lesannees=array();
					$lesmois=array(); 
					$jours=array(); 
					
					$dans4Semaines = time() + (4 * 7 * 24 * 60 * 60);
					
					for($i=0; $i < 28; $i++)
					{
						$leJour = $dans4Semaines + $i * 24 * 60 * 60;
						$annee = date('Y', $leJour);
						$mois = date('m', $leJour);
						$jour = date('j', $leJour);
						
						$jours[$jour] = $jour;
						$lesmois[$mois] = $jours;
						$lesannees[$annee] = $lesmois;
					}
					
					foreach($lesannees as $a=>$lesmoisa) 
					{
						if(isset($sortir))
							if($sortir == true)
								break;
						foreach($lesmoisa as $m=>$reunions) 
						{
							if(isset($sortir))
								if($sortir == true)
									break;
							$links=array();
							$links[0] = Lien(0, $m, $a, '');
							foreach($reunions as $j=>$lieu)
							{
								$aujourdhui = $a.'-'.$m.'-'.$j;
								$timestamp = mktime(1, 1, 1, $m, $j, $a);
								$jour = date('N', $timestamp);
								$lesVols = $vol->getRecuperLesVolsAujourdHui($aujourdhui, $aeroport);
								if(empty($lesVols))
								{
									$lesVols = $liaisonVolJour->getRecupererVolSuivantJour($jour);
									if(empty($lesVols))
									{
										$links[$j] = Lien2($j);
									}
									else
									{
										foreach($lesVols as $leVol)
										{
											$unVol = $vol->find($leVol['idVol'])->current();
											if($unVol['aeroportDepart'] == $aeroport)
											{
												$journal = $journalDeBord->getRecupererSuivantDateEtVol($aujourdhui, $unVol['idVol']);
												if(!isset($journal['idJournalDeBord']))
												{
													$premiereSortie = true;
													break;
												}
												$premiereSortie = false;
											}
											$premiereSortie = false;
										}
										if($premiereSortie == true)
						    			{
					    					$links[$j] = Lien($j, $m, $a,$lieu);
					    					$sortir = true;
											break;
						    			}
						    			else
						    			{
						    				$links[$j] = Lien2($j);
						    			}
									}
								}
								else
								{
									foreach($lesVols as $unVol)
									{
										$journal = $journalDeBord->getRecupererSuivantDateEtVol($aujourdhui, $unVol['idVol']);
										if(!isset($journal['idJournalDeBord']))
										{
											$premiereSortie = true;
											break;
										}
										$premiereSortie = false;
									}
									if($premiereSortie == true)
									{
										$links[$j] = Lien($j, $m, $a,$lieu);
										$sortir = true;
										break;
									}
									else
									{
										$links[$j] = Lien2($j);
									}
								}
							}
							Calendrier($m,$a,$links);
						}
					}
		    	}
				else
				{
					$aujourdhui = date('Y-m-j', $recupDate);
		    		$jour = date('N', $recupDate);
					
		    		$dateEnLettre = convertirDateEnLettre($aujourdhui);
		    		$this->view->aujourdhui = $dateEnLettre;
		    		$this->view->jour = $jour;
		    		$aa = $aerop->find($aeroport)->current();
		    		$aaa = $aa->nomAeroport;
		    		$this->view->aeroport = $aaa;
		    		
		    		
		    		
		    		$lesAvions = $avion->fetchAll();
		    		
		    		foreach($lesAvions as $unAvion)
		    		{
		    			$jdb = $journalDeBord->getRecupererLieuAvion($unAvion->idAvion);
		    			$aeroDepart = $vol->find($jdb['idVol'])->current();
		    			$aeroDepart = $aeroDepart['aeroportArrivee'];
		    			if($aeroport == $aeroDepart)
		    			{
		    				$tabAvions[] = $jdb['idAvion'];
		    			}
		    		}
		    		$info = false;
		    		if(isset($tabAvions))
		    		{
		    			$recupDateDemain = $recupDate + 60 * 60 * 24;
		    			$demain = date('Y-m-j', $recupDateDemain);
		    			foreach($tabAvions as $unTabAvion)
		    			{
		    				$info = $revision->getRecuperRevisionDUnAvionAUneDateDonnee($unTabAvion,$demain);
		    				if($info)
		    				{
		    					$infoAvion = $avion->find($unTabAvion)->current();
			    				$aeroportAttache = $infoAvion->idAeroportDattache;
			    				$immatricule = $infoAvion->numImmatriculation;
			    				if($aeroportAttache != $aeroport)
			    				{
			    					if($vol->getRecuperUnVolAvecDateDepartArriveeEtNom($aujourdhui, $aeroport, $aeroportAttache,'indefini'))
			    					{
			    						$info = false;
			    					}
			    					else
			    					{
				    					$maligne = $vol->createRow();
				    					$maligne -> numVol = 'indefini'; 	
				    					$maligne -> aeroportDepart = $aeroport;
				    					$maligne -> aeroportArrivee = $aeroportAttache;	
				    					$maligne -> datePrevu = $aujourdhui;
				    					$maligne -> dureeVol = 150;
				    					$maligne -> save();
				    					
				    					$Redirect= $this->_helper->getHelper('Redirector');
				    					$Redirect->gotoURL('planning/creerplanning?maintenance=oui&date='.$aujourdhui.'&depart='.$aeroport.'&arrivee='.$aeroportAttache.'&avion='.$unTabAvion);
				    					
			    					}
			    					
		    					}
		    				}
		    			}
		    		}
		    		
		    		if(!$info)
		    		{
		    		
			    		$lesVols = $vol->getRecuperLesVolsAujourdHui($aujourdhui, $aeroport);
			    		if(!empty($lesVols))
			    		{
			    			foreach($lesVols as $unVol)
				    		{
				    			
				    			$journal = $journalDeBord->getRecupererSuivantDateEtVol($aujourdhui, $unVol['idVol']);
				    			$numVols[$unVol['idVol']] = $unVol['numVol'];
				    			
				    			$aeroArriveeVols[$unVol['idVol']] = $aerop->find($unVol['aeroportArrivee'])->current()->nomAeroport;
				    			$aeroDepartVols[$unVol['idVol']] = $aerop->find($unVol['aeroportDepart'])->current()->nomAeroport;
				    			$idVols[$unVol['idVol']] = $unVol['idVol'];
				    			if(isset($journal['idJournalDeBord']))
				    			{
									$journal2[$unVol['idVol']] = 'existe';
				    			}
				    			else
				    			{
				    				$journal2[$unVol['idVol']] = 'existe pas';
				    			}
				    			
				    		}
				    		$this->view->journalsDate = $journal2;
				    		$this->view->idVolsDate = $idVols;
				    		$this->view->numVolsDate = $numVols;
				    		$this->view->aeroDepartVolsDate = $aeroDepartVols;
				    		$this->view->aeroArriveeVolsDate = $aeroArriveeVols;
				    		$this->view->lesVolsDate = $lesVols;
			    		}
			    		
			    		$lesVols = $liaisonVolJour->getRecupererVolSuivantJour($jour);
			    		if(!empty($lesVols))
			    		{
				    		foreach($lesVols as $leVol)
				    		{
				    			$idVols2[$leVol['idVol']] = $leVol['idVol'];
				    			
				    			$unVol = $vol->find($leVol['idVol'])->current();
				    			$numVols2[$leVol['idVol']] = $unVol->numVol;
				    			$aeroArriveeVols2[$leVol['idVol']] = $aerop->find($unVol['aeroportArrivee'])->current()->nomAeroport;
				    			$aeroDepartVols2[$leVol['idVol']] = $aerop->find($unVol['aeroportDepart'])->current()->nomAeroport;
				    			
				    			$aeroportDepart[$leVol['idVol']] = $unVol->aeroportDepart;
				    			if($unVol->aeroportDepart == $aeroport)
				    			{
					    			
					    			$journal = $journalDeBord->getRecupererSuivantDateEtVol($aujourdhui, $unVol->idVol);
					    			if(isset($journal['idJournalDeBord']))
					    			{
					    				$journal2[$leVol['idVol']] = 'existe';
					    			}
					    			else
					    			{
					    				$journal2[$leVol['idVol']] = 'existe pas';
					    			}
				    			}
				    		}
				    		$this->view->aeroportDepart = $aeroportDepart;
				    		$this->view->journalsJour = $journal2;
				    		$this->view->idVolsJour = $idVols2;
				    		$this->view->numVolsJour = $numVols2;
				    		$this->view->aeroDepartVolsJour = $aeroDepartVols2;
				    		$this->view->aeroArriveeVolsJour = $aeroArriveeVols2;
				    		$this->view->lesVolsJour = $lesVols;
			    		}
	 	    		}
				}	
	    	}
    	}
    }
    
    public function volacreerAction()
    {
    	$journalDeBord = new JournalDeBord();
    	$avion = new Avion();
    	$vol = new Vol();
    	$pilote = new Pilote();
    	$modele = new Modele();
    	$revision = new Revision();
    	$liaionBrevetModele = new LiaisonBrevetModele();
    	$liaisonPiloteBrevet = new LiaisonPiloteBrevet();
    	
    	$volAPlannifier = $this->_getParam('numerovol');
    	$dateDuVolAPlannifier = $this->_getParam('date');
    	 
    	if(isset($_POST['boutonAjouterJDB']))
    	{
    		$lAvion = $this->_getParam('avion');
    		$avions = $avion->find($lAvion)->current();
    		$modeles = $modele->find($avions['idModele'])->current();
    		$place = $modeles['nbPlace'];
    	
    		$maLigne = $journalDeBord->createRow();
    		$maLigne->idPilote = $_POST['ChoixDesPilotes'];
    		$maLigne->idCoPilote = $_POST['ChoixDesCoPilotes'];
    		$maLigne->idAvion = $lAvion;
    		$maLigne->idVol = $volAPlannifier;
    		$maLigne->dateDepart = $dateDuVolAPlannifier;
    		$maLigne->nbPlaceDispo = $place;
    		$maLigne->statut = 'attente';
    		$maLigne->save();
    		 
    		$Redirect= $this->_helper->getHelper('Redirector');
    		$Redirect->gotoURL('planning/creerplanning?vol=creer');
    	}
    	else 
    	{
	    	$this->view->datePrevu = $dateDuVolAPlannifier;
	    	$monAeroDepart = $vol->find($volAPlannifier)->current()->aeroportDepart;
	    	
	    	$lesAvions = $avion->fetchAll();
	    	
	    	foreach($lesAvions as $unAvion)
	    	{
		    	$jdb = $journalDeBord->getRecupererLieuAvion($unAvion->idAvion);
		    	
		    	$aeroDepart = $vol->find($jdb['idVol'])->current();
		    	$aeroDepart = $aeroDepart['aeroportArrivee'];
		    	
		    	$avions = $avion->find($jdb['idAvion'])->current();
		    	$numAvion = $avions['numImmatriculation'];
		    	
		    	$pilotes = $pilote->find($jdb['idPilote'])->current();
		    	$nomPrenomPilote = $pilotes['nomPilote'].' '.$pilotes['prenomPilote'];
		    	
		    	$copilote = $pilote->find($jdb['idCoPilote'])->current();
		    	$nomPrenomcoPilote = $copilote['nomPilote'].' '.$copilote['prenomPilote'];
		    	
		    	if($monAeroDepart == $aeroDepart)
		    	{
		    		//////datePrevue 	dateDebut 	dateFin 	idAvion 
		    		$lesRevisions = $revision->getRecupererSuivantAvion($jdb['idAvion']);
		    		$enRevision ='non';
		    		foreach($lesRevisions as $uneRevision)
		    		{
		    			$auj = mktime(0, 0, 0, date('m'), date('d'), date('Y')); 
		    			
		    			$tabDate = explode("-", $uneRevision['datePrevue']);
						$annees =  $tabDate[0]; 
						$mois =  $tabDate[1];
						$jours =  $tabDate[2];
						date_default_timezone_set("Europe/Paris" );
						$dateDebut = mktime(0, 0, 0, $mois, $jours, $annees);
						
						if($dateDebut <= $auj)
		    			{
		    				if($uneRevision['dateFin'])
		    				{
		    					$tabDate = explode("-", $uneRevision['dateFin']);
								$annees =  $tabDate[0]; 
								$mois =  $tabDate[1];
								$jours =  $tabDate[2];
								date_default_timezone_set("Europe/Paris" );
								$dateFin = mktime(0, 0, 0, $mois, $jours, $annees);
								if($dateFin >= $auj)
		    					{
		    						$enRevision = 'oui';
		    					}
		    				}
		    				else
		    				{
		    					$enRevision = 'oui';
		    				}
		    			}
		    		}
		    		if($enRevision != 'oui')
		    		{
		    			$tabAvion = array($jdb['idAvion'] => $numAvion);
		    		}
		    		
		    		
		    		if(isset($_POST['ChoixDesAvions']))
		    		{
		    			$choixDesAvions = $_POST['ChoixDesAvions'];
		    		}
		    		$okAvion = $this->_getParam('avion');
		    		if(isset($okAvion))
		    		{
		    			$choixDesAvions = $okAvion;
		    		}
		    		if(isset($choixDesAvions))
		    		{
			    		$monAvion = $choixDesAvions;
			    		$avions = $avion->find($monAvion)->current();
			    		$nomDeAvion = $avions['numImmatriculation'];
			    		$this->view->monAvion = $nomDeAvion;
			    		$avions = $avion->find($monAvion)->current();
			    		$idModele = $avions['idModele'];
			    		
			    		$lesBrevetsModeles = $liaionBrevetModele->fetchAll();
			    		foreach($lesBrevetsModeles as $unBrevetModele)
			    		{
			    			if($idModele == $unBrevetModele['idModele'])
			    			{
			    				$listeBrevets[] = $unBrevetModele['idBrevet'];
			    			}
			    		}
			    		if(!isset($listeBrevets))
			    		{
			    			$listeBrevets[] = 1;
			    		}
			    		
			    		$lesBrevetsPilotes = $liaisonPiloteBrevet->fetchAll();
			    		foreach($listeBrevets as $unBrevet)
			    		{
				    		foreach($lesBrevetsPilotes as $unBrevetPilote)
				    		{
				    			if($unBrevet == $unBrevetPilote['idBrevet'])
				    			{
				    				$listePilotes[] = $unBrevetPilote['idPilote'];
				    			}
				    		}
			    		}
			    		foreach($listePilotes as $unPilote)
			    		{
				    		if($jdb['idPilote'] == $unPilote)
				    			$tabPilote = array($jdb['idPilote'] => $nomPrenomPilote);
				    		if($jdb['idCoPilote'] == $unPilote)
				    			$tabPilote = array($jdb['idCoPilote'] => $nomPrenomcoPilote);
			    		}
		    		}
		    	}
	    	}
	    	if(isset($tabAvion))
	    	{
		    	$piloteChoisi = $this->_getParam('piloteChoisi');
		    	if($piloteChoisi != 'oui')
		    	{
			    	//on crée le formulaire
			    	$formulaireAjout = new Zend_Form;
			    	$formulaireAjout -> setAttrib('id','formulaireAjout');
			    	$formulaireAjout -> setMethod('post');
			    	$formulaireAjout -> setAction('/planning/volacreer?numerovol='.$volAPlannifier.'&date='.$dateDuVolAPlannifier.'&piloteChoisi=oui');
			    	 
			    	$choixAvion = new Zend_Form_Element_Select('ChoixDesAvions');
			    	$choixAvion -> setLabel('Choisir l\'avion');
			    	$choixAvion -> setMultiOptions($tabAvion);
					$choixAvion -> setValue($tabAvion);
			    	$formulaireAjout -> addElement($choixAvion);
			    	
			    	$envoyer = new Zend_Form_Element_Submit('boutonAvion');
			    	$envoyer -> setLabel('Ajouter');
			    	$formulaireAjout -> addElement($envoyer);
			    	$this->view->formulaire = $formulaireAjout;
		    	}
		    	else
		    	{
		    		if(isset($tabPilote))
		    		{
			    		//on crée le formulaire
			    		if(isset($_POST['ChoixDesAvions']))
			    		{
			    			$lAvion = $_POST['ChoixDesAvions'];
			    		}
			    		else
			    		{
			    			$lAvion = $this->_getParam('avion');
			    		}
			    		$formulaireAjout = new Zend_Form;
			    		$formulaireAjout -> setAttrib('id','formulaireAjout');
			    		$formulaireAjout -> setMethod('post');
			    		$formulaireAjout -> setAction('/planning/volacreer?retour=oui&numerovol='.$volAPlannifier.'&date='.$dateDuVolAPlannifier.'&avion='.$lAvion);
			    		 
			    		$choixPilote = new Zend_Form_Element_Select('ChoixDesPilotes');
	    		    	$choixPilote -> setLabel('Choisir le pilote');
	    		    	$choixPilote -> setMultiOptions($tabPilote);
	    		    	$formulaireAjout -> addElement($choixPilote);
	    		
	    		    	$choixCoPilote = new Zend_Form_Element_Select('ChoixDesCoPilotes');
	    		    	$choixCoPilote -> setLabel('Choisir le co-pilote');
	    		    	$choixCoPilote -> setMultiOptions($tabPilote);
	    		    	$formulaireAjout -> addElement($choixCoPilote);
			    		
			    		$envoyer = new Zend_Form_Element_Submit('boutonAjouterJDB');
			    		$envoyer -> setLabel('Ajouter');
			    		$formulaireAjout -> addElement($envoyer);
			    		$this->view->formulaire = $formulaireAjout;
		    		}
		    		else
		    		{
		    			$message = 'Aucun pilote présent n\'est habilité à piloter cet avion...';
		    			$this->view->message = $message;
		    		}
		    	}
	    	}
	    	else
	    	{
	    		$message = 'Aucun avion n\'est présent...';
	    		$this->view->message = $message;
	    	}	 
	    	
	    	//on envoie les données a la vue
    		if(isset($idAvion))
	    	{
	    		$this->view->lesAvions = $idAvion;
	    	}
	    	if(isset($idPilote))
	    	{
	    		$this->view->lesPilotes = $idPilote;
	    	}
	    	$bb = $vol->find($volAPlannifier)->current();
	    	$bbb = $bb->numVol;
	    	$this->view->leVol = $bbb;
	    	
    	}
    }
    
    public function modifierplanningAction()
    {
    	
    }
}