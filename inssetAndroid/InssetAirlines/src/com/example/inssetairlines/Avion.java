package com.example.inssetairlines;

import seb.util.IoSeb;
import seb.util.ToastSeb;
import android.content.Context;
import android.os.Handler;
import android.os.Message;

public class Avion {
	private int idAvion;
	private String numImmatriculation;
	private String dateMisEnService;
	private int nombreHeureTotale;
	private int nbHeureVolDepuisGrandeRevision;
	private int nbHeureVolDepuisPetiteRevision;
	private String statut;
	private int idModele;
	private String nomModele;
	private int localisation;
	private String nomLocalisation;
	private int idAeroportDattache;
	private String nomAeroportDattache;
	private Context context;

	public Avion(Context context) {
		setIdAvion(0);
		numImmatriculation = null;
		dateMisEnService = null;
		setNombreHeureTotale(0);
		setNbHeureVolDepuisGrandeRevision(0);
		setNbHeureVolDepuisPetiteRevision(0);
		setStatut(null);
		idModele = 0;
		setLocalisation(0);
		idAeroportDattache = 0;
		this.context = context;
	}

	public Avion(Context context, String numImmatriculation,
			String dateMisEnService, int idModele, int idAeroportDattache) {
		this.numImmatriculation = numImmatriculation;
		this.dateMisEnService = dateMisEnService;
		this.setNombreHeureTotale(0);
		this.setNbHeureVolDepuisGrandeRevision(0);
		this.setNbHeureVolDepuisPetiteRevision(0);
		this.setStatut("disponible");
		this.idModele = idModele;
		this.setLocalisation(idAeroportDattache);
		this.idAeroportDattache = idAeroportDattache;
		this.context = context;
	}

	public Avion(String[] tabResultats) {
		this.idAvion = Integer.valueOf(tabResultats[0]);
		this.numImmatriculation = tabResultats[1];
		this.dateMisEnService = tabResultats[2];
		this.setNombreHeureTotale(Integer.valueOf(tabResultats[3]));
		this.setNbHeureVolDepuisGrandeRevision(Integer.valueOf(tabResultats[4]));
		this.setNbHeureVolDepuisPetiteRevision(Integer.valueOf(tabResultats[5]));
		this.setStatut(tabResultats[6]);
		this.nomModele = tabResultats[7];
		this.idModele = Integer.valueOf(tabResultats[8]);
		this.nomLocalisation = tabResultats[9];
		this.nomAeroportDattache = tabResultats[10];
		this.context = null;
	}

	public void setIdModele(int idModele) {
		this.idModele = idModele;
	}

	public void setIdAeroport(int idAeroport) {
		this.idAeroportDattache = idAeroport;
	}

	public void setNumImmatriculation(String numImmatriculation) {
		this.numImmatriculation = numImmatriculation;
	}

	public void setDateMisEnService(String dateMisEnService) {
		this.dateMisEnService = dateMisEnService;
	}

	public String getNumImmatriculation() {
		return numImmatriculation;
	}

	public int getIdModele() {
		return idModele;
	}

	public int getIdAeroport() {
		return idAeroportDattache;
	}

	public String getDateMisEnService() {
		return dateMisEnService;
	}

	public void ajouterAvion() {
		IoSeb ioSeb = new IoSeb();
		ioSeb.ajoutParam("numImmatriculation", numImmatriculation);
		ioSeb.ajoutParam("dateMisEnService", dateMisEnService);
		ioSeb.ajoutParam("idModele", String.valueOf(idModele));
		ioSeb.ajoutParam("idAeroport", String.valueOf(idAeroportDattache));
		ioSeb.inputSeb(UrlScriptsPhp.urlAjouterAvion, handlerAjouterAvion,
				context);
	}

	Handler handlerAjouterAvion = new Handler() {
		public void handleMessage(Message msg) {
			if (msg.what == 1) {
				ToastSeb.toastSeb(context, "Avion Ajouté");
			}
			if (msg.what == 2) {
				ToastSeb.toastSeb(context, "erreur. l'avion n'est pas ajouté");
			}
		}
	};

	Handler handlerAfficherAvion = new Handler() {
		public void handleMessage(Message msg) {

		}
	};

	public static void lireLigneAvionAvecId(Context context, Handler handler,
			int idAvion) { // detail d'un avion avec nom du modele, de
							// l'aeroport et de la localisation et détail des
							// revisions
		IoSeb ioSeb = new IoSeb();
		ioSeb.ajoutParam("nomTable", "avion");
		ioSeb.ajoutParam("id", String.valueOf(idAvion));
		ioSeb.outputSeb(UrlScriptsPhp.urlLireLigneCompleteAvecId, new String[] {
				"idAvion", "numImmatriculation", "dateMisEnService",
				"nombreHeureTotale", "nbHeureVolDepuisGrandeRevision",
				"nbHeureVolDepuisPetiteRevision", "statut", "nomModele", "idModele",
				"aeroL", "aeroA", "idRevision", "immatriculationAvion",
				"datePrevue", "dateDebut", "dateFin", "statutRevision" }, context, handler);
	}

	public int getIdAvion() {
		return idAvion;
	}

	public void setIdAvion(int idAvion) {
		this.idAvion = idAvion;
	}

	public int getNombreHeureTotale() {
		return nombreHeureTotale;
	}

	public void setNombreHeureTotale(int nombreHeureTotale) {
		this.nombreHeureTotale = nombreHeureTotale;
	}

	public int getNbHeureVolDepuisGrandeRevision() {
		return nbHeureVolDepuisGrandeRevision;
	}

	public void setNbHeureVolDepuisGrandeRevision(
			int nbHeureVolDepuisGrandeRevision) {
		this.nbHeureVolDepuisGrandeRevision = nbHeureVolDepuisGrandeRevision;
	}

	public int getNbHeureVolDepuisPetiteRevision() {
		return nbHeureVolDepuisPetiteRevision;
	}

	public void setNbHeureVolDepuisPetiteRevision(
			int nbHeureVolDepuisPetiteRevision) {
		this.nbHeureVolDepuisPetiteRevision = nbHeureVolDepuisPetiteRevision;
	}

	public String getStatut() {
		return statut;
	}

	public void setStatut(String statut) {
		this.statut = statut;
	}

	public int getLocalisation() {
		return localisation;
	}

	public void setLocalisation(int localisation) {
		this.localisation = localisation;
	}

	public String getNomModele() {
		return nomModele;
	}

	public void setNomModele(String nomModele) {
		this.nomModele = nomModele;
	}

	public String getNomLocalisation() {
		return nomLocalisation;
	}

	public void setNomLocalisation(String nomLocalisation) {
		this.nomLocalisation = nomLocalisation;
	}

	public String getNomAeroportDattache() {
		return nomAeroportDattache;
	}

	public void setNomAeroportDattache(String nomAeroportDattache) {
		this.nomAeroportDattache = nomAeroportDattache;
	}

}
