<?php
class DrhController extends Zend_Controller_Action
{
    public function indexAction(){
    	if(isset($_POST['Envoyer']))
    	{
	    	$listepilote = New Pilote();
	    	$Pilote = $listepilote->createRow();
	    	$Pilote->idPilote = '';
	    	$Pilote->nomPilote = $_POST['nomPilote'];
	    	$Pilote->prenomPilote = $_POST['prenomPilote'];
	    	$Pilote->adresse = $_POST['adressePilote'];
	    	$Pilote->telephone = $_POST['telephonePilote'];
	    	$Pilote->email = $_POST['mailPilote'];
	    	$Pilote->idAeroportEmbauche = $_POST['aeroport'];
	    	if(!empty($Pilote->nomPilote)){
	    	 	$Pilote->save();
	    	}
	    	else{
	    		echo" raté";
	    	}
    	}
    	
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
    	$this->view->formajoutpers = $formajoutpers;
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
    			GROUP BY P.nomPilote';
    	$db = Zend_Db_Table::getDefaultAdapter();
    	$datas = $db->query($sql)->fetchAll();
    	$compteur = 0;
    	foreach ($datas as $data ){
    	    $compteur = $compteur + 1;
    	    $listeDonnees[$compteur][0] = $data['nomPilote'];
    	    $listeDonnees[$compteur][1] = $data['prenomPilote'];
    	    $listeDonnees[$compteur][2] = $data['nombreVol'];
    	    $listeDonnees[$compteur][3] = $data['dureeVol'];
    	}
    	$this->view->listePilote = $listeDonnees;
    }
    
}

