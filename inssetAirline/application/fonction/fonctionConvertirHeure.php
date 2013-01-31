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
    
    function fonctionConvertirHeureMinutes($temps)
    {
    	$heure = ceil($temps / 3600);
    	if($temps == ($heure*3600))
    	{
    		$resultat = $heure.' H 00';
    	}
    	else 
    	{
    		$heure = $heure -1;
    		$minute = $temps - ($heure*3600);
    		$minute = ceil($minute / 60) - 1;
    		$resultat = $heure.' H '.$minute;
    	}
    	
    	return $resultat;
    }
    
    function Lien($day,$month,$year,$class)
    {
    	$NomDuMois=array("erreur","Janvier","Fevrier","Mars","Avril","Mai","Juin",
    			"Juillet","Aout","Septembre","Octobre","Novembre","Decembre");
    	$monthname=$NomDuMois[$month+0];
    	$ladate = mktime(1, 1, 1, $month, $day, $year);
    	if ($day == 0)
    		$lien= $monthname.' '.$year;
    	else
    		$lien='<a href="creerplanning?date='.$ladate.'" class="'.$class.'">'.$day.'</a>';
    	return $lien;
    }
    
    function Lien2($day)
    {
    	$lien='<div class="pasDeVols">'.$day.'</div>';
    	return $lien;
    }
    
    function Calendrier($month,$year,$links)
    {
    
    	$MonthNames = array(1 => "Janvier","Fevrier","Mars","Avril","Mai","Juin",
    			"Juillet","Aout","Septembre","Octobre","Novembre","Decembre");
    	$monthname = $MonthNames[$month+0];
    	
    	
    	// on ouvre la table
    	echo '<table class="cal" cellspacing="1">';
    
    	// Première ligne = mois et année ou link[0]
    	$title = array_key_exists(0, $links) ? $links[0] : $monthname.' '.$year;
    	echo '<tr><td colspan="7" class="cal_titre">'.$title.'</td>'."</tr>\n";
    
    	// Seconde lignes = initiales des jours de la semaine
    	$DayNames = array("L","M","M","J","V","S","D");
    	echo '<tr>'; foreach ($DayNames as $d) echo '<th>'.$d.'</th>'; echo "</tr>\n";
    
    	// On regarde si aujourd'hui est dans ce mois pour mettre un style particulier
    	if ($year == date('Y') && $month == date('m'))
    		$today = date('d');
    	else
    		$today = 0;
    
    	$time = mktime(0,0,0,$month,1,$year); // timestamp du 1er du mois demandé
    	$days_in_month = date('t',$time);     // nombre de jours dans le mois
    	$firstday = date('w',$time);          // jour de la semaine du 1er du mois
    	if ($firstday == 0) $firstday = 7;    // attention, en php, dimanche = 0
    
    	$daycode = 1; // ($daycode % 7) va nous indiquer le jour de la semaine.
    	// on commence par le lundi, c'est-à-dire 1.
    
    	// on ouvre une première ligne pour le calendrier proprement dit :
    	echo '<tr>';
    
    	// on met des cases blanches jusqu'à la veille du 1er du mois :
    	for ( ; $daycode<$firstday; $daycode++) echo '<td>&nbsp;</td>';
    
    	// boucle sur tous les jours du mois :
    	for ($numday = 1; $numday <= $days_in_month; $numday++, $daycode++) {
    		// si on en est au lundi (sauf le 1er),
    		// on ferme la ligne précédente et on en ouvre une nouvelle
    		if ($daycode%7 == 1 && $numday != 1) echo "</tr>\n".'<tr>';
    		// on ouvre la case (avec un style particulier s'il s'agit d'aujourd'hui)
    		echo ($numday == $today ? '<td class="today">' : '<td>');
    		// on affiche le numéro du jour ou le contenu donné par l'utilisateur
    		echo (array_key_exists($numday, $links) ? $links[$numday] : $numday);
    		// on ferme la case
    		echo '</td>';
    	}
    
    	// on met des cases blanches pour completer la dernière semaine si besoin :
    	for ( ; $daycode%7 != 1; $daycode++) echo '<td>&nbsp;</td>';
    
    	// on ferme la dernière ligne, et la table.
    	echo '</tr>'; echo "</table>\n\n";
    }
?>