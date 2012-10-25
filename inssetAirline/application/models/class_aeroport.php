<?php
class Aeroport extends Zend_Db_Table_Abstract
{
	protected $_name='aeroport';
	protected $_primary=array('idAeroport');
	
	protected $_referenceMap = array(
			'Ville' => array(
					'columns' => 'idVille',
					'refTableClass' =>'ville'));
}
?>