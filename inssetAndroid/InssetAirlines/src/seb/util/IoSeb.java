package seb.util;

import java.io.InputStream;
import java.util.ArrayList;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;

import android.content.Context;
import android.os.Handler;

public class IoSeb {

	public InputStream is;
	public String resultat;
	public ArrayList<NameValuePair> params;
	public static String[][] tabResultats;
	public static String erreur;

	public IoSeb() {
		is = null;
		resultat = "";
		params = new ArrayList<NameValuePair>();
		erreur = "ras";

	}

	public void ajoutParam(String nom, String valeur) {
		// ajoute un parametre à la requete type SELECT * FROM table WHERE...
		params.add(new BasicNameValuePair(nom, valeur)); // nom = nom de la
															// colonne
	} // valeur = valeur de la caracteristique recherchée

	public void inputSeb(String urlPhp, Handler handler, Context context) {
		InputSeb input = new InputSeb(urlPhp, handler, context);
		input.setParams(params);
		input.execute();
	}

	public void outputSeb(String urlPhp, String[] nomCol,
			Context context, Handler handler) {
		OutputSeb output = new OutputSeb(urlPhp, nomCol, context, handler);
		output.setParams(params);
		output.execute();
	}
	
	public static void viderTabResultats() {
		tabResultats = null;
	}
}
