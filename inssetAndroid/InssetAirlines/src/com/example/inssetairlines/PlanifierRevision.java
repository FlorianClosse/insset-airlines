package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import seb.util.IoSeb;
import android.R.id;
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

	static float MARGE_HEURES_VOL = 0.9F;

	ListView listeAvionsAmettreEnRev = null;

	String[] numImmatri = null;
	String[] typeRev = null;
	int[] idAvions;

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
			t.putExtra("idAvion", idAvions[position]);
			t.putExtra("numImmatri", numImmatri[position]);
			t.putExtra("statutRev", typeRev[position]);
			startActivity(t);
			finish();
		}
	};

	public void afficherListeAvionAmettreEnRevision() {

		
		  IoSeb ioSeb = new IoSeb(); ioSeb.ajoutParam("param", "param"); // param inutile
		  ioSeb.outputSeb(UrlScriptsPhp.urlLireListeAvionsAenvoyerEnRevision, new
		  String[] { "idAvion", "numImmatriculation", "periodeGrandeRevision",
		  "periodePetiteRevision", "nbHeureVolDepuisGrandeRevision", "nbHeureVolDepuisPetiteRevision" }, getApplicationContext(),
		  handlerListeAvionsAenvoyerEnRevision);
	}

	 Handler handlerListeAvionsAenvoyerEnRevision = new Handler() { 
	 public void handleMessage(Message msg) {  
		ArrayList<HashMap<String, String>> lAvions = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> avionRev = new HashMap<String, String>();
		typeRev = new String[IoSeb.tabResultats.length];
		numImmatri = new String[IoSeb.tabResultats.length];
		idAvions = new int[IoSeb.tabResultats.length];
		for (int i = 0; i < IoSeb.tabResultats.length; i++) {
			avionRev = new HashMap<String, String>();
			avionRev.put("numImmatri", IoSeb.tabResultats[i][1]);
			numImmatri[i] = IoSeb.tabResultats[i][1];
			idAvions[i] = Integer.valueOf(IoSeb.tabResultats[i][0]);
			
			if(Integer.valueOf(IoSeb.tabResultats[i][4]) >= Integer.valueOf(IoSeb.tabResultats[i][2])*MARGE_HEURES_VOL) {
				typeRev[i] = "grande";
			}
			else {
				if(Integer.valueOf(IoSeb.tabResultats[i][5]) >= Integer.valueOf(IoSeb.tabResultats[i][3])*MARGE_HEURES_VOL) {
					typeRev[i] = "petite";
				}
			}
			avionRev.put("typeRev", typeRev[i]);
			lAvions.add(avionRev);
		}
		SimpleAdapter adapter = new SimpleAdapter(PlanifierRevision.this,
				lAvions, R.layout.ligne_avion_a_envoyer_en_revision,
				new String[] { "numImmatri", "typeRev" }, new int[] {
						R.id.textViewNumImmatri, R.id.textViewTypeRev });
		listeAvionsAmettreEnRev.setAdapter(adapter);
	}

	 };

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_planifier_revision, menu);
		return true;
	}
}
