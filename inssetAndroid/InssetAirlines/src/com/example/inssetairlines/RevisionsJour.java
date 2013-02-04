package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class RevisionsJour extends Activity {

	ListView listeRevJour = null;
	int jour;
	int mois;
	int annee;

	String[] numImmatri = { "avion1", "avion2", "avion3" };

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_revisions_jour);
		Intent t = getIntent();
		jour = t.getIntExtra("jour", 0);
		mois = t.getIntExtra("mois", 0);
		annee = t.getIntExtra("annee", 0);
		listeRevJour = (ListView) findViewById(R.id.listViewRevJour);
		afficherListeRevJour();

		listeRevJour.setOnItemClickListener(listenerListeRevJour);
	}

	private OnItemClickListener listenerListeRevJour = new OnItemClickListener() {

		@Override
		public void onItemClick(AdapterView<?> arg0, View arg1, int position,
				long arg3) {
			// TODO Auto-generated method stub
			Intent t = new Intent(RevisionsJour.this, FicheRevision.class);
			t.putExtra("idRevision", numImmatri[position]); // envoyer id de la
															// revision
			startActivity(t);
		}
	};

	public void afficherListeRevJour() {

		remplaceHandlerPourTests(); // a supprimer
	}

	public void remplaceHandlerPourTests() {
		ArrayList<HashMap<String, String>> lAvions = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> avionRev = new HashMap<String, String>();
		for (int i = 0; i < 3; i++) { // remplacer 3 par
										// IoSeb.tabResultats.length
			avionRev = new HashMap<String, String>();
			avionRev.put("numImmatri", numImmatri[i]); // remplacer
														// numImmatri[i] par
														// IoSeb.tabResultats[i][0]
			lAvions.add(avionRev);
		}
		SimpleAdapter adapter = new SimpleAdapter(RevisionsJour.this, lAvions,
				R.layout.ligne_revision_jour, new String[] { "numImmatri" },
				new int[] { R.id.textViewImmatriRevJour });
		listeRevJour.setAdapter(adapter);
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_revisions_jour, menu);
		return true;
	}
}
