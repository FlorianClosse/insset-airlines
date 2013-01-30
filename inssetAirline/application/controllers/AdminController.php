<?php
	class AdminController extends Zend_Controller_Action
	{	
		public function indexAction()
		{
			
		}
		
		/*************** Actions pour gérer les aéroports*****************/
		public function aeroportAction()
		{
			$aeroport = new Aeroport();
			$pagination = Zend_Paginator::factory($aeroport->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lesaeroports = $pagination;
			$this->view->formajoutaeroport = new FormAjoutAeroport();
		}
		
		public function ajoutaeroportAction()
		{
			$formajoutaeroport = new FormAjoutAeroport();
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutaeroport->isValid($data))
				{
					$aeroport = new Aeroport();
					$newaeroport = $aeroport->createRow();
					$newaeroport->nomAeroport = $data['nomAeroport'];
					$newaeroport->trigramme = $data['trigramme'];
					$newaeroport->longueurPiste = $data['longueurPiste'];
					$newaeroport->idVille = $data['idVille'];
					$newaeroport->save();
					$this->_redirect('/admin/aeroport');
				}
				else
				{
					$formajoutaeroport->populate($data);
					echo $formajoutaeroport;
				}
			}
			else
			{
				echo $formajoutaeroport;
			}
		}
		
		public function modifieraeroportAction()
		{
			$formajoutaeroport = new FormAjoutAeroport();
			$aeroport = new Aeroport();
		
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutaeroport->isValid($data))
				{
					$newaeroport = $aeroport->find($data['idAeroport'])->current();
					$newaeroport->nomAeroport = $data['nomAeroport'];
					$newaeroport->trigramme = $data['trigramme'];
					$newaeroport->longueurPiste = $data['longueurPiste'];
					$newaeroport->idVille = $data['idVille'];
					$newaeroport->save();
					$this->_redirect('/admin/aeroport');
				}
				else
				{
					$formajoutaeroport->populate($data);
					echo $formajoutaeroport;
				}
			}
			else
			{
				if(isset($_GET['idAeroport']))
				{
					$laeroport = $aeroport->selectOne($_GET['idAeroport']);
					$this->view->formajoutaeroport = $formajoutaeroport->populate($laeroport[0]);
				}
			}
		}
		/*************** Fin Actions pour gérer les aéroports*****************/
		
		/*************** Actions pour gérer les utilisateurs*****************/
		public function userAction()
		{
			$user = new User();
			$pagination = Zend_Paginator::factory($user->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lesusers = $pagination;
			$this->view->formajoutuser = new FormAjoutUser();
		}
		
		public function ajoutuserAction()
		{
			$formajoutuser = new FormAjoutUser();
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutuser->isValid($data))
				{
					$user = new User();
					$newuser = $user->createRow();
					$newuser->nomUser = $data['nomUser'];
					$newuser->prenomUser = $data['prenomUser'];
					$newuser->email = $data['email'];
					$newuser->motDePasse = $data['motDePasse'];
					$newuser->dateNaissance = $data['dateNaissance'];
					$newuser->service = $data['service'];
					$newuser->idAeroport = $data['idAeroport'];
					$newuser->save();
					$this->_redirect('/admin/user');
				}
				else
				{
					$formajoutuser->populate($data);
					echo $formajoutuser;
				}
			}
			else
			{
				echo $formajoutuser;
			}
		}
		
		public function supprimeruserAction()
		{
			if(isset($_GET['idUser']))
			{				
				$user= new User();
				$leuser = $user->find($_GET['idUser'])->current();
				$leuser->delete();
				$this->_redirect('/admin/user');
			}
		}
		
		public function modifieruserAction()
		{
			$formajoutuser = new FormAjoutUser();
			$user = new User();
				
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutuser->isValid($data))
				{
					$newuser = $user->find($data['idUser'])->current();
					$newuser->nomUser = $data['nomUser'];
					$newuser->prenomUser = $data['prenomUser'];
					$newuser->email = $data['email'];
					$newuser->motDePasse = $data['motDePasse'];
					$newuser->dateNaissance = $data['dateNaissance'];
					$newuser->service = $data['service'];
					$newuser->idAeroport = $data['idAeroport'];
					$newuser->save();
					$this->_redirect('/admin/user');
				}
				else
				{
					$formajoutuser->populate($data);
					echo $formajoutuser;
				}
			}
			else
			{
				if(isset($_GET['idUser']))
				{
					$leuser = $user->selectOne($_GET['idUser']);
					$this->view->formajoutuser = $formajoutuser->populate($leuser[0]);
				}
			}
		}
		/*************** Fin actions pour gérer les utilisateurs*****************/
		
		/*************** Actions pour gérer les villes*****************/
		public function villeAction()
		{
			$ville = new Ville();
			$pagination = Zend_Paginator::factory($ville->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lesvilles =$pagination;
			$this->view->formajoutville = new FormAjoutVille();
		}
		
		public function ajoutvilleAction()
		{
			$formajoutville = new FormAjoutVille();
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutville->isValid($data))
				{
					$ville = new Ville();
					$newville = $ville->createRow();
					$newville->nomVille = $data['nomVille'];
					$newville->cpVille = $data['cpVille'];
					$newville->idPays = $data['idPays'];
					$newville->save();
					$this->_redirect('/admin/ville');
				}
				else
				{
					$formajoutville->populate($data);
					echo $formajoutville;
				}
			}
			else
			{
				echo $formajoutville;
			}
		}
		
		public function modifiervilleAction()
		{
			$formajoutville = new FormAjoutVille();
			$ville = new Ville();
		
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutville->isValid($data))
				{
					$newville = $ville->find($data['idVille'])->current();
					$newville->nomVille = $data['nomVille'];
					$newville->cpVille = $data['cpVille'];
					$newville->idPays = $data['idPays'];
					$newville->save();
					$this->_redirect('/admin/ville');
				}
				else
				{
					$formajoutville->populate($data);
					echo $formajoutville;
				}
			}
			else
			{
				if(isset($_GET['idVille']))
				{
					$laville = $ville->selectOne($_GET['idVille']);
					$this->view->formajoutville = $formajoutville->populate($laville[0]);
				}
			}
		}
		/*************** Fin actions pour gérer les villes *****************/
		
		/*************** Actions pour gérer les pays *****************/
		public function paysAction()
		{
			$pays = new Pays();
			$pagination = Zend_Paginator::factory($pays->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lespays = $pagination;
			$this->view->formajoutpays = new FormAjoutPays();
		}
		
		public function ajoutpaysAction()
		{
			$formajoutpays = new FormAjoutPays();
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutpays->isValid($data))
				{
					$pays = new Pays();
					$newPays = $pays->createRow();
					$newPays->nomPays = $data['nomPays'];
					$newPays->save();
					$this->_redirect('/admin/pays');
				}
				else
				{
					$formajoutpays->populate($data);
					echo $formajoutpays;
				}
			}
			else
			{
				echo $formajoutpays;
			}
		}
		
		public function modifierpaysAction()
		{
			$formajoutpays = new FormAjoutPays();
			$pays = new Pays();
		
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutpays->isValid($data))
				{
					$newPays = $pays->find($data['idPays'])->current();
					$newPays->nomPays = $data['nomPays'];
					$newPays->save();
					$this->_redirect('/admin/pays');
				}
				else
				{
					$formajoutpays->populate($data);
					echo $formajoutpays;
				}
			}
			else
			{
				if(isset($_GET['idPays']))
				{
					$lepays = $pays->selectOne($_GET['idPays']);
					$this->view->formajoutpays = $formajoutpays->populate($lepays[0]);
				}
			}
		}
		/*************** Fin actions pour gérer les pays*****************/
		
		/*************** Actions pour gérer les modèles *****************/
		public function modeleAction()
		{
			$modele = new Modele();
			$pagination = Zend_Paginator::factory($modele->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lesmodeles = $pagination;
			$this->view->formajoutmodele = new FormAjoutModele();
		}
		
		public function ajoutmodeleAction()
		{
			$formajoutmodele = new FormAjoutModele();
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutmodele->isValid($data))
				{
					$modele = new Modele();
					$newmodele = $modele->createRow();
					$newmodele->nomModele = $data['nomModele'];
					$newmodele->longueurPiste = $data['longueurPiste'];
					$newmodele->rayonDaction = $data['rayonDaction'];
					$newmodele->nbPlace = $data['nbPlace'];
					$newmodele->periodePetiteRevision = $data['periodePetiteRevision'];
					$newmodele->periodeGrandeRevision = $data['periodeGrandeRevision'];
					$newmodele->save();
					$this->_redirect('/admin/modele');
				}
				else
				{
					$formajoutmodele->populate($data);
					echo $formajoutmodele;
				}
			}
			else
			{
				echo $formajoutmodele;
			}
		}
		
		public function modifiermodeleAction()
		{
			$formajoutmodele = new FormAjoutModele();
			$modele = new Modele();
				
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutmodele->isValid($data))
				{
					$newmodele = $modele->find($data['idModele'])->current();
					$newmodele->nomModele = $data['nomModele'];
					$newmodele->longueurPiste = $data['longueurPiste'];
					$newmodele->rayonDaction = $data['rayonDaction'];
					$newmodele->nbPlace = $data['nbPlace'];
					$newmodele->periodePetiteRevision = $data['periodePetiteRevision'];
					$newmodele->periodeGrandeRevision = $data['periodeGrandeRevision'];
					$newmodele->save();
					$this->_redirect('/admin/modele');
				}
				else
				{
					$formajoutmodele->populate($data);
					echo $formajoutmodele;
				}
			}
			else
			{
				if(isset($_GET['idModele']))
				{
					$lemodele = $modele->selectOne($_GET['idModele']);
					$this->view->formajoutmodele = $formajoutmodele->populate($lemodele[0]);
				}
			}
		}
		/*************** Fin actions pour gérer les modèles*****************/
		
		/*************** Actions pour gérer les brevets *****************/
		public function brevetAction()
		{
			$brevet = new Brevet();
			$pagination = Zend_Paginator::factory($brevet->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lesbrevets = $pagination;
			$this->view->formajoutbrevet = new FormAjoutBrevet();
		}
		
		public function ajoutbrevetAction()
		{
			$formajoutbrevet = new FormAjoutBrevet();
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutbrevet->isValid($data))
				{
					$brevet = new Brevet();
					$newbrevet = $brevet->createRow();
					$newbrevet->nomBrevet = $data['nomBrevet'];
					$newbrevet->dureeBrevetEnAnnee = $data['dureeBrevetEnAnnee'];
					$newbrevet->save();
					$this->_redirect('/admin/brevet');
				}
				else
				{
					$formajoutbrevet->populate($data);
					echo $formajoutbrevet;
				}
			}
			else
			{
				echo $formajoutbrevet;
			}
		}
		
		public function modifierbrevetAction()
		{
			$formajoutbrevet = new FormAjoutBrevet();
			$brevet = new Brevet();
			
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formajoutbrevet->isValid($data))
				{
					$newbrevet = $brevet->find($data['idBrevet'])->current();
					$newbrevet->nomBrevet = $data['nomBrevet'];
					$newbrevet->dureeBrevetEnAnnee = $data['dureeBrevetEnAnnee'];
					$newbrevet->save();
					$this->_redirect('/admin/brevet');
				}
				else
				{
					$formajoutbrevet->populate($data);
					echo $formajoutbrevet;
				}
			}
			else
			{
				if(isset($_GET['idBrevet']))
				{
					$lebrevet = $brevet->selectOne($_GET['idBrevet']);
					$this->view->formajoutbrevet = $formajoutbrevet->populate($lebrevet[0]);
				}
			}
		}
		
		public function supprimerbrevetAction()
		{
			if(isset($_GET['idBrevet']))
			{
				$liaisonpilotebrevet = new LiaisonPiloteBrevet();
				$lesbrevets = $liaisonpilotebrevet->selectAll($_GET['idBrevet']);
				foreach($lesbrevets as $unbrevet)
				{
					$unbrevet = $liaisonpilotebrevet->delete($unbrevet['idPilote']);
				}
				
				$liaisonbrevetmodele = new LiaisonBrevetModele();
				$lesbrevets = $liaisonbrevetmodele->selectAllByBrevet($_GET['idBrevet']);
				foreach($lesbrevets as $unbrevet)
				{
					$unbrevet = $liaisonpilotebrevet->delete($unbrevet['idBrevet'],$unbrevet['idModele']);
				}
				
				$brevet= new Brevet();
				$lebrevet = $brevet->find($_GET['idBrevet'])->current();
				$lebrevet->delete();
				
				$this->_redirect('/admin/brevet');
			}
		}
		/*************** Fin actions pour gérer les brevets*****************/
	}
?>