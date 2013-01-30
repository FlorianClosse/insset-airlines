
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
	
	public function getRecupererCoPilote($idPilote)
	{
		$requete = 	 'select *
		from journalDeBord
		where idCoPilote = '.$idPilote;
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetchAll();
		return $donnees;
	}
	public function getRecupererLieuCoPiloteAvecDate($idPilote, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart < "'.$date.'"
		and idCoPilote = "'.$idPilote.'"
		ORDER BY dateDepart DESC
		LIMIT 1';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetch();
		return $donnees;
	}
	public function getRecupererCoPiloteAstreinte($idPilote, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart > "'.$date.'"
		and idCoPilote = "'.$idPilote.'"
		ORDER BY dateDepart DESC
		LIMIT 1';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetch();
		return $donnees;
	}
	public function getRecupererCoPiloteAModifier($idPilote, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart > "'.$date.'"
		and idCoPilote = "'.$idPilote.'"';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetchAll();
		return $donnees;
	}
	
	public function getRecupererPilote($idPilote)
	{
		$requete = 	 'select *
		from journalDeBord
		where idPilote = '.$idPilote;
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetchAll();
		return $donnees;
	}
	public function getRecupererLieuPiloteAvecDate($idPilote, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart < "'.$date.'"
		and idPilote = "'.$idPilote.'"
		ORDER BY dateDepart DESC
		LIMIT 1';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetch();
		return $donnees;
	}
	public function getRecupererPiloteAstreinte($idPilote, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart > "'.$date.'"
		and idPilote = "'.$idPilote.'"
		ORDER BY dateDepart DESC
		LIMIT 1';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetch();
		return $donnees;
	}
	public function getRecupererPiloteAModifier($idPilote, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart > "'.$date.'"
		and idPilote = "'.$idPilote.'"';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetchAll();
		return $donnees;
	}
	
	
	
	public function getRecupererAvion($idAvion)
	{
		$requete = 	 'select *
		from journalDeBord
		where idAvion = '.$idAvion;
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetchAll();
		return $donnees;
	}
	public function getRecupererLieuAvionAvecDate($idAvion, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart < "'.$date.'"
		and idAvion = "'.$idAvion.'"
		ORDER BY dateDepart DESC
		LIMIT 1';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetch();
		return $donnees;
	}
	public function getRecupererAvionAstreinte($idAvion, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart > "'.$date.'"
		and idAvion = "'.$idAvion.'"
		ORDER BY dateDepart DESC
		LIMIT 1';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetch();
		return $donnees;
	}
	public function getRecupererAvionAModifier($idAvion, $date)
	{
		$requete = 	 'select *
		from journalDeBord
		where dateDepart > "'.$date.'"
		and idAvion = "'.$idAvion.'"';
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->fetchAll();
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
	
	
	public function getSupprimer($id)
	{
		$requete = 	'delete from journalDeBord
		where idJournalDeBord = '.$id;
		$db = Zend_Db_Table::getDefaultAdapter();
		$donnees = $db->query($requete)->rowCount();
		return $donnees;
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
