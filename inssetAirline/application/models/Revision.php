<?php
class Revision extends Zend_Db_Table_Abstract
{
	protected $_name='revision';
	protected $_primary=array('idRevision');
	
	protected $_referenceMap = array(
			'idJournal'=>array(
					'columns'=>'idJournal',
					'refTableClass'=>'journalDeBord')
	);
}
?>