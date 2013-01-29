<?php
class User extends Zend_Db_Table_Abstract
{
	protected $_name='user';
	protected $_primary=array('idUser');
	
	protected $_referenceMap = array(
			'idAeroport' => array(
					'columns' => 'idAeroport',
					'refTableClass' =>'aeroport'));
	
	/*protected $_referenceMap = array(
			'service' => array(
					'columns' => 'idService',
					'refTableClass' =>'service'));*/
	
	public function selectOne($idUser)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM user WHERE idUser='.$idUser;
		return $db->query($requete)->fetchAll();
	}
	
	public function selectAll()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM user ';
		return $db->query($requete)->fetchAll();
	}
}
?>