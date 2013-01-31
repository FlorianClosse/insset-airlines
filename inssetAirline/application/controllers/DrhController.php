<?php
class DrhController extends Zend_Controller_Action
{
	public function init(){
		$this->_helper->actionStack('login', 'index', 'default', array());
	}
	
	
	public function preDispatch()
	{
		// Ne rend plus aucune action de ce contrôleur
		$auth = Zend_Auth::getInstance();
		if (!$auth->hasIdentity())
		{
				$this->_redirect('/index/login');
 
		}
		
	if($_SESSION['Zend_Auth']['storage']->service != 9){
			if($_SESSION['Zend_Auth']['storage']->service != 5){
				$this->_redirect('/index');
			}
		}
	}
	
	
    public function indexAction(){
    	
    	if(isset($_POST['EnvoyerBrevet'])){
    		$listepilotebrevet = New LiaisonPiloteBrevet();
    		$brevet = $listepilotebrevet->createRow();
    		$brevet->idPilote = $_POST['pilote'];
    		$brevet->idBrevet = $_POST['brevet'];
    		$date = $_POST['datepicker'];
    		$brevet->dateDobtention= $date;
    		$brevet->save();
    	}
    }
    
    public function ajouterpersonneAction(){
    	/* Créer un objet formulaire */
    	$formajoutpers = new Fajoutpilote();
    	/* Effectuer le rendu du formulaire */
//     	$this->view->formajoutpers = $formajoutpers;
    	
    	$data = $this->getRequest()->getPost();
    	
    	if($this->getRequest()->getPost()){
	    	$listepilote = New Pilote();
	    	$Pilote = $listepilote->createRow();
	    	$Pilote->idPilote = '';
	    	$Pilote->nomPilote = $_POST['nomPilote'];
	    	$Pilote->prenomPilote = $_POST['prenomPilote'];
	    	$Pilote->adresse = $_POST['adressePilote'];
	    	$Pilote->telephone = $_POST['telephonePilote'];
	    	$Pilote->email = $_POST['mailPilote'];
	    	$Pilote->idAeroportEmbauche = $_POST['aeroport'];
	    	
	    	if($formajoutpers->isValid($data)){	
	    			
	    	 		$Pilote->save();
	    	 		$this->getResponse()->setHeader('Refresh', '1; URL=/drh/index');	
	    	}
	    	else{
	    		echo'<div class = "formulaireNico">
	    		<div class = "contenuFormulaireNico">';
	    		echo 'Une ou plusieur erreur se sont introduit dans le formulaire , réessayez ';
	    		echo $formajoutpers->populate($data);
	    		echo'</div>
	    		</div>';
	    	}
    	}else{
    		echo'<div class = "formulaireNico">
    		<div class = "contenuFormulaireNico">';
    		echo  $formajoutpers;
    		echo'</div>
    		</div>';
    	}
    } 
    
    public function brevetAction(){
    	

    	/* Créer un objet formulaire */
    	$formbrevet = new Fbrevet();
    	/* Effectuer le rendu du formulaire */
    	$this->view->formbrevet = $formbrevet;
    }
    
    public function piloteAction(){

            $listeDonnees = array();
            $datejour = date('Y-m-d');
            $sql0= 'SELECT \''.$datejour.'\' - INTERVAL 7 DAY AS jourmoin7';
            $db2 = Zend_Db_Table::getDefaultAdapter();
            $datas = $db2->query($sql0)->fetch();
            $datemoin7 = $datas['jourmoin7'];



            $sql = 'select P.nomPilote ,
                           P.prenomPilote,
                           count(V.dureeVol) AS nombreVol,
                           SUM( V.dureeVol ) AS dureeVol
                   from journalDeBord J,
                           pilote P ,
                           vol V
                   WHERE dateDepart  >= \''.$datemoin7.'\'
                       AND dateDepart  <= \''.$datejour.'\'
                       AND (J.idPilote = P.idPilote OR J.idCoPilote =  P.idPilote )
                       AND J.idVol = V.idVol
                   GROUP BY P.nomPilote
                   ORDER BY nombreVol DESC';


            $db = Zend_Db_Table::getDefaultAdapter();
            $datas = $db->query($sql)->fetchAll();

        $page=$this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($datas);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(2);
        $paginator->setCurrentPageNumber($page);

            $compteur = 0;
            foreach ($paginator as $data ){

                $compteur = $compteur + 1;
                $listeDonnees[$compteur][0] = $data['nomPilote'];
                $listeDonnees[$compteur][1] = $data['prenomPilote'];
                $listeDonnees[$compteur][2] = $data['nombreVol'];
                $listeDonnees[$compteur][3] = $data['dureeVol'];
            }
            $this->view->paginator=$paginator;
            $this->view->listePilote = $listeDonnees;
    }

    public function filtreAction(){

        $id = $this->_getParam('id');
        $this->view->id = $id;

        switch ($id) {
            case 0:
                $idfiltre = 0;
                if(isset($_POST['Filtrer'])){
                    $idaero = $_POST['aeroport'];
                    $heuremax = $_POST['heuremax'];
                    $listeDonnees = array();
                    $datejour = date('Y-m-d');
                    $sql0= 'SELECT \''.$datejour.'\' - INTERVAL 7 DAY AS jourmoin7';
                    $db2 = Zend_Db_Table::getDefaultAdapter();
                    $datas = $db2->query($sql0)->fetch();
                    $datemoin7 = $datas['jourmoin7'];



                    $sql = 'select P.nomPilote ,
                           P.prenomPilote,
                           P.idAeroportEmbauche ,
                           count(V.dureeVol) AS nombreVol,
                           SUM( V.dureeVol ) AS dureeVol
                   from journalDeBord J,
                           pilote P ,
                           vol V
                   WHERE dateDepart  >= \''.$datemoin7.'\'
                       AND dateDepart  <= \''.$datejour.'\'
                       AND (J.idPilote = P.idPilote OR J.idCoPilote =  P.idPilote )
                       AND J.idVol = V.idVol
                       AND P.idAeroportEmbauche = \''.$idaero.'\'
                   GROUP BY P.nomPilote
                   ORDER BY nombreVol DESC';


                    $db = Zend_Db_Table::getDefaultAdapter();
                    $datas = $db->query($sql)->fetchAll();
                    $compteur = 0;
                    foreach ($datas as $data ){

                        if(empty($heuremax)){
                            $compteur = $compteur + 1;
                            $listeDonnees[$compteur][0] = $data['nomPilote'];
                            $listeDonnees[$compteur][1] = $data['prenomPilote'];
                            $listeDonnees[$compteur][2] = $data['nombreVol'];
                            $listeDonnees[$compteur][3] = $data['dureeVol'];
                        }
                        if(($heuremax>=1)&&($data['dureeVol']>=$heuremax)){
                            $compteur = $compteur + 1;
                            $listeDonnees[$compteur][0] = $data['nomPilote'];
                            $listeDonnees[$compteur][1] = $data['prenomPilote'];
                            $listeDonnees[$compteur][2] = $data['nombreVol'];
                            $listeDonnees[$compteur][3] = $data['dureeVol'];
                        }

                    }

                    $this->view->listePilote = $listeDonnees;
                    $idfiltre = 1;

                }
                $this->view->idfiltre = $idfiltre;
                break;
            case 1:
                /* Créer un objet formulaire */
                $formfiltre1 = new Ffiltre1drh();
                /* Effectuer le rendu du formulaire */
                echo $formfiltre1;
                break;
            case 2:
                echo "i égal 2";
                break;
        }
    }
    
}

