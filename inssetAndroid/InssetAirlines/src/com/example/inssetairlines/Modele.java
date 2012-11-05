package com.example.inssetairlines;

import android.content.Context;
import android.os.Handler;
import android.os.Message;
import seb.util.IoSeb;
import seb.util.ToastSeb;

public class Modele {
	private int idModele;
	private String nomModele;
	private int longueurPiste;
	private int rayonDaction;
	private int nbPlace;
	private int periodeGrandeRevision;
	private int periodePetiteRevision;
	private Context context;
	
	public Modele(Context context) {
		idModele = 0;
		setNomModele(null);
		setLongueurPiste(0);
		setRayonDaction(0);
		setNbPlace(0);
		setPeriodeGrandeRevision(0);
		setPeriodePetiteRevision(0);
		this.context = context;
	}
	
	public Modele(Context context,String nomModele, int longueurPiste, int rayonDaction, int nbPlace, int periodeGrandeRevision, int periodePetiteRevision) {
		this.setNomModele(nomModele);
		this.setLongueurPiste(longueurPiste);
		this.setRayonDaction(rayonDaction);
		this.setNbPlace(nbPlace);
		this.setPeriodeGrandeRevision(periodeGrandeRevision);
		this.setPeriodePetiteRevision(periodePetiteRevision);
		this.context = context;
	}

	public String getNomModele() {
		return nomModele;
	}

	public void setNomModele(String nomModele) {
		this.nomModele = nomModele;
	}

	public int getLongueurPiste() {
		return longueurPiste;
	}

	public void setLongueurPiste(int longueurPiste) {
		this.longueurPiste = longueurPiste;
	}

	public int getRayonDaction() {
		return rayonDaction;
	}

	public void setRayonDaction(int rayonDaction) {
		this.rayonDaction = rayonDaction;
	}

	public int getPeriodeGrandeRevision() {
		return periodeGrandeRevision;
	}

	public void setPeriodeGrandeRevision(int periodeGrandeRevision) {
		this.periodeGrandeRevision = periodeGrandeRevision;
	}

	public int getPeriodePetiteRevision() {
		return periodePetiteRevision;
	}

	public void setPeriodePetiteRevision(int periodePetiteRevision) {
		this.periodePetiteRevision = periodePetiteRevision;
	}

	public int getNbPlace() {
		return nbPlace;
	}

	public void setNbPlace(int nbPlace) {
		this.nbPlace = nbPlace;
	}
	
	public void ajouterModele() {
		IoSeb ioSeb = new IoSeb();
		ioSeb.ajoutParam("nomModele", nomModele);
		ioSeb.ajoutParam("longueurPiste", String.valueOf(longueurPiste));
		ioSeb.ajoutParam("rayonDaction", String.valueOf(rayonDaction));
		ioSeb.ajoutParam("nbPlace", String.valueOf(nbPlace));
		ioSeb.ajoutParam("periodeGrandeRevision", String.valueOf(periodeGrandeRevision));
		ioSeb.ajoutParam("periodePetiteRevision", String.valueOf(periodePetiteRevision));
		
		ioSeb.inputSeb(UrlScriptsPhp.urlAjouterModele, handlerAjouterModele, context);
	}
	
	Handler handlerAjouterModele = new Handler() {
		 public void handleMessage(Message msg) {
			 if(msg.what == 1) {
				 ToastSeb.toastSeb(context, "Modèle ajouté");
			 }
			 if(msg.what ==2) {
				 ToastSeb.toastSeb(context, "erreur. modèle non ajouté");
			 }
		 }
	};

}
