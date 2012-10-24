<?php

  class Vol
  {
	private $selectAll;
	private $insertAll;
	private $selectMax;
	private $selectOne;
	private $update;
	private $delete;
	
	public function __construct($db)
	{
	  $this->selectAll=$db->prepare("SELECT idVol, numVol , periodicite , aeroportDepart , aeroportArrivee , idDate , dureeVol FROM vol");
	  $this->insertAll=$db->prepare("INSERT INTO vol (idVol, numVol , periodicite , aeroportDepart , aeroportArrivee , idDate , dureeVol)values(:idVol, :numVol , :periodicite , :aeroportDepart , :aeroportArrivee , :idDate , :dureeVol)");
	  $this->selectMax=$db->prepare("SELECT max(idVol) FROM vol");
	  $this->selectOne=$db->prepare("SELECT idVol, numVol , periodicite , aeroportDepart , aeroportArrivee , idDate , dureeVol FROM vol WHERE idVol=:idVol");
	  $this->update=$db->prepare("update vol set idVol=idVol, numVol=:numVol , periodicite=:periodicite , aeroportDepart=:aeroportDepart , aeroportArrivee=:aeroportArrivee , idDate=:idDate , dureeVol=:dureeVol WHERE idcommune=:idcommune");
	  $this->delete=$db->prepare("delete FROM vol WHERE idVol=:idVol");
	}
	
	// Fonction qui sélectionne tous les éléments de la table.
	public function selectAll()
	{
	  $this->selectAll->execute();
	  return $this-> selectAll-> fetchAll();
	}
	
	
	// Fonction qui permet d'insérer des nouvelles données dans la base de données.
	public function insertAll($idVol, $numVol , $periodicite , $aeroportDepart , $aeroportArrivee , $idDate , $dureeVol)
	{
		$this->insertAll->execute(array(':idVol'=>$idVol,':numVol'=>$numVol,':periodicite'=>$periodicite,':aeroportDepart'=>$aeroportDepart,':aeroportArrivee'=>$aeroportArrivee,':idDate'=>$idDate,':dureeVol'=>$dureeVol));
		return $this->insertAll->rowCount();
	}
	
	// Fonction qui permet de compter le nombre total d'id.
	public function selectMax()
	{
		$this->selectMax->execute();
		return $this->selectMax->fetch();
	}
	
	// Fonction qui sélectionne l'id du vol.
	public function selectOne($idVol)
	{
		$this->selectOne->execute(array(':idVol'=>$idVol));
		return $this->selectOne->fetch();
	}
	
	// Fonction qui permet de mettre à jour des champs de la table vol
	public function update($idVol, $numVol , $periodicite , $aeroportDepart , $aeroportArrivee , $idDate , $dureeVol)
	{
		$this->update->execute(array(':idVol'=>$idVol,':numVol'=>$numVol,':periodicite'=>$periodicite,':aeroportDepart'=>$aeroportDepart,':aeroportArrivee'=>$aeroportArrivee,':idDate'=>$idDate,':dureeVol'=>$dureeVol));
		return $this->update->rowCount();
	}
	
	// Fonction qui permet de supprimer des champs de la table vol
	public function delete($idVol)
	{
		$this->delete->execute(array(':idVol'=>$idVol));
		return $this->delete->rowCount();
	}
  }
?>
