package com.example.inssetairlines;

import android.app.Activity;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class AjouterModele extends Activity {
	private EditText nomModele;
	private EditText longueurPiste;
	private EditText rayonAction;
	private EditText nbPlace;
	private EditText petiteRev;
	private EditText grandeRev;
	private Button validerModele;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_ajouter_modele);
		nomModele = (EditText) findViewById(R.id.nomModele);
		longueurPiste = (EditText) findViewById(R.id.longueurPiste);
		rayonAction = (EditText) findViewById(R.id.rayonAction);
		nbPlace = (EditText) findViewById(R.id.nbPlaces);
		petiteRev = (EditText) findViewById(R.id.petiteRev);
		grandeRev = (EditText) findViewById(R.id.grandeRev);
		validerModele = (Button) findViewById(R.id.validerModele);

		validerModele.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Modele modele = new Modele(AjouterModele.this);
				modele.setNomModele(nomModele.getText().toString());
				modele.setLongueurPiste(Integer.valueOf(longueurPiste.getText()
						.toString()));
				modele.setRayonDaction(Integer.valueOf(rayonAction.getText()
						.toString()));
				modele.setNbPlace(Integer.valueOf(nbPlace.getText().toString()));
				modele.setPeriodePetiteRevision(Integer.valueOf(petiteRev
						.getText().toString()));
				modele.setPeriodeGrandeRevision(Integer.valueOf(grandeRev
						.getText().toString()));
				modele.ajouterModele();
			}
		});

	} // onCreate

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_ajouter_modele, menu);
		return true;
	}
}
