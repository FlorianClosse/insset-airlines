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
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class ListeAvions extends Activity {
	ListView listeAvions = null;
	Button ajouterAvion = null;
	private String[][] avions;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_liste_avions);
		listeAvions = (ListView) findViewById(R.id.listeAvions);
		ajouterAvion = (Button) findViewById(R.id.ajouter);

		IoSeb ioseb = new IoSeb();
		ioseb.ajoutParam("nomTable", "avion");
		ioseb.outputSeb(UrlScriptsPhp.urlLireListe_id_nom, new String[] {
				"idAvion", "numImmatriculation" }, getApplicationContext(),
				handlerListeAvions);

		listeAvions.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1,
					int position, long arg3) {
				// TODO Auto-generated method stub
				Intent t = new Intent(ListeAvions.this, FicheAvion.class);
				t.putExtra("idAvion", avions[position][0]);
				startActivity(t);
			}
		});

		ajouterAvion.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(ListeAvions.this, AjouterAvion.class);
				startActivity(t);
			}
		});

	}// onCreate

	Handler handlerListeAvions = new Handler() {
		public void handleMessage(Message msg) {
			avions = IoSeb.tabResultats;
			ArrayList<HashMap<String, String>> listItem = new ArrayList<HashMap<String, String>>();
			HashMap<String, String> item = new HashMap<String, String>();
			for (int i = 0; i < avions.length; i++) {
				item = new HashMap<String, String>();
				item.put("nom", avions[i][1]);
				listItem.add(item);
			}
			SimpleAdapter mSchedule = new SimpleAdapter(
					ListeAvions.this.getBaseContext(), listItem,
					R.layout.ligne_avion, new String[] { "nom" },
					new int[] { R.id.nomAvion });

			listeAvions.setAdapter(mSchedule);
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_liste_avions, menu);
		return true;
	}
}
