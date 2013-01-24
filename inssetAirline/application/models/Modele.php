<?php
/*
 * Classe modele par Nicolas
*/
class Modele extends Zend_Db_Table_Abstract
{
	protected $_name = 'modele';
	protected $_primary = 'idModele';
	
	public function selectOne($idModele)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$requete = 'SELECT * FROM modele WHERE idModele='.$idModele;
		return $db->query($requete)->fetchAll();
	}
}
?>