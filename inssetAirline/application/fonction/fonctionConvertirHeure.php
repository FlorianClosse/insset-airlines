<?php 
//fonction convertir les minutes en heures par nicolas
	function fonctionConvertirHeure($temps)
    {
    	$heure = ceil($temps / 60);
    	if($temps == ($heure*60))
    	{
    		$resultat = $heure.' H 00';
    	}
    	else 
    	{
    		$heure = $heure -1;
    		$minute = $temps - ($heure*60);
    		$resultat = $heure.' H '.$minute;
    	}
    	
    	return $resultat;
    }
    
    function fonctionConvertirMinute($temps)
    {
    	$temps = explode("H", $temps);
		$heure = $temps[0]; 
		$minute = $temps[1];
		$resultat = $heure * 60 + $minute;
    	return $resultat;
    }
?>