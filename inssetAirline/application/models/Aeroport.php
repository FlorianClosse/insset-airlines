<?php
class Aeroport extends Zend_Db_Table_Abstract
{
	protected $_name='aeroport';
	protected $_primary=array('idAeroport');
	
	protected $_referenceMap = array(
			'idVille' => array(
					'columns' => 'idVille',
					'refTableClass' =>'ville'));
	
	public function selectOne($idAeroport)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM aeroport WHERE idAeroport='.$idAeroport;
		return $db->query($requete)->fetchAll();
	}
	
	public function selectAll()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM aeroport ';
		return $db->query($requete)->fetchAll();
	}
}
?>