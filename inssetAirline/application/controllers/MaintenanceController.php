<?php 
class MaintenanceController extends Zend_Controller_Action
{
	
	public function preDispatch()
	{
		$this->_helper->actionStack('login', 'index', 'default', array());
		// Ne rend plus aucune action de ce contrôleur
		$auth = Zend_Auth::getInstance();
		if (!$auth->hasIdentity())
		{
			$this->_helper->viewRenderer->setNoRender();
		}
	}
	
	public function indexAction()
	{
		$filtre = new FormFiltreMaintenance();
		echo $filtre;
		$formAjoutAvion = new FormAjoutAvion();
		$this->view->formajoutavion= $formAjoutAvion;
		
		if($this->getRequest()->isPost())
		{
			$data = $this->getRequest()->getPost();
			$avion= new Avion();
			$i=0;
			foreach($data as $c => $v)
			{
				if($v != "0" && $v != "Filtrer")
				{
					if($c == 'statut')
					{
						$v = '\''.$v.'\'';
					}
					$i++;
					$array[]= array($c,$v);
				}
			}

			switch ($i) 
			{
				case 0:
					$this->view->lesavions = $avion->selectAll();
					break;
				case 1:
					$this->view->lesavions = $avion->selectFiltreUn($array[0][0], $array[0][1]);
					break;
				case 2:
					$this->view->lesavions = $avion->selectFiltreDeux($array[0][0], $array[0][1], $array[1][0], $array[1][1]);
					break;
				case 3:
					$this->view->lesavions = $avion->selectFiltreTrois($array[0][0],$array[0][1],$array[1][0],$array[1][1],$array[2][0],$array[2][1]);
					break;
				case 4:
					$this->view->lesavions = $avion->selectFiltreQuatre($array[0][0],$array[0][1],$array[1][0],$array[1][1],$array[2][0],$array[2][1],$array[3][0],$array[3][1]);
					break;
			}
		}
		else
		{
			$avion= new Avion();
			$this->view->lesavions = $avion->selectAll();
		}
	}

	public function supprimerAction()
	{
		if(isset($_GET['supprId']))
		{
			$avion= new Avion();
			$lavion = $avion->find($_GET['supprId'])->current();
			$lavion->delete();
			$this->_redirect('/maintenance/index');
		}
	}
	
	public function ajoutAction()
	{	
		$formAjoutAvion = new FormAjoutAvion();	
		if($this->getRequest()->isPost())
		{
			$data = $this->getRequest()->getPost();
			if($formAjoutAvion->isValid($data))
			{
				$listeAvion = New Avion();
				$avion = $listeAvion->createRow();
				$avion->idAvion = '';
				$avion->numImmatriculation = $data['immatriculation'];
				$avion->dateMisEnService = $data['dateMisEnService'];
				$avion->nombreHeureTotale = 0;
				$avion->nbHeureVolDepuisGrandeRevision = 0;
				$avion->nbHeureVolDepuisPetiteRevision = 0;
				$avion->statut = $data['statut'];
				$avion->idModele = $data['modele'];
				$avion->localisation = $data['localisation'];
				$avion->idAeroportDattache = $data['aeroportdattache'];
				$avion->save();
				$this->_redirect('/maintenance/index');
			}
			else
			{
				$formAjoutAvion->populate($data);
				echo $formAjoutAvion;
			}
		}
	}
	
	public function plannifierAction()
	{
		$formpetiterevision = new FormPetiteRevision();	
		if($this->getRequest()->isPost())
		{
			$data = $this->getRequest()->getPost();
			if($formpetiterevision->isValid($data))
			{
				//on plannifie une révision
				$revision = new Revision();
				$unerevision = $revision->createRow();
				$unerevision->idRevision = '';
				$unerevision->datePrevue = $data['datePrevue'];
				$unerevision->statutRevision = $data['statut'];
				$unerevision->idAvion = $data['idAvion'];
				$unerevision->save();
				
				$this->_redirect('/maintenance/index');
			}
			else
			{
				$formAjoutAvion->populate($data);
				echo $formpetiterevision;
			}
		}
		else
		{
			echo $formpetiterevision;
		}
	}
	
	public function afficherrevisionAction()
	{
		$revision = new Revision();
		$this->view->lesrevisions=$revision->getRevisionPlannifiees();
	}
	
	public function gererrevisionAction()
	{				
		if(isset($_POST['idRevision']))
		{
			$formpassersortirenrevision = new FormPasserSortirRevision();
			if($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if($formpassersortirenrevision->isValid($data))
				{
					if($data['action']=='mettre')
					{
						//on change le statut de l'avion
						$avion = new Avion();
						$lavion = $avion->find($data['idAvion'])->current();
						$lavion-> statut = 'en révision';
						$lavion->save();
						//on commence la révision
						$revision = new Revision();
						$larevision = $revision->find($data['idRevision'])->current();
						$larevision->dateDebut = date('Y-m-d');
						$larevision->save();
						$this->_redirect('/maintenance/index');
					}
					else
					{
						//on fini la revision
						$revision = new Revision();
						$larevision = $revision->find($data['idRevision'])->current();
						$larevision->dateFin = date('Y-m-d');
						$larevision->save();
						
						//on change le statut de l'avion
						$avion = new Avion();
						$lavion = $avion->find($data['idAvion'])->current();
						$lavion-> statut = 'actif';
						$statut=$revision->selectOne($data['idRevision']);
						if($statut[0]['statutRevision']== 'grande')
						{
							$lavion->nbHeureVolDepuisGrandeRevision = 0;
						}
						else
						{
							$lavion->nbHeureVolDepuisPetiteRevision = 0;
						}
						$lavion->save();
						
						$this->_redirect('/maintenance/index');
					}
				}
				else
				{
					$formAjoutAvion->populate($data);
					echo $formpassersortirenrevision;
				}
			}
			else
			{
				echo $formpassersortirenrevision;
			}
		}
		else
		{
			$formpassersortirenrevision = new FormPasserSortirRevision();
			echo $formpassersortirenrevision;
		}
	}
}
?>