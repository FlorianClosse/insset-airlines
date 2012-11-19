package com.example.inssetairlines;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.GregorianCalendar;
import java.util.HashMap;

import seb.util.IoSeb;
import seb.util.ToastSeb;

import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class GererOperation extends Activity {
	ListView listeAvionRev = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_gerer_opera);
		listeAvionRev = (ListView) findViewById(R.id.listAvionRevision);
		afficherListeAvionRevision();

		listeAvionRev.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1,
					int position, long arg3) {
				// TODO Auto-generated method stub
				Intent t = new Intent(GererOperation.this,
						ListeOperations.class);
				t.putExtra("idRevision", IoSeb.tabResultats[position][2]);
				startActivity(t);
			}
		});
	}// oncreate

	public void afficherListeAvionRevision() {

		IoSeb ioSeb = new IoSeb();
		ioSeb.ajoutParam("param", "param"); // param inutile
		ioSeb.outputSeb(UrlScriptsPhp.urlLireListeAvionsEnRevision,
				new String[] { "idAvion", "immatriculationAvion", "idRevision",
						"dateDebut", "statutRevision" },
				getApplicationContext(), handlerListeAvionsEnRevision);
	}

	Handler handlerListeAvionsEnRevision = new Handler() {
		public void handleMessage(Message msg) {
			ArrayList<HashMap<String, String>> lAvions = new ArrayList<HashMap<String, String>>();
			HashMap<String, String> avionRev = new HashMap<String, String>();
			for (int i = 0; i < IoSeb.tabResultats.length; i++) {
				avionRev = new HashMap<String, String>();
				avionRev.put("immatriculation", IoSeb.tabResultats[i][1]);
				avionRev.put("typeRevision", IoSeb.tabResultats[i][4]);
				avionRev.put("dateRevision", IoSeb.tabResultats[i][3]);
				lAvions.add(avionRev);
			}
			SimpleAdapter adapter = new SimpleAdapter(GererOperation.this,
					lAvions, R.layout.ligne_avion_en_revision,
					new String[] { "immatriculation", "typeRevision",
							"dateRevision" }, new int[] { R.id.TextImmatri,
							R.id.TextTypeRev, R.id.TextDateRev });
			listeAvionRev.setAdapter(adapter);
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_gerer_opera, menu);
		return true;
	}
}
