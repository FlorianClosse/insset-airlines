
<?php
class JournalDeBord extends Zend_Db_Table_Abstract
{
	protected $_name='journalDeBord';
	protected $_primary=array('idJournalDeBord');
	
	protected $_referenceMap = array(
			'idPilote'=>array(
					'columns'=>'idPilote',
					'refTableClass'=>'pilote'),
			'idCoPilote'=>array(
					'columns'=>'idPilote',
					'refTableClass'=>'pilote'),
			'idAvion'=>array(
					'columns'=>'idAvion',
					'refTableClass'=>'avion'),
			'idVol'=>array(
					'columns'=>'idVol',
					'refTableClass'=>'vol')
	);
	
	public function getRecupererLieuAvion($idAvion)
	{
		$requete = 	 'select *
		from journalDeBord
		where idAvion = '.$idAvion.'
		ORDER BY idJournalDeBord DESC
		LIMIT 1';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetch();
		return $donnees;
	}
	
	
	
	public function getRecupererSuivantDateEtVol($aujourdhui, $idVol)
	{
		$requete = $this->select()
		->from($this)
		->where('dateDepart=?', $aujourdhui)
		->where('idVol=?',$idVol)
		;
		return $requete->query()->fetch();
	}
	// ***fonction getRecuperLesVolsDepartAujourdHui par Nicolas
	public function getRecuperLesVolsDepartAujourdHui($date)
	{
		$requete = $this->select()
		->from($this)
		->where('dateDepart=?', $date)
		->where('statut=?','attente')
		;
		return $requete->query()->fetchAll();
	}
	
	// ***fonction getRecuperLesVolsArriveAujourdHui par Nicolas
	public function getRecuperLesVolsArriveeAujourdHui($date)
	{
		$requete = $this->select()
		->from($this)
		->where('dateDepart=?', $date)
		->where('statut=?','en vol')
		;
		return $requete->query()->fetchAll();
	}
	
	//par nicolas
	public function getRecuperLesVolsAujourdHui($date)
	{
		$requete = $this->select()
		->from($this)
		->where('dateDepart=?', $date)
		;
		return $requete->query()->fetchAll();
	}
	
	//fonction qui permet de recuper les numero de vol
	public function getNumeroVol()
	{		
		$requete = 	 'select numVol
					 from journalDeBord J, vol V
					 where J.idVol = V.idVol;';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();		
		return $datas;
	}
	
	public function getVolEnCour()
	{
		$requete = 'select *
					 from journalDeBord J, vol V
					 where J.idVol = V.idVol
					 and J.statut = "en vol";';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();
		
		return $datas;
	}
	
	public function getAeroportDepart($depart)
	{
		$requete = 	 'select *
					 from journalDeBord J, vol V					
					 where J.idVol = V.idVol
					 and V.aeroportDepart =\''.$depart.'\'
					 and J.statut = "en vol";';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();		
		return $datas;
	}
	
	public function getAeroportDepartArrivee($depart,$arrive)
	{
		$requete = 	 'select *
					 from journalDeBord J, vol V					 
					 where J.idVol = V.idVol
					 and V.aeroportDepart =\''.$depart.'\'
					 and V.aeroportArrivee =\''.$arrive.'\'
					 and J.statut = "en vol";';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();
		return $datas;
	}
	
	public function getAeroportArrivee($arrive)
	{
		$requete = 	 'select *
					 from journalDeBord J, vol V,					 
					 where J.idVol = V.idVol
					 and V.aeroportArrivee =\''.$arrive.'\'
					 and J.statut = "en vol";';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();
		return $datas;
	}
	
	public function getVol($date,$aeroportDepart,$aeroportArrivee)
	{
		$requete = 'select *
					from journalDeBord J, vol V
					where J.idVol = V.idVol
					and J.dateDepart =\''.$date.'\'
					and V.aeroportDepart =\''.$aeroportDepart.'\'
					and V.aeroportArrivee =\''.$aeroportArrivee.'\';';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();
		//Zend_Debug::dump($datas) ;
		return $datas;
	}

}
?>