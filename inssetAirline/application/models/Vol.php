<?php
class Vol extends Zend_Db_Table_Abstract
{
	protected $_name='vol';
	protected $_primary=array('idVol');


	protected $_referenceMap = array(
			'aeroportDepart'=>array(
					'columns'=>'idAeroport',
					'refTableClass'=>'aeroport'),
			'aeroportArrivee'=>array(
					'columns'=>'idAeroport',
					'refTableClass'=>'aeroport'),
			'idAvion'=>array(
					'columns'=>'idAvion',
					'refTableClass'=>'Avion'),
			'idDate'=>array(
					'columns'=>'idDate',
					'refTableClass'=>'dateVolAlaCarte'),
			'id_copilote'=>array(
					'columns'=>'id_pilote',
					'refTableClass'=>'Pilote')
	);
	
	
	
	
	// ***fonction getRecuperAeroportDepart par Nicolas 
	public function getRecuperAeroportDepart($aeroportDepart)
	{
		$tableAeroport = new Aeroport;
		$requete = $tableAeroport->select()
 								 ->from($tableAeroport)
								 ->where('aeroport.idAeroport=?', $aeroportDepart);
		return $requete->query()->fetch();	
	}
	
	// ***fonction getRecuperAeroportDArrivee par Nicolas
	public function getRecuperAeroportDArrivee($aeroportArrivee)
	{
		$tableAeroport = new Aeroport;
		$requete = $tableAeroport->select()
		->from($tableAeroport)
		->where('aeroport.idAeroport=?', $aeroportArrivee);
		return $requete->query()->fetch();
	}
	
	// ***fonction getRecuperDates de vol par Nicolas
	public function getRecuperDateDeVol($date)
	{
		$requete = $this->select()
						->from($this)
						->where('idVol=?', $date);
		$ligne = $requete->query()->fetch();
		
		if(empty($ligne['datePrevu']))
		{
			$tableLiaisonVolJour = new LiaisonVolJour();
			$requete = $tableLiaisonVolJour->select()
			->from($tableLiaisonVolJour)
			->where('liaisonVolJour.idVol=?', $ligne['idVol']);
			$lesLiaisons = $requete->query()->fetchAll();
			foreach($lesLiaisons as $uneLiaison)
			{
				$tableJour = new Jour;
				$requete2 = $tableJour->select()
								   	  ->from($tableJour)
									  ->where('jour.idJour=?', $uneLiaison['idJour']);
				$ligne = $requete2->query()->fetch();
				$ligne = $ligne['libelleJour'];
				
				if(isset($resultat))
				{
					$resultat = $resultat.', '.$ligne;
				}
				else
				{
					$resultat = $ligne;
				}
			}
			
			if(isset($resultat))
			{
				return $resultat;
			}
		}
		else
		{
			return $ligne['datePrevu'];
		}
	}
	public function getRecuperLesVolsAujourdHui($aujourdhui, $aeroport)
	{
		$requete = $this->select()
		->from($this)
		->where('datePrevu=?', $aujourdhui)
		->where('aeroportDepart=?', $aeroport)
		;
		return $requete->query()->fetchAll();
	}
	
	public function getRecuperUnVolAvecDateDepartArriveeEtNom($aujourdhui, $aeroportDepart, $aeroportArrivee, $nom)
	{
		$requete = $this->select()
		->from($this)
		->where('datePrevu=?', $aujourdhui)
		->where('aeroportDepart=?', $aeroportDepart)
		->where('aeroportArrivee=?', $aeroportArrivee)
		->where('numVol=?', $nom)
		;
		return $requete->query()->fetch();
	}
	
}
?>