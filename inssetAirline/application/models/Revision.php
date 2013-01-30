<?php
class Revision extends Zend_Db_Table_Abstract
{
	protected $_name='revision';
	protected $_primary=array('idRevision');
	
	protected $_referenceMap = array(
			'idJournal'=>array(
					'columns'=>'idJournal',
					'refTableClass'=>'journalDeBord')
	);
	
	
	// fonction fait par Nicolas
	public function getRecupererSuivantAvion($avion)
	{
		$requete = $this->select()
		->from($this)
		->where('idAvion=?', $avion);
		return $requete->query()->fetchAll();
	}
	// fonction fait par Nicolas
	public function getRecuperRevisionDUnAvionAUneDateDonnee($avion, $date)
	{
		$requete = $this->select()
		->from($this)
		->where('idAvion=?', $avion)
		->where('datePrevue=?', $date);
		return $requete->query()->fetch();
	}
	
	public function isPlannifie($idAvion)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM revision WHERE idAvion='.$idAvion.' AND dateFin is null';
		return $db->query($requete)->fetchAll();
	}
	public function getRevisionPlannifiees()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM revision WHERE dateFin=\'NULL\' OR dateDebut=\'NULL\'';
		return $db->query($requete)->fetchAll();
	}
	public function selectOne($idRevision)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM revision WHERE idRevision='.$idRevision;
		return $db->query($requete)->fetchAll();
	}
}
?>
