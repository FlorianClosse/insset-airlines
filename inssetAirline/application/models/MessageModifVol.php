<?php
/*
*	classe realisee par matthieu
*/
	class MessageModifVol extends Zend_Db_Table_Abstract
	{
		protected $_name='messageModifVol';
		protected $_primary=array('idMessage');
		
		protected $_referenceMap = array(
				'idAeroport' => array(
						'columns' => 'idAeroport',
						'refTableClass' =>'aeroport'));
	}
?>