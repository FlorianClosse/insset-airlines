<?php
/*
 * Classe brevet par Nicolas
*/
class Brevet extends Zend_Db_Table_Abstract
{
	protected $_name = 'brevet';
	protected $_primary = 'idBrevet';
	
	public function selectOne($idBrevet)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM brevet WHERE idBrevet='.$idBrevet;
		return $db->query($requete)->fetchAll();
	}
	
	public function selectAll()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM brevet ';
		return $db->query($requete)->fetchAll();
	}
}
?>
