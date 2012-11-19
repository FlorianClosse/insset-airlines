<?php
class Reservation extends Zend_Db_Table_Abstract
{
	protected $_name='reservation';
	protected $_primary=array('idReservation');
	
	protected $_referenceMap = array(
			'idJournal'=>array(
					'columns'=>'idJournal',
					'refTableClass'=>'journalDeBord')
	);
}
?>
