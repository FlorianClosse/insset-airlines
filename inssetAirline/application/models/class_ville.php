<?php
class Ville extends Zend_Db_Table_Abstract
{
	protected $_name='ville';
	protected $_primary=array('idVille');
	
	protected $_referenceMap = array(
			'idPays' => array(
					'columns' => 'idPays',
					'refTableClass' =>'pays'));
}
?>