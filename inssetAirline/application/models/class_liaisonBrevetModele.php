<?php
/*
 * Classe de liaison brevet, model par Nicolas
*/
class LiaisonBrevetModele extends Zend_Db_Table_Abstract
{
	protected $_name = 'liaisonBrevetModele';
	protected $_primary = array('idBrevet','idModele');
	
	protected $_referenceMap = array(
			'Brevet' => array(
					'colums' => 'idBrevet',
					'refTableClass' => 'Brevet'
					),
			'Modele' => array(
					'colums' => 'idModele',
					'refTableClass' => 'Modele'
			)
			);
}
?>