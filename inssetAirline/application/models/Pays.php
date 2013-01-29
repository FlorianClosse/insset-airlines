<?php
class Pays extends Zend_Db_Table_Abstract
{
	protected $_name='pays';
	protected $_primary=array('idPays');
	
	public function selectOne($idPays)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM pays WHERE idPays='.$idPays;
		return $db->query($requete)->fetchAll();
	}
	
	public function selectAll()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM pays ';
		return $db->query($requete)->fetchAll();
	}
}
?>