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
	private int localisation;
	private int idAeroportDattache;
	private Context context;
	
	public Avion(Context context) {
		idAvion = 0;
		numImmatriculation = null;
		dateMisEnService = null;
		nombreHeureTotale = 0;
		nbHeureVolDepuisGrandeRevision = 0;
		nbHeureVolDepuisPetiteRevision = 0;
		statut = null;
		idModele = 0;
		localisation = 0;
		idAeroportDattache = 0;
		this.context = context;
	}
	
	public Avion(Context context, String numImmatriculation, String dateMisEnService, int idModele, int idAeroportDattache) {
		this.numImmatriculation = numImmatriculation;
		this.dateMisEnService = dateMisEnService;
		this.nombreHeureTotale = 0;
		this.nbHeureVolDepuisGrandeRevision = 0;
		this.nbHeureVolDepuisPetiteRevision = 0;
		this.statut = "disponible";
		this.idModele = idModele;
		this.localisation = idAeroportDattache;
		this.idAeroportDattache = idAeroportDattache;
		this.context = context;
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
		ioSeb.inputSeb(UrlScriptsPhp.urlAjouterAvion, handlerAjouterAvion, context);
	}
	
	 Handler handlerAjouterAvion = new Handler() {
		 public void handleMessage(Message msg) {
				if(msg.what == 1) {
					ToastSeb.toastSeb(context, "Avion Ajouté");
				}
				if(msg.what == 2) {
					ToastSeb.toastSeb(context, "erreur. l'avion n'est pas ajouté");
				}
			}
	 };

}
