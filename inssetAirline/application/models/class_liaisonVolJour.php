<?php
class JournalDeBord extends Zend_Db_Table_Abstract
{
	protected $_name='liaisonVolJour';
	protected $_primary=array('idJour','idVol');
}
