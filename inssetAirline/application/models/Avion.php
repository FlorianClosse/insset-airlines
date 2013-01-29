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
// 		protected $_referenceMap = array(
// 				'idAeroportDattache' => array(
// 						'columns' => 'idAeroport',
// 						'refTableClass' =>'aeroport'));
// 		protected $_referenceMap = array(
// 				'localisation' => array(
// 						'columns' => 'idAeroport',
// 						'refTableClass' =>'aeroport'));
		
		public function selectAll()
		{
			$db = Zend_Db_Table::getDefaultAdapter();
			$requete = 'SELECT * FROM avion';
			return $db->query($requete)->fetchAll();
		}
		
		public function selectOne($idAvion)
		{
			$db = Zend_Db_Table::getDefaultAdapter();
			$requete = 'SELECT * FROM avion WHERE idAvion='.$idAvion;
			return $db->query($requete)->fetchAll();
		}
		
		public function selectFiltreUn($champ,$valeur)
		{
			$db = Zend_Db_Table::getDefaultAdapter();
			$requete = 'SELECT * FROM avion WHERE '.$champ.'='.$valeur;
			return $db->query($requete)->fetchAll();
		}
		
		public function selectFiltreDeux($champ,$valeur,$champDeux,$valeurDeux)
		{
			$db = Zend_Db_Table::getDefaultAdapter();
			$requete = 'SELECT * FROM avion WHERE '.$champ.'='.$valeur.' AND '.$champDeux.'='.$valeurDeux;
			return $db->query($requete)->fetchAll();
		}
		
		public function selectFiltreTrois($champ,$valeur,$champDeux,$valeurDeux,$champTrois,$valeurTrois)
		{
			$db = Zend_Db_Table::getDefaultAdapter();
			$requete = 'SELECT * FROM avion WHERE '.$champ.'='.$valeur.' AND '.$champDeux.'='.$valeurDeux.' AND '.$champTrois.'='.$valeurTrois;
			return $db->query($requete)->fetchAll();
		}
		
		public function selectFiltreQuatre($champ,$valeur,$champDeux,$valeurDeux,$champTrois,$valeurTrois,$champQuatre,$valeurQuatre)
		{
			$db = Zend_Db_Table::getDefaultAdapter();
			$requete = 'SELECT * FROM avion WHERE '.$champ.'='.$valeur.' AND '.$champDeux.'='.$valeurDeux.' AND '.$champTrois.'='.$valeurTrois.' AND '.$champQuatre.'='.$valeurQuatre;
			return $db->query($requete)->fetchAll();
		}
	}
?>