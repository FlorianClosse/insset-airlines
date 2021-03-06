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
import android.widget.DatePicker;
import android.widget.TextView;

public class ValiderOperation extends Activity {

	String idOperation;
	TextView textNomPrenomUser = null;
	DatePicker datePickerOp = null;
	Button boutonValider = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_valider_operation);
		textNomPrenomUser = (TextView) findViewById(R.id.textViewNomPrenomUser);
		textNomPrenomUser.setText(IAMaintenance.NOM_PRENOM_USER);
		datePickerOp = (DatePicker) findViewById(R.id.datePickerOp);
		boutonValider = (Button) findViewById(R.id.buttonValider);
		Intent t = getIntent();
		idOperation = t.getStringExtra("idOperation");

		boutonValider.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				int jour = datePickerOp.getDayOfMonth();
				int mois = datePickerOp.getMonth() + 1;
				int annee = datePickerOp.getYear();
				String date = String.valueOf(annee) + "-"
						+ String.valueOf(mois) + "-" + String.valueOf(jour);
				IoSeb ioSeb = new IoSeb();
				ioSeb.ajoutParam("idUser",
						String.valueOf(IAMaintenance.ID_USER));
				ioSeb.ajoutParam("dateFin", date);
				ioSeb.ajoutParam("idOperation", idOperation);
				ioSeb.inputSeb(UrlScriptsPhp.urlValiderOperation,
						handlerValiderOperation, getApplicationContext());
			}
		});

	}

	Handler handlerValiderOperation = new Handler() {
		public void handleMessage(Message msg) {
			ToastSeb.toastSeb(getApplicationContext(), "Op�ration termin�e");
			finish();
			/*
			 * Intent t = new Intent(ValiderOperation.this,
			 * ListeOperations.class); startActivity(t);
			 */
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_valider_operation, menu);
		return true;
	}
}
