<?php
/*
 * Classe de liaison brevet, model par Nicolas
*/
class LiaisonBrevetModele extends Zend_Db_Table_Abstract
{
	protected $_name = 'liaisonBrevetModele';
	protected $_primary = array('idBrevet','idModele');
	
	protected $_referenceMap = array(
			'Brevet' => array(
					'colums' => 'idBrevet',
					'refTableClass' => 'Brevet'
					),
			'Modele' => array(
					'colums' => 'idModele',
					'refTableClass' => 'Modele'
			)
			);
	
	public function selectAllByBrevet($idBrevet)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM liaisonPiloteBrevet WHERE idBrevet='.$idBrevet;
		return $db->query($requete)->fetchAll();
	}
	
	public function delete($idBrevet,$idModele)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'delete FROM liaisonPiloteBrevet WHERE idBrevet='.$idBrevet.'AND idModele='.$idModele;
		return $db->query($requete)->rowCount();
	}
}
?>