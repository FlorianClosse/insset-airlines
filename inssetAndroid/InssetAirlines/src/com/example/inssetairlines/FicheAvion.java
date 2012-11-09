package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import seb.util.IoSeb;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;

public class FicheAvion extends Activity {

	Avion avion;
	TextView immatri = null;
	TextView modele = null;
	TextView miseEnService = null;
	TextView nbHeuresVol = null;
	TextView heuresGR = null;
	TextView heuresPR = null;
	TextView localisation = null;
	TextView aeroAttache = null;
	TextView statut = null;
	Button boutonComment = null;
	ListView listeRevisions = null;
	ImageButton boutonModele = null;
	String[][] revisions;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_fiche_avion);
		Intent extra = getIntent();
		String idAvion = extra.getStringExtra("idAvion");
		Avion.lireLigneAvionAvecId(getApplicationContext(),
				handlerLireLigneAvion, Integer.valueOf(idAvion));
		immatri = (TextView) findViewById(R.id.immatri);
		modele = (TextView) findViewById(R.id.modele);
		miseEnService = (TextView) findViewById(R.id.miseEnService);
		nbHeuresVol = (TextView) findViewById(R.id.nbHeuresVol);
		heuresGR = (TextView) findViewById(R.id.heuresGR);
		heuresPR = (TextView) findViewById(R.id.heuresPR);
		localisation = (TextView) findViewById(R.id.localisation);
		aeroAttache = (TextView) findViewById(R.id.aeroAttache);
		statut = (TextView) findViewById(R.id.statut);
		boutonComment = (Button) findViewById(R.id.commentaires);
		listeRevisions = (ListView) findViewById(R.id.revisions);
		boutonModele = (ImageButton) findViewById(R.id.boutonModele);

		boutonComment.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(FicheAvion.this, AfficherComment.class);
				t.putExtra("idAvion", avion.getIdAvion());
				startActivity(t);
			}
		});

		listeRevisions.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1,
					int position, long arg3) {
				// TODO Auto-generated method stub
				Intent t = new Intent(FicheAvion.this, FicheRevision.class);
				t.putExtra("idRevision",
						Integer.valueOf(revisions[position][0]));
				startActivity(t);
			}
		});

		boutonModele.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(FicheAvion.this, FicheModele.class);
				t.putExtra("idModele", avion.getIdModele());
				startActivity(t);
			}
		});

	}// fin onCreate

	public void afficherRevisions() {
		ArrayList<HashMap<String, String>> listeRev = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> revision = new HashMap<String, String>();

		for (int i = 0; i < revisions.length; i++) {
			revision = new HashMap<String, String>();
			revision.put("datePrevue", revisions[i][1]);
			revision.put("statutRevision", revisions[i][2]);
			listeRev.add(revision);
		}

		SimpleAdapter adapter = new SimpleAdapter(FicheAvion.this, listeRev,
				R.layout.ligne_revision, new String[] { "datePrevue",
						"statutRevision" }, new int[] { R.id.datePrevue,
						R.id.textTypeRev });
		listeRevisions.setAdapter(adapter);
	}// fin afficherRevisions

	Handler handlerLireLigneAvion = new Handler() {
		public void handleMessage(Message msg) {

			avion = new Avion(IoSeb.tabResultats[0]);
			immatri.setText(avion.getNumImmatriculation());
			miseEnService.setText(avion.getDateMisEnService());
			nbHeuresVol.setText(String.valueOf(avion.getNombreHeureTotale()));
			heuresGR.setText(String.valueOf(avion
					.getNbHeureVolDepuisGrandeRevision()));
			heuresPR.setText(String.valueOf(avion
					.getNbHeureVolDepuisPetiteRevision()));
			statut.setText(avion.getStatut());
			modele.setText(avion.getNomModele());
			localisation.setText(avion.getNomLocalisation());
			aeroAttache.setText(avion.getNomAeroportDattache());

			if (IoSeb.tabResultats[0].length > 11) { // si une revision existe
				revisions = new String[IoSeb.tabResultats.length][3];
				for (int i = 0; i < IoSeb.tabResultats.length; i++) {
					for (int j = 0; j < revisions[0].length; j++) {
						revisions[i][j] = IoSeb.tabResultats[i][j + 11];
					}
				}
				afficherRevisions();
				IoSeb.viderTabResultats();
			}

		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_fiche_avion, menu);
		return true;
	}
}
