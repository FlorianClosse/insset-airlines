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
	public function getRecuperRevisionDUnAvionAUneDateDonnee($avion, $date)
	{
		$requete = $this->select()
		->from($this)
		->where('idAvion=?', $avion)
		->where('datePrevue=?', $date);
		return $requete->query()->fetch();
	}
}
?>