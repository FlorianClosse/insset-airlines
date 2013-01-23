<?php
class LiaisonVolJour extends Zend_Db_Table_Abstract
{
	protected $_name='liaisonVolJour';
	protected $_primary=array('idJour','idVol');
	
	protected $_referenceMap = array(
			'idVol'=>array(
					'columns'=>'idVol',
					'refTableClass'=>'vol'),
			'idJour'=>array(
					'columns'=>'idJour',
					'refTableClass'=>'jour')
	);
	
	public function getRecupererVolSuivantJour( $idJour)
	{
		$requete = $this->select()
		->from($this)
		->where('idJour=?', $idJour)
		;
		return $requete->query()->fetchAll();
	}
}

