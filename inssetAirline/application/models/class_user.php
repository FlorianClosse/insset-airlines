<?php
/*
 * Classe User by Pampril
*/
class User
{
	private $selectAll;
	private $insertAll;
	private $selectOne;
	private $update;
	private $delete;
	
	public function __construct($db)
	{
		$this -> selectAll 	= $db -> prepare("SELECT idUser, nomUser, prenomUser, email, motDePasse, dateNaissance, service idAeroport FROM user");
		$this -> insertAll 	= $db -> prepare("INSERT INTO user (idUser, nomUser, prenomUser, email, motDePasse, dateNaissance, service, idAeroport) values (:idUser, :nomUser, :prenomUser, :email, :motDePasse, :dateNaissance, :service, :idAeroport)");
		$this -> selectOne 	= $db -> prepare("SELECT idUser, nomUser FROM user WHERE idUser = :idUser");
		$this -> update 	= $db -> prepare("UPDATE user SET nomUser = :nomUser, prenomUser = :prenomUser, email = :email, motDePasse = :motDePasse, dateNaissance = :dateNaissance, service = :service, idAeroport = :idAeroport");
		$this -> delete		= $db -> prepare("DELETE FROM user WHERE idUser = :idUser");
	}
	public function selectAll()
	{
		$this -> selectAll -> execute();
		return $this -> selectAll -> fetchAll();
	}
	public function insertAll($idUser, $nomUser, $prenomUser, $email, $motDePasse, $dateNaissance, $service, $idAeroport)
	{
		$this -> insertAll -> execute(array (':idUser' => $idUser, ':nomUser' => $nomUser, ':prenomUser' => $prenomUser, ':email' => $email, ':motDePasse' => $motDePasse, ':dateNaissance' => $dateNaissance, ':service' => $service, ':idAeroport' => $idAeroport));
		return $this -> insertAll -> rowCount();
	}
	public function selectOne($idUser)
	{
		$this -> selectOne -> execute(array(':idUser' => $idUser));
		return $this -> selectOne -> fetch();
	}
	public function update($idUser, $nomUser, $prenomUser, $email, $motDePasse, $dateNaissance, $service, $idAeroport )
	{
		$this ->update -> execute(array (':idUser' => $idUser, ':nomUser' => $nomUser, ':prenomUser' => $prenomUser, ':email' => $email, ':motDePasse' => $motDePasse, ':dateNaissance' => $dateNaissance, ':service' => $service, ':idAeroport' => $idAeroport));
		return $this -> update -> rowCount();
	}
	public function delete($idUser)
	{
		$this -> delete ->execute(array(':idUser' => $idUser));
		return $this -> delete -> rowCount();
	}
}
?>
