<?php
class Service extends Zend_Db_Table_Abstract
{
	protected $_name='service';
	protected $_primary=array('idService');
	
	public function selectOne($idService)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM service WHERE idService='.$idService;
		return $db->query($requete)->fetchAll();
	}
	
	public function selectAll()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM service ';
		return $db->query($requete)->fetchAll();
	}
}
?>