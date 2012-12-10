
<?php
class Journaldebord extends Zend_Db_Table_Abstract
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
	
	// ***fonction getRecuperLesVolsAujourdHuiDeMonAeroport par Nicolas
	public function getRecuperLesVolsAujourdHuiDeMonAeroport($aeroportDepart)
	{
// 		$requete = $this->select()
// 		->from($this);
		
		
// 		->join(vol, 'journalDeBord.idVol = vol.idVol')
// 		->where('vol.aeroportDepart=?', $aeroportDepart);
		//return $requete->query()->fetchAll();
	}
}
?>