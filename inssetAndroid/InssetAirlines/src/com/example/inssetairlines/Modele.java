package com.example.inssetairlines;

import seb.util.IoSeb;
import seb.util.ToastSeb;
import android.content.Context;
import android.os.Handler;
import android.os.Message;

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
		setIdModele(0);
		setNomModele(null);
		setLongueurPiste(0);
		setRayonDaction(0);
		setNbPlace(0);
		setPeriodeGrandeRevision(0);
		setPeriodePetiteRevision(0);
		this.context = context;
	}

	public Modele(Context context, String nomModele, int longueurPiste,
			int rayonDaction, int nbPlace, int periodeGrandeRevision,
			int periodePetiteRevision) {
		this.setNomModele(nomModele);
		this.setLongueurPiste(longueurPiste);
		this.setRayonDaction(rayonDaction);
		this.setNbPlace(nbPlace);
		this.setPeriodeGrandeRevision(periodeGrandeRevision);
		this.setPeriodePetiteRevision(periodePetiteRevision);
		this.context = context;
	}

	public Modele(String[] resultat) {
		this.setIdModele(Integer.valueOf(resultat[0]));
		this.setNomModele(resultat[1]);
		this.setLongueurPiste(Integer.valueOf(resultat[2]));
		this.setRayonDaction(Integer.valueOf(resultat[3]));
		this.setNbPlace(Integer.valueOf(resultat[4]));
		this.setPeriodePetiteRevision(Integer.valueOf(resultat[5]));
		this.setPeriodeGrandeRevision(Integer.valueOf(resultat[6]));
		this.context = null;
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
		ioSeb.ajoutParam("periodeGrandeRevision",
				String.valueOf(periodeGrandeRevision));
		ioSeb.ajoutParam("periodePetiteRevision",
				String.valueOf(periodePetiteRevision));

		ioSeb.inputSeb(UrlScriptsPhp.urlAjouterModele, handlerAjouterModele,
				context);
	}

	public int getIdModele() {
		return idModele;
	}

	public void setIdModele(int idModele) {
		this.idModele = idModele;
	}

	Handler handlerAjouterModele = new Handler() {
		public void handleMessage(Message msg) {
			if (msg.what == 1) {
				ToastSeb.toastSeb(context, "Modèle ajouté");
			}
			if (msg.what == 2) {
				ToastSeb.toastSeb(context, "erreur. modèle non ajouté");
			}
		}
	};

	public static void lireLigneModeleAvecId(int idModele, Context context,
			Handler handlerLireLigneModeleAvecId) {
		IoSeb ioSeb = new IoSeb();
		ioSeb.ajoutParam("nomTable", "modele");
		ioSeb.ajoutParam("id", String.valueOf(idModele));
		ioSeb.outputSeb(UrlScriptsPhp.urlLireLigneCompleteAvecId, new String[] {
				"idModele", "nomModele", "longueurPiste", "rayonDaction",
				"nbPlace", "periodePetiteRevision", "periodeGrandeRevision" },
				context, handlerLireLigneModeleAvecId);
	}

}
