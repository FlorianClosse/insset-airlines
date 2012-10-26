<?php
class Vol extends Zend_Db_Table_Abstract
{
	protected $_name='vol';
	protected $_primary=array('idVol');


	protected $_referenceMap = array(
			'aeroportDepart'=>array(
					'columns'=>'idAeroport',
					'refTableClass'=>'aeroport'),
			'aeroportArrivee'=>array(
					'columns'=>'idAeroport',
					'refTableClass'=>'aeroport'),
			'idAvion'=>array(
					'columns'=>'idAvion',
					'refTableClass'=>'Avion'),
			'idDate'=>array(
					'columns'=>'idDate',
					'refTableClass'=>'dateVolAlaCarte'),
			'id_copilote'=>array(
					'columns'=>'id_pilote',
					'refTableClass'=>'Pilote')
	);
}
?>