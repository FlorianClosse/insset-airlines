<?php
/*
 * Class ville
 */
class Ville
{
	private $selectAll;
	private $insertAll;
	private $selectOne;
	private $update;
	private $delete;
	
	public function __construct($db)
	{
		$this -> selectAll 	= $db -> prepare("SELECT idVille, nomVille, cpVille, idPays  FROM ville");
		$this -> insertAll 	= $db -> prepare("INSERT INTO ville (idVille, nomVille, cpVille, idPays) values (:idVille, :nomVille, :cpVille)");
		$this -> selectOne 	= $db -> prepare("SELECT idville, nomVille, cpVille, idPays FROM ville WHERE idVille = :idVille");
		$this -> update 	= $db -> prepare("UPDATE ville SET nomVille = :nomVille, cpVille = :cpVille, idPays = :idPays WHERE idVille = :idVille");
		$this -> delete		= $db -> prepare("DELETE FROM ville WHERE idVille = :idVille");
	}
	public function selectAll()
	{
		$this -> selectAll -> execute();
		return $this -> selectAll -> fetchAll();
	}
	public function insertAll($idVille, $nomVille, $cpVille, $idPays)
	{
		$this -> insertAll -> execute(array (':idVille' => $idVille, ':nomVille' => $nomVille, ':cpVille' => $cpVille, ':idPays' => $idPays));
		return $this -> insertAll -> rowCount();
	}
	public function selectOne($idVille)
	{
		$this -> selectOne -> execute(array(':idVille' => $idVille));
		return $this -> selectOne -> fetch();
	}
	public function update($idVille, $nomVille, $cpVille, $idPays)
	{
		$this ->update -> execute(array (':idVille' => $idVille, ':nomVille' => $nomVille, ':cpVille' => $cpVille, ':idPays' => $idPays));
		return $this -> update -> rowCount();
	}
	public function delete($idVille)
	{
		$this -> delete ->execute(array(':idVille' => $idVille));
		return $this -> delete -> rowCount();
	}
}
?>
