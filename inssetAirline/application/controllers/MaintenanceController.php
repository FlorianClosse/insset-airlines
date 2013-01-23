<?php 
class MaintenanceController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$formAjoutAvion = new FormAjoutAvion();
		$this->view->formajoutavion= $formAjoutAvion;
		$avion= new Avion();
		$this->view->lesavions = $avion->selectAll();
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
				$avion->idAeroportDattache = $data['idAeroportDattache'];
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
	
	public function gererAction()
	{
		if(isset($_POST['idAvion']))
		{
			$avion = new Avion();
			$revision = new Revision();
			$ok = $avion->update();
			// coucou
			
		}
	}
}
?>