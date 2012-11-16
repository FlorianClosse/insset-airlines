<?php
/*
 * Classe pilote par Nicolas
*/
class Pilote extends Zend_Db_Table_Abstract
{
	protected $_name = 'pilote';
	protected $_primary = 'idPilote';
	
	protected $_referenceMap = array(
			'Aeroport' => array(
					'colums' => 'idAeroportEmbauche',
					'refTableClass' => 'Aeroport'
					)
			);
}
?>