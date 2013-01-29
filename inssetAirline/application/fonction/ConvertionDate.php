<?php 
	function convertirDateEnLettre($date)
	{
		$lesJours = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
		$lesMois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

		
		//j'explose ma date pour récupérer l'année le mois et le jour
		$tabDate = explode("-", $date);
		$annees =  $tabDate[0]; 
		$mois =  $tabDate[1];
		$jours =  $tabDate[2];
		
		date_default_timezone_set("Europe/Paris" );
		//je récupère le timestamps correspondant a cette date
		$timesT = mktime(0, 0, 0, $mois, $jours, $annees);

		//Je récupère ma date en toute lettre
		$maDate = $lesJours[date('w', $timesT)]." ".date('d', $timesT)." ".$lesMois[date('n', $timesT)]." ".date('Y', $timesT);
		return $maDate;
	}
?>