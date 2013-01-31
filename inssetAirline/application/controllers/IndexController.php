<?php

class IndexController extends Zend_Controller_Action
{	
    public function init()
    {
        /* Initialize action controller here */

    }

    public function indexAction()
    {
    	$auth = Zend_Auth::getInstance();
    	//on regarde si on est bien authentifié
    	if ($auth->hasIdentity())
    	{
	        //Menu par Nicolas 
	        $this->_helper->actionStack('login', 'index', 'default', array());
	        
	        $menu = $this->_getParam('menu');
	        if(isset($menu))
	        {
	        	switch ($menu)
	        	{
	        		case "commercial":
	        			$this->_helper->actionStack('index', 'commercial', 'default', array());
	        			break;
	        			 
	        		case "strategique":
	        			$this->_helper->actionStack('index', 'strategique', 'default', array());
	        			break;
	        		
	        		case "technique":
	        			$this->_helper->actionStack('index', 'technique', 'default', array());
	        			break;
	        		
	        		case "logistique":
	        			$this->_helper->actionStack('index', 'logistique', 'default', array());
	        			break;
	        		
	        		case "drh":
	        			$this->_helper->actionStack('index', 'drh', 'default', array());
	        			break;
	        		
	        		case "maintenance":
	        			$this->_helper->actionStack('index', 'maintenance', 'default', array());
	        			break;
	
	        		case "exploitation":
	        			$this->_helper->actionStack('index', 'exploitation', 'default', array());
	        			break;
	        			
	        		case "planning":
	        			$this->_helper->actionStack('index', 'planning', 'default', array());
	        			break;
	        	}
	        }
    	}
    	else
    	{
    		$this->_redirect('/index/login');
    	}
    }
    
    
    public function loginAction()
    {
    	$formDeco = new Fdeco();
    	$this->view->formDeco =$formDeco;
    	
    	$formConnexion = new Flogin();
		$this->_helper->viewRenderer->setResponseSegment('login');
		if ($this->_request->isPost())
		{
			if($formConnexion->isValid($this->getRequest()->getPost()))
			{
				try {
					$db =Zend_Registry::get('db');
					//credits de l'utilisateur $_post normalement
					// on récupère les données du formulaire de connexion
					//et on applique un filtre dessus qui enleve toutes balises
					//php ou html
					$f = new Zend_Filter_StripTags();
					$login = $f->filter($this->_request->getPost('email'));
					$password = $f->filter($this->_request->getPost('password'));
					 
					//on instancie Zend_Auth
					$auth = Zend_Auth::getInstance();
					 
					//charger et parametrer l'adapteur
					//on peut passer un dernier parametre 'MD5(?)'
					$dbAdapter = new Zend_Auth_Adapter_DbTable($db,'user','email','motDePasse');
					 
					//charger les logs à vérifier
					$dbAdapter->setIdentity($login);
					$dbAdapter->setCredential($password);
					 
					//on test l'autentification
					$resultat = $auth->authenticate($dbAdapter);
					 
					if($resultat->isValid())
					{
						$data = $dbAdapter->getResultRowObject(null,'motDePasse');
						$auth->getStorage()->write($data);
						if(isset($_SESSION['Zend_Auth']['storage']))
						{
							$this->getResponse()->setHeader('Refresh', '0; URL=/index/index');	
						}
						
					}
					else
					{
						$this->_redirect('/index/login');
					}
				}
				catch(Zend_Exception $e)
				{
					echo $e->getMessage();
				}
			}
		}
		else
		{
			$auth = Zend_Auth::getInstance();
			//on regarde si on est bien authentifié
			if ($auth->hasIdentity())
			{
				//on affiche l'email de celui qui est connecté
				$identity = $auth->getIdentity();
				$this->view->identity = $identity;
			}
			else
			{
				$formConnexion = new Flogin();
				$this->view->form =$formConnexion;
			}
		}
    }
   
    public function decoAction()
    {
    	if(isset($_POST['submit'])){
    		$auth = Zend_Auth::getInstance();
    		if ($auth->hasIdentity())
    		{
    			
    			Zend_Auth::getInstance()->clearIdentity();
				$this->_redirect('index/index');
    		}
    	}
    }
}