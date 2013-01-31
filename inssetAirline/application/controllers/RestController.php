<?php
class RestController extends Zend_Controller_Action
{
	protected $_server;

	public function init() 
	{
		//Initialise Le REST
		$this->_server = new Zend_Rest_Server();
		
		// Desactive tout le HTML pour qui ne reste que le XML en sortie
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->viewRenderer->setNeverRender(true);
	}

	public function indexAction() 
	{
		// Ajoute la Classe VolsClass au service REST
		$fonctionrest = new FonctionsRest();
		$this->_server->setClass($fonctionrest);
		$this->_server->handle();
	}
}