<?php
class Ville extends Zend_Db_Table_Abstract
{
	protected $_name='ville';
	protected $_primary=array('idVille');
	
	protected $_referenceMap = array(
			'idPays' => array(
					'columns' => 'idPays',
					'refTableClass' =>'pays'));
	
	public function selectOne($idVille)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM ville WHERE idVille='.$idVille;
		return $db->query($requete)->fetchAll();
	}
	
	public function selectAll()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM ville ';
		return $db->query($requete)->fetchAll();
	}
}
?>