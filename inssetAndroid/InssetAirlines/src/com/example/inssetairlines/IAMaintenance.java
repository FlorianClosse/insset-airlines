package com.example.inssetairlines;

import seb.util.IoSeb;
import seb.util.ToastSeb;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class IAMaintenance extends Activity {

	/*
	 * nom utilisateurs pre enregistres dans la base: nom: admin, prenom: admin,
	 * mdp: admin, service: 9 nom: user, prenom: user, mdp: user, service: 5
	 * nom: maint, prenom: maint, mpd: maint, service: 6
	 */
	public static int ID_USER;
	public static int ID_SERVICE;
	public static String NOM_PRENOM_USER;
	public static int ID_COMMERCIAL = 1;
	public static int ID_STRATEGIQUE = 2;
	public static int ID_TECHNIQUE = 3;
	public static int ID_LOGISTIQUE = 4;
	public static int ID_DRH = 5;
	public static int ID_MAINTENANCE = 6;
	public static int ID_PLANNING = 7;
	public static int ID_EXPLOITATION = 8;
	public static int ID_ADMINISTRATEUR = 9;

	Button boutonValider = null;
	EditText editNomUser = null;
	EditText editPrenomUser = null;
	EditText editMotDePasse = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_iamaintenance);
		boutonValider = (Button) findViewById(R.id.buttonValiderUser);
		boutonValider.setOnClickListener(listenerValider);
		editNomUser = (EditText) findViewById(R.id.editTextLoginNom);
		editPrenomUser = (EditText) findViewById(R.id.editTextLoginPrenom);
		editMotDePasse = (EditText) findViewById(R.id.editTextMotDePasse);

	}

	private OnClickListener listenerValider = new OnClickListener() {

		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			IoSeb ioSeb = new IoSeb();
			ioSeb.ajoutParam("nomUser", editNomUser.getText().toString());
			ioSeb.ajoutParam("prenomUser", editPrenomUser.getText().toString());
			ioSeb.ajoutParam("motDePasse", editMotDePasse.getText().toString());
			ioSeb.outputSeb(UrlScriptsPhp.urlLireValiderIdEtServiceUser,
					new String[] { "idUser", "service" },
					getApplicationContext(), handlerValiderUser);
		}
	};

	private Handler handlerValiderUser = new Handler() {
		public void handleMessage(Message msg) {
			if (IoSeb.tabResultats.length == 0) {
				ToastSeb.toastSeb(getApplicationContext(),
						"Mot de passe ou nom et prénom incorrect !");
			} else {
				ID_USER = Integer.valueOf(IoSeb.tabResultats[0][0]);
				ID_SERVICE = Integer.valueOf(IoSeb.tabResultats[0][1]);
				NOM_PRENOM_USER = editNomUser.getText().toString() + " "
						+ editPrenomUser.getText().toString();
				editNomUser.setText("");
				editPrenomUser.setText("");
				editMotDePasse.setText("");
				Intent t = new Intent(IAMaintenance.this, MenuPrincipal.class);
				startActivity(t);
			}
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_iamaintenance, menu);
		return true;
	}
}
