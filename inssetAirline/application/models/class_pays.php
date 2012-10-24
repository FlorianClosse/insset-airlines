<?php
/*
* Classe Pays by Pampril
*/
class Pays
{
	private $selectAll;
	private $insertAll;
	private $selectOne;
	private $update;
	private $delete;
	
	public function __construct($db)
	{
		$this -> selectAll 	= $db -> prepare("SELECT idPays, nomPays FROM pays");
		$this -> insertAll 	= $db -> prepare("INSERT INTO pays (idPays, nomPays) values (:idPays, :nomPays)");
		$this -> selectOne 	= $db -> prepare("SELECT idPays, nomPays FROM pays WHERE idPays = :idPays");
		$this -> update 	= $db -> prepare("UPDATE pays SET nomPays = :nomPays WHERE idPays = :idPays");
		$this -> delete		= $db -> prepare("DELETE FROM pays WHERE idPays = :idPays");
	}
	public function selectAll()
	{
		$this -> selectAll -> execute();
		return $this -> selectAll -> fetchAll();
	}
	public function insertAll($idPays, $nomPays)
	{
		$this -> insertAll -> execute(array (':idpays' => $idPays, ':nomPays' => $nomPays));
		return $this -> insertAll -> rowCount();
	}
	public function selectOne($idPays)
	{
		$this -> selectOne -> execute(array(':idPays' => $idPays));
		return $this -> selectOne -> fetch();
	}
	public function update($idPays, $nomPays)
	{
		$this ->update -> execute(array (':idPays' => $idPays, ':nomPays' => $nomPays));
		return $this -> update -> rowCount();
	}
	public function delete($idPays)
	{
		$this -> delete ->execute(array(':idPays' => $idPays));
		return $this -> delete -> rowCount();
	}
}
?>
