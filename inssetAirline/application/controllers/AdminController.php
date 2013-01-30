<?php
	class AdminController extends Zend_Controller_Action
	{	
		public function indexAction()
		{
			
		}
		
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
		
		public function villeAction()
		{
			$ville = new Ville();
			$pagination = Zend_Paginator::factory($ville->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lesvilles =$pagination;
		}
		
		public function paysAction()
		{
			$pays = new Pays();
			$pagination = Zend_Paginator::factory($pays->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lespays = $pagination;
		}
		
		public function modeleAction()
		{
			$modele = new Modele();
			$pagination = Zend_Paginator::factory($modele->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lesmodeles = $pagination;
		}
		
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
	}
?>