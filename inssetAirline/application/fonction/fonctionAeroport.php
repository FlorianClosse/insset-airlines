<?php

function fonctionAeroport(){

	$pays = new Pays();
	$lesPays = $pays->fetchAll();
	 
	$ville = new Ville();
	$lesVilles = $ville ->fetchAll();
	 
	$aeroport = new Aeroport();
	$lesAeroport = $aeroport ->fetchAll();
	$aeroport = new Zend_Form_Element_Select('aeroport');

	foreach ($lesPays as $unPays ) {
		foreach ($lesVilles as $uneVille ) {
			foreach ($lesAeroport as $unAeroport ) {
				$idP = $unPays->idPays;
				$idV = $uneVille->idPays;
				$idV2 = $uneVille->idVille;
				$idA = $unAeroport->idVille;
				 
				if(($idP== $idV)&&($idV2 == $idA)){
					$aeroport->addMultiOptions(array($unPays->nomPays=>array()));
					$aeroport->addMultiOption ( $unAeroport->idAeroport, $unAeroport->nomAeroport );
					
					//$tabPays[$unPays->nomPays] =  array( $unAeroport->nomAeroport);		

				}
			}
			
		}
		
	}
	//$aeroport->addMultiOptions($tabPays); // remplit ma liste deroulante
	
	
 return $aeroport;
}