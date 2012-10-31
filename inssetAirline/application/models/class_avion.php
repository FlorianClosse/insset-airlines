<?php
/*
*	classe realisee par matthieu
*/
	class Avion extends Zend_Db_Table_Abstract
	{
		protected $_name='avion';
		protected $_primary=array('idAvion');
		
		protected $_referenceMap = array(
				'idModele' => array(
						'columns' => 'idModele',
						'refTableClass' =>'modele'));
		protected $_referenceMap = array(
				'idAeroportDattache' => array(
						'columns' => 'idAeroport',
						'refTableClass' =>'aeroport'));
		protected $_referenceMap = array(
				'localisation' => array(
						'columns' => 'idAeroport',
						'refTableClass' =>'aeroport'));
	}
?>