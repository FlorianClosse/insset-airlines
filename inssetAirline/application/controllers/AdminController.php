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
		}
		
		public function userAction()
		{
			$user = new User();
			$pagination = Zend_Paginator::factory($user->selectAll());
			$pagination->setCurrentPageNumber($this->_getParam('page'));
			$pagination->setItemCountPerPage(15);
			$this->view->lesusers = $pagination;
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
		}
	}
?>