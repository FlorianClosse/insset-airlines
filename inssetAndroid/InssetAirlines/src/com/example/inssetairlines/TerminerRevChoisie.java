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
import android.widget.EditText;

public class TerminerRevChoisie extends Activity {

	DatePicker datePickerRev = null;
	Button boutonValider = null;
	EditText editCommentaire = null;
	String idRevisionChoisie = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_terminer_rev_choisie);
		datePickerRev = (DatePicker) findViewById(R.id.datePickerFinRevision);
		boutonValider = (Button) findViewById(R.id.buttonValiderTerminerRev);
		boutonValider.setOnClickListener(listenerValider);
		editCommentaire = (EditText) findViewById(R.id.editTextCommentaireTerminerRev);
		Intent t = getIntent();
		idRevisionChoisie = t.getStringExtra("idRevisionChoisie");
	}

	private OnClickListener listenerValider = new OnClickListener() {

		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			int jour = datePickerRev.getDayOfMonth();
			int mois = datePickerRev.getMonth() + 1;
			int annee = datePickerRev.getYear();
			String date = String.valueOf(annee) + "-" + String.valueOf(mois)
					+ "-" + String.valueOf(jour);
			IoSeb ioSeb = new IoSeb();
			ioSeb.ajoutParam("commentaire", editCommentaire.getText()
					.toString());
			ioSeb.ajoutParam("dateFin", date);
			ioSeb.ajoutParam("idRevisionChoisie", idRevisionChoisie);
			ioSeb.inputSeb(UrlScriptsPhp.urlTerminerRevisionChoisie,
					handlerTerminerRevisionChoisie, getApplicationContext());
		}
	};

	private Handler handlerTerminerRevisionChoisie = new Handler() {
		public void handleMessage(Message msg) {
			ToastSeb.toastSeb(getApplicationContext(),
					"La révision est terminée");
			finish();
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_terminer_rev_choisie, menu);
		return true;
	}
}
