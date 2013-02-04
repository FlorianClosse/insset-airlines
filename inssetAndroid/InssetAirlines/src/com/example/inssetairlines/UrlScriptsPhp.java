package com.example.inssetairlines;

public class UrlScriptsPhp {

	//public static String urlScriptsPhp = "http://moicseb.alwaysdata.net/AndroidAirlinesPhpOnline/"; //pour la bdd online
	//public static String urlScriptsPhp = "http://192.168.1.10/AndroidAirlinesPhp/"; //si par wifi via livebox pour bdd locale
	//public static String urlScriptsPhp = "http://192.168.43.201/AndroidAirlinesPhp/"; //si par point acces wifi sur archos pour bdd locale
	//public static String urlScriptsPhp = "http://10.0.2.2/AndroidAirlinesPhp/"; //si sur emulateur et bdd locale
	public static String urlScriptsPhp = "http://moicseb.alwaysdata.net/AndroidAirlinesPhpOnline/";
	public static String urlLireListe_id_nom = urlScriptsPhp
			+ "LireListe_id_nom.php";
	public static String urlAjouterAvion = urlScriptsPhp + "AjouterAvion.php";
	public static String urlAjouterModele = urlScriptsPhp + "AjouterModele.php";
	public static String urlLireLigneCompleteAvecId = urlScriptsPhp
			+ "LireLigneCompleteAvecId.php";
	public static String urlLireCommentairesAvion = urlScriptsPhp
			+ "lireCommentairesAvion.php";
	public static String urlLireListeAvionsEnRevision = urlScriptsPhp
			+ "LireListeAvionsEnRevision.php";
	public static String urlLireListeOperations = urlScriptsPhp
			+ "LireListeOperations.php";
	public static String urlValiderOperation = urlScriptsPhp
			+ "ValiderOperation.php";
	public static String urlLireListeAvionsAenvoyerEnRevision = urlScriptsPhp
			+ "LireListeAvionsAenvoyerEnRevision.php";
	public static String urlValiderDateRevisionPrevue = urlScriptsPhp
			+ "ValiderDateRevisionPrevue.php";
	public static String urlLireListeRevisionsAvalider = urlScriptsPhp
			+ "LireListeRevisionsAvalider.php";
	public static String urlValiderRevision = urlScriptsPhp
			+ "ValiderRevision.php";
	public static String urlLireListeRevisionsAterminer = urlScriptsPhp
			+ "LireListeRevisionsAterminer.php";
	public static String urlTerminerRevisionChoisie = urlScriptsPhp
			+ "TerminerRevisionChoisie.php";
	public static String urlLireValiderIdEtServiceUser = urlScriptsPhp
			+ "LireValiderIdEtServiceUser.php";
	/*
	 * Pour bdd en ligne, les fichiers php sont sur un serveur sur
	 * alwaysdata.com via un site perso: adresse du site perso:
	 * http://moicseb.alwaysdata.net. serveur ftp pour envoyer les fichiers sur
	 * le site: ftp.alwaysdata.com(login=moicseb et mot de passe=android02).
	 * acces administration: nom=moicseb et mot de passe=android02.
	 * email=sebaloche02@gmail.com. La base est stockée sur un serveur sur
	 * www.db4free.net: nom de la bdd: airlines nom utilisateur: android02 mot
	 * de passe: android host name: db4free.net port: 3306
	 */
}