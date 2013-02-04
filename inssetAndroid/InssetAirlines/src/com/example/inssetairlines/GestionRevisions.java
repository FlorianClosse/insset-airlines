package com.example.inssetairlines;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

public class GestionRevisions extends Activity {
	Button boutonValiderRevision = null;
	Button boutonTerminerRevision = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_gestion_revisions);
		boutonValiderRevision = (Button) findViewById(R.id.buttonValiderRevision);
		boutonTerminerRevision = (Button) findViewById(R.id.buttonTerminerRevision);

		boutonValiderRevision.setOnClickListener(listenerValider);
		boutonTerminerRevision.setOnClickListener(listenerTerminer);
	}

	private OnClickListener listenerValider = new OnClickListener() {

		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			Intent t = new Intent(GestionRevisions.this, ValiderRevision.class);
			startActivity(t);
		}
	};

	private OnClickListener listenerTerminer = new OnClickListener() {

		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			Intent t = new Intent(GestionRevisions.this, TerminerRevision.class);
			startActivity(t);
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_gestion_revisions, menu);
		return true;
	}
}
