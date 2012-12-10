package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import seb.util.IoSeb;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.AdapterView.OnItemClickListener;

public class PlanifierRevision extends Activity {

	ListView listeAvionsAmettreEnRev = null;

	String[] numImmatri = { "avion1", "avion2", "avion3" };
	String[] typeRev = { "grande", "petite", "grande" };

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_planifier_revision);
		listeAvionsAmettreEnRev = (ListView) findViewById(R.id.listViewAvionAmettreEnRev);
		afficherListeAvionAmettreEnRevision();

		listeAvionsAmettreEnRev.setOnItemClickListener(listenerListeAvions);

	}// onCreate

	private OnItemClickListener listenerListeAvions = new OnItemClickListener() {

		@Override
		public void onItemClick(AdapterView<?> arg0, View arg1, int position,
				long arg3) {
			// TODO Auto-generated method stub
			Intent t = new Intent(PlanifierRevision.this, Calendrier.class);
			t.putExtra("numImmatri", numImmatri[position]);
			startActivity(t);
		}
	};

	public void afficherListeAvionAmettreEnRevision() {

		/*
		 * mettre requete IoSeb ioSeb = new IoSeb(); ioSeb.ajoutParam("param",
		 * "param"); // param inutile
		 * ioSeb.outputSeb(UrlScriptsPhp.urlLireListeAvionsEnRevision, new
		 * String[] { "idAvion", "immatriculationAvion", "idRevision",
		 * "dateDebut", "statutRevision" }, getApplicationContext(),
		 * handlerListeAvionsAmettreEnRevision);
		 */
		remplaceHandlerPourTests();  //a supprimer
	}

	// Handler handlerListeAvionsAmettreEnRevision = new Handler() {    //enlever comment
	// public void handleMessage(Message msg) {      //enlever comment
	public void remplaceHandlerPourTests() {
		ArrayList<HashMap<String, String>> lAvions = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> avionRev = new HashMap<String, String>();
		for (int i = 0; i < 3; i++) { // remplacer 3 par
										// IoSeb.tabResultats.length
			avionRev = new HashMap<String, String>();
			avionRev.put("numImmatri", numImmatri[i]); // remplacer
														// numImmatri[i] par
														// IoSeb.tabResultats[i][0]
			avionRev.put("typeRev", typeRev[i]);
			lAvions.add(avionRev);
		}
		SimpleAdapter adapter = new SimpleAdapter(PlanifierRevision.this,
				lAvions, R.layout.ligne_avion_a_envoyer_en_revision,
				new String[] { "numImmatri", "typeRev" }, new int[] {
						R.id.textViewNumImmatri, R.id.textViewTypeRev });
		listeAvionsAmettreEnRev.setAdapter(adapter);
	}

	// };           //enlever comment

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_planifier_revision, menu);
		return true;
	}
}
