package com.example.inssetairlines;

import seb.util.IoSeb;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

public class FicheModele extends Activity {
	private TextView nomModele;
	private TextView longueurPiste;
	private TextView nbPlaces;
	private TextView petiteRev;
	private TextView grandeRev;
	private TextView rayonAction;
	private Button ok;
	private Modele modele;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_fiche_modele);
		nomModele = (TextView) findViewById(R.id.textNomModele);
		longueurPiste = (TextView) findViewById(R.id.TextPiste);
		nbPlaces = (TextView) findViewById(R.id.TextPlaces);
		petiteRev = (TextView) findViewById(R.id.TextPetiteRev);
		grandeRev = (TextView) findViewById(R.id.TextGrandeRev);
		rayonAction = (TextView) findViewById(R.id.TextRayon);
		ok = (Button) findViewById(R.id.OkModele);

		Intent t = getIntent();
		int idModele = t.getIntExtra("idModele", 1);
		Modele.lireLigneModeleAvecId(idModele, getApplicationContext(),
				handlerLireLigneModeleAvecId);

		ok.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				FicheModele.this.finish();
			}
		});

	}

	Handler handlerLireLigneModeleAvecId = new Handler() {
		public void handleMessage(Message msg) {
			modele = new Modele(IoSeb.tabResultats[0]);
			nomModele.setText(modele.getNomModele());
			longueurPiste.setText(String.valueOf(modele.getLongueurPiste()));
			rayonAction.setText(String.valueOf(modele.getRayonDaction()));
			nbPlaces.setText(String.valueOf(modele.getNbPlace()));
			petiteRev
					.setText(String.valueOf(modele.getPeriodePetiteRevision()));
			grandeRev
					.setText(String.valueOf(modele.getPeriodeGrandeRevision()));
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_fiche_modele, menu);
		return true;
	}
}
