<?php 

class FonctionsRest 
{
	public function tousLesVols($date)
	{
		//http://airline/rest/index?method=tousLesVols&date=2013-01-31
		$jdb = new JournalDeBord();
		$vol = new Vol();
		$aeroport = new Aeroport();
		$modele = new Modele();
		$avion = new Avion();
		
		$lesvols = $jdb->lesVolsAPartirDaujoudhui($date);
		if(count($lesvols)>0)
		{
			foreach($lesvols as $unvol)
			{
				$result[$unvol['idVol']]['idJournalDeBord'] = $unvol['idJournalDeBord'];
				$result[$unvol['idVol']]['numVol'] = $vol->find($unvol['idVol'])->current()->numVol;
				$result[$unvol['idVol']]['dateDepart'] = $unvol['dateDepart'];
				$result[$unvol['idVol']]['aeroportDepart'] = $aeroport->find($vol->find($unvol['idVol'])->current()->aeroportDepart)->current()->nomAeroport;
				$result[$unvol['idVol']]['aeroportArrivee'] = $aeroport->find($vol->find($unvol['idVol'])->current()->aeroportArrivee)->current()->nomAeroport;
				$result[$unvol['idVol']]['nbPlaceDispo'] = $unvol['nbPlaceDispo']; 
				$result[$unvol['idVol']]['modele'] = $modele->find($avion->find($unvol['idAvion'])->current()->idModele)->current()->nomModele;
				$result[$unvol['idVol']]['dureeVol'] = $vol->find($unvol['idVol'])->current()->dureeVol;
			}
			return $result;
		}
		else
		{
			return"Il n'y a aucun vol prévu";
		}
	}
}