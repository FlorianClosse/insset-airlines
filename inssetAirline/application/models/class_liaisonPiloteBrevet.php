<?php
/*
 * Classe de liaison pilote, brevet par Nicolas
*/
class Pilote extends Zend_Db_Table_Abstract
{
	protected $_name = 'liaisonPiloteBrevet';
	protected $_primary = array('idPilote','idBrevet');
	
	protected $_referenceMap = array(
			'Brevet' => array(
					'colums' => 'idBrevet',
					'refTableClass' => 'Brevet'
					),
			'Pilote' => array(
					'colums' => 'idPilote',
					'refTableClass' => 'Pilote'
			)
			);
}
?>