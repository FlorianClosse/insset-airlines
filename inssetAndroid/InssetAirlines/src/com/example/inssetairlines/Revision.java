package com.example.inssetairlines;

public class Revision {

	int idRevision;
	String immatriculationAvion;
	String datePrevue;
	String dateDebut;
	String dateFin;
	String commentaire;
	String statutRevision;
	int idAvion;
	
	public Revision() {
		this.immatriculationAvion = null;
		this.datePrevue = null;
		this.dateDebut = null;
		this.dateFin = null;
		this.commentaire = null;
		this.statutRevision = null;
		this.idAvion = 0;
	}
	
	public Revision(String immatriculationAvion, String datePrevue,
			String dateDebut, String dateFin, String commentaire,
			String statutRevision, int idAvion) {
		super();
		this.immatriculationAvion = immatriculationAvion;
		this.datePrevue = datePrevue;
		this.dateDebut = dateDebut;
		this.dateFin = dateFin;
		this.commentaire = commentaire;
		this.statutRevision = statutRevision;
		this.idAvion = idAvion;
	}

	public Revision(String[] tabResultats, String[] nomColonnes) {
		this.immatriculationAvion = null;
		this.datePrevue = null;
		this.dateDebut = null;
		this.dateFin = null;
		this.commentaire = null;
		this.statutRevision = null;
		this.idAvion = 0;
		for(int i = 0; i < tabResultats.length; i++) {
			if(nomColonnes[i].contentEquals("idRevision")) {
				setIdRevision(Integer.valueOf(tabResultats[i]));
			}
			if(nomColonnes[i].contentEquals("immatriculationAvion")) {
				setImmatriculationAvion(tabResultats[i]);
			}
			if(nomColonnes[i].contentEquals("datePrevue")) {
				setDatePrevue(tabResultats[i]);
			}
			if(nomColonnes[i].contentEquals("dateDebut")) {
				setDateDebut(tabResultats[i]);
			}
			if(nomColonnes[i].contentEquals("dateFin")) {
				setDateFin(tabResultats[i]);
			}
			if(nomColonnes[i].contentEquals("commentaire")) {
				setCommentaire(tabResultats[i]);
			}
			if(nomColonnes[i].contentEquals("statutRevision")) {
				setStatutRevision(tabResultats[i]);
			}
			if(nomColonnes[i].contentEquals("idAvion")) {
				setIdAvion(Integer.valueOf(tabResultats[i]));
			}
		}
	}
	
	public int getIdRevision() {
		return idRevision;
	}

	public void setIdRevision(int idRevision) {
		this.idRevision = idRevision;
	}

	public String getImmatriculationAvion() {
		return immatriculationAvion;
	}

	public void setImmatriculationAvion(String immatriculationAvion) {
		this.immatriculationAvion = immatriculationAvion;
	}

	public String getDatePrevue() {
		return datePrevue;
	}

	public void setDatePrevue(String datePrevue) {
		this.datePrevue = datePrevue;
	}

	public String getDateDebut() {
		return dateDebut;
	}

	public void setDateDebut(String dateDebut) {
		this.dateDebut = dateDebut;
	}

	public String getDateFin() {
		return dateFin;
	}

	public void setDateFin(String dateFin) {
		this.dateFin = dateFin;
	}

	public String getCommentaire() {
		return commentaire;
	}

	public void setCommentaire(String commentaire) {
		this.commentaire = commentaire;
	}

	public String getStatutRevision() {
		return statutRevision;
	}

	public void setStatutRevision(String statutRevision) {
		this.statutRevision = statutRevision;
	}

	public int getIdAvion() {
		return idAvion;
	}

	public void setIdAvion(int idAvion) {
		this.idAvion = idAvion;
	}
}
