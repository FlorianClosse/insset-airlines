<?php
/*
 * Classe de liaison pilote, brevet par Nicolas
*/
class LiaisonPiloteBrevet extends Zend_Db_Table_Abstract
{
	protected $_name = 'liaisonPiloteBrevet';
	protected $_primary = array('idPilote','idBrevet');
	
	protected $_referenceMap = array(
			'Brevet' => array(
					'colums' => 'idBrevet',
					'refTableClass' => 'Brevet'
					),
			'Pilote' => array(
					'colums' => 'idPilote',
					'refTableClass' => 'Pilote'
			)
			);
	
	public function selectAll($idBrevet)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM liaisonPiloteBrevet WHERE idBrevet='.$idBrevet;
		return $db->query($requete)->fetchAll();
	}
	
	public function delete($idPilote)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'delete FROM liaisonPiloteBrevet WHERE idPilote='.$idPilote;
		return $db->query($requete)->rowCount();
	}
}
?>