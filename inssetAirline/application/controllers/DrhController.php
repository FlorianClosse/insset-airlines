<?php
class DrhController extends Zend_Controller_Action
{
	public function init(){
	}
	
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
    		$listepilotebrevet = New liaisonPiloteBrevet();
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
    	$FormAjoutPilote = new Zend_Form();
    	
    	/* Parametrer le formulaire */
    	$FormAjoutPilote->setMethod('post')->setAction('/drh/index');
    	$FormAjoutPilote->setAttrib('id', 'FormAjoutPilote');
    	
    	/* Creer des elements de formulaire */
    	$PiloteNom= new Zend_Form_Element_Text('nomPilote');
    	$PiloteNom ->setLabel('Nom du pilote');
    	$PiloteNom->setAttrib('id', 'formpilote');
    	$PiloteNom ->setRequired(TRUE);
    	
    	
    	$PilotePrenom = new Zend_Form_Element_Text('prenomPilote');
    	$PilotePrenom ->setLabel('Prenom du pilote');
    	$PilotePrenom->setAttrib('id', 'formpilote');
    	$PilotePrenom ->setRequired(TRUE);
    	
    	$PiloteAdresse = new Zend_Form_Element_Text('adressePilote');
    	$PiloteAdresse ->setLabel('Adresse du pilote');
    	$PiloteAdresse->setAttrib('id', 'formpilote');
    	
    	$PiloteTelephone = new Zend_Form_Element_Text('telephonePilote');
    	$PiloteTelephone ->setLabel('Téléphone du pilote');
    	$PiloteTelephone->setAttrib('id', 'formpilote');
    	
    	$PiloteMail = new Zend_Form_Element_Text('mailPilote');
    	$PiloteMail ->setLabel('Mail du pilote');
    	$PiloteMail->setAttrib('id', 'formpilote');	
    	
    	$aeroport = new Aeroport;
    	$lesAeroport = $aeroport->fetchAll();
    	$aeroport = new Zend_Form_Element_Select('aeroport');
    	$aeroport ->setLabel('Choisir un aeroport');
    	foreach ($lesAeroport as $unAeroport ) {
    		$tableauAeroport[$unAeroport -> idAeroport] = ucfirst($unAeroport->nomAeroport);
    	} // permet de construite mes données de mon select
    	 
    	$aeroport->setMultiOptions($tableauAeroport); // remplit ma liste deroulante

    	$pSubmit = new Zend_Form_Element_Submit('Envoyer');
    	$pReset = new Zend_Form_Element_Reset('Reset');
    	
    	
    	/* On ajoute les elements au formulaire */
    	$FormAjoutPilote->addElement($PiloteNom);
    	$FormAjoutPilote->addElement($PilotePrenom);
    	$FormAjoutPilote->addElement($PiloteAdresse);
    	$FormAjoutPilote->addElement($PiloteTelephone);
    	$FormAjoutPilote->addElement($PiloteMail);
     	$FormAjoutPilote->addElement($aeroport);
//     	$FormAjoutPilote->addElement($pays);
    	$FormAjoutPilote->addElement($pSubmit);
    	$FormAjoutPilote->addElement($pReset);
    	
    	/* Effectuer le rendu du formulaire */
    	echo $FormAjoutPilote;
    } 
    
    public function brevetAction(){
    	/* Créer un objet formulaire */
    	$formbrevet = new Zend_Form();
    	 
    	/* Parametrer le formulaire */
    	$formbrevet->setMethod('post')->setAction('/drh/index');
    	$formbrevet->setAttrib('id', 'formbrevet');

    	$pilote = new Pilote;
    	$lesPilotes = $pilote->fetchAll();
    	$pilote = new Zend_Form_Element_Select('pilote');
    	$pilote ->setLabel('Choisir un pilote');
    	foreach ($lesPilotes as $unPilote ) {
    		$tableauPilote[$unPilote -> idPilote] = ucfirst($unPilote->nomPilote);
    	} // permet de construite mes données de mon select
    	
    	$pilote->setMultiOptions($tableauPilote); // remplit ma liste deroulante
    	
    	$brevet = new Brevet;
    	$lesBrevets = $brevet->fetchAll();
    	$brevet = new Zend_Form_Element_Select('brevet');
    	$brevet ->setLabel('Choisir un brevet');
    	foreach ($lesBrevets as $unBrevet ) {
    		$tableauBrevet[$unBrevet -> idBrevet] = ucfirst($unBrevet->nomBrevet);
    	} // permet de construite mes données de mon select
    	 
    	$brevet->setMultiOptions($tableauBrevet); // remplit ma liste deroulante
    	
    	$datepicker = new Zend_Form_Element_Text('datepicker');
    	$datepicker ->setLabel('Choisir la date d\'obtention');
    	$datepicker->setAttrib('id', 'datepicker');
    	
    	$pSubmit = new Zend_Form_Element_Submit('EnvoyerBrevet');
    	$pReset = new Zend_Form_Element_Reset('Reset');
    	 
    	/* On ajoute les elements au formulaire */
    	$formbrevet->addElement($pilote);
    	$formbrevet->addElement($brevet);
    	$formbrevet->addElement($datepicker);
    	$formbrevet->addElement($pSubmit);
    	$formbrevet->addElement($pReset);
    	 
    	/* Effectuer le rendu du formulaire */
    	echo $formbrevet;
    }
    
    public function piloteAction(){
    	
    	$listeDonnees = array();
    	$datejour = date('Y-m-d');
    	
    	$sql0= 'SELECT \''.$datejour.'\' - INTERVAL 7 DAY AS jourmoin7';
    	$db2 = Zend_Db_Table::getDefaultAdapter();
    	$datas2 = $db2->query($sql0)->fetchAll();
    	
    	foreach ($datas2 as $data2 ) {
    	 $datemoin7 = $data2['jourmoin7'];
    	}
    	
    	$sql = 'select P.nomPilote , 
    					P.prenomPilote, 
    					count(V.dureeVol) AS nombreVol,  
    					SUM( V.dureeVol ) AS dureeVol
    			from journaldebord J, 
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