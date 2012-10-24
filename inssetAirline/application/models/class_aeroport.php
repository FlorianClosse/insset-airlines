<?php
/*
 * Classe Aeroport by Pampril
*/
class Aeroport
{
	private $selectAll;
	private $insertAll;
	private $selectOne;
	private $update;
	private $delete;
	
	public function __construct($db)
	{
		$this -> selectAll 	= $db -> prepare("SELECT idAeroport, nomAeroport, trigramme, longueurPiste, idVille FROM pays");
		$this -> insertAll 	= $db -> prepare("INSERT INTO aeroport (idAeroport, nomAeroport, trigramme, longueurPiste, idVille) values (:idAeroport, :nomAeroport, :trigramme, :longueurPiste, :idVille)");
		$this -> selectOne 	= $db -> prepare("SELECT idAeroport, nomAeroport FROM aeroport WHERE idAeroport = :idAeroport");
		$this -> update 	= $db -> prepare("UPDATE pays SET nomAeroport = :nomAeroport, trigramme = :trigramme, longueurPiste = :longueurPiste, idVille = :idVille WHERE idAeroport = :idAeroport");
		$this -> delete		= $db -> prepare("DELETE FROM aeroport WHERE idAeroport = :idAeroport");
	}
	public function selectAll()
	{
		$this -> selectAll -> execute();
		return $this -> selectAll -> fetchAll();
	}
	public function insertAll($idAeroport, $nomAeroport, $trigramme, $longueurPiste, $idVille)
	{
		$this -> insertAll -> execute(array (':idAeroport' => $idAeroport, ':nomAeroport' => $nomAeroport, ':trigramme' => $trigramme, ':longueurPiste' => $longueurPiste, ':idVille' => $idVille));
		return $this -> insertAll -> rowCount();
	}
	public function selectOne($idAeroport)
	{
		$this -> selectOne -> execute(array(':idAeroport' => $idAeroport));
		return $this -> selectOne -> fetch();
	}
	public function update($idAeroport, $nomAeroport)
	{
		$this ->update -> execute(array (':idAeroport' => $idAeroport, ':nomAeroport' => $nomAeroport, ':trigramme' => $trigramme, ':longueurPiste' => $longueurPiste, ':idVille' => $idVille));
		return $this -> update -> rowCount();
	}
	public function delete($idAeroport)
	{
		$this -> delete ->execute(array(':idAeroport' => $idAeroport));
		return $this -> delete -> rowCount();
	}
}
?>
