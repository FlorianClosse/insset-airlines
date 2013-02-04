package com.example.inssetairlines;

public class Commentaire {
	private int idCommentaire;
	private int idAvion;
	private String commentaire;
	private String dateCommentaire;

	public Commentaire() {
		this.setIdCommentaire(0);
		this.setIdAvion(0);
		this.setCommentaire(null);
		this.setDateCommentaire(null);
	}

	public Commentaire(String[] resultat) {
		this.setIdCommentaire(Integer.valueOf(resultat[0]));
		this.setIdAvion(Integer.valueOf(resultat[1]));
		this.setCommentaire(resultat[2]);
		this.setDateCommentaire(resultat[3]);
	}

	public int getIdCommentaire() {
		return idCommentaire;
	}

	public void setIdCommentaire(int idCommentaire) {
		this.idCommentaire = idCommentaire;
	}

	public int getIdAvion() {
		return idAvion;
	}

	public void setIdAvion(int idAvion) {
		this.idAvion = idAvion;
	}

	public String getCommentaire() {
		return commentaire;
	}

	public void setCommentaire(String commentaire) {
		this.commentaire = commentaire;
	}

	public String getDateCommentaire() {
		return dateCommentaire;
	}

	public void setDateCommentaire(String dateCommentaire) {
		this.dateCommentaire = dateCommentaire;
	}

}
