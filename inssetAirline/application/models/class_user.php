<?php
class User extends Zend_Db_Table_Abstract
{
	protected $_name='user';
	protected $_primary=array('idUser');
	
	protected $_referenceMap = array(
			'idAeroport' => array(
					'columns' => 'idAeroport',
					'refTableClass' =>'aeroport'));
}
?>