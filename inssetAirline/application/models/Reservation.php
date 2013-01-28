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
	
	public function getAeroportDepart($depart)
	{
		$requete = 	 'select *
					 from journalDeBord J, vol V, reservation R
					 where R.idJournal = J.idJournalDeBord
					 and J.idVol = V.idVol
					 and V.aeroportDepart =\''.$depart.'\';';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();
		//Zend_Debug::dump($datas) ;
		return $datas;
	}
	
	public function getAeroportArrivee($arrive)
	{
		$requete = 	 'select *
					 from journalDeBord J, vol V, reservation R
					 where R.idJournal = J.idJournalDeBord
					 and J.idVol = V.idVol
					 and V.aeroportArrivee =\''.$arrive.'\';';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();		
		return $datas;
	}
	
	public function getAeroportDepartArrivee($depart,$arrive)
	{
		$requete = 	 'select *
					 from journalDeBord J, vol V, reservation R
					 where R.idJournal = J.idJournalDeBord
					 and J.idVol = V.idVol
					 and V.aeroportDepart =\''.$depart.'\'
					 and V.aeroportArrivee =\''.$arrive.'\'
					 and statutReservation = "en attente";';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();				
		return $datas;
	}
	
	public function getLesAeroports()
	{
		$requete = 	 'select *
					 from journalDeBord J, vol V, reservation R
					 where R.idJournal = J.idJournalDeBord
					 and J.idVol = V.idVol;';
		$db = Zend_Db_Table::getDefaultAdapter();
		$datas = $db->query($requete)->fetchAll();
		//Zend_Debug::dump($datas) ;
		return $datas;
	}
}
?>
