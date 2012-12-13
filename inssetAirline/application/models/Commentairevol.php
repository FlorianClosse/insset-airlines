<?php
/*
*	classe realisee par matthieu
*/
	class Commentairevol extends Zend_Db_Table_Abstract
	{
		protected $_name='commentairevol';
		protected $_primary=array('idCommentaireVol');
		
		protected $_referenceMap = array(
				'idJournalDeBord' => array(
						'columns' => 'idJournalDeBord',
						'refTableClass' =>'journaldebord'));
	}
?>

