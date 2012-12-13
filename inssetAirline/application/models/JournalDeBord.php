
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
	public function getRecuperLesVolsArriveAujourdHui($date)
	{
		$requete = $this->select()
		->from($this)
		->where('dateDepart=?', $date)
		->where('statut=?','en vol')
		;
		return $requete->query()->fetchAll();
	}
}
?>