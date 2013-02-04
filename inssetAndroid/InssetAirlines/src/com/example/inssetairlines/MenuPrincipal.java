package com.example.inssetairlines;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

public class MenuPrincipal extends Activity {
	Button gererAvion = null;
	Button gererOperation = null;
	Button gererRevisions = null;
	Button planifierRevisions = null;
	Button planning = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_menu_principal);
		gererAvion = (Button) findViewById(R.id.gererAvion);
		gererOperation = (Button) findViewById(R.id.gererOperations);
		gererRevisions = (Button) findViewById(R.id.gererRevisions);
		planifierRevisions = (Button) findViewById(R.id.planifier);
		planning = (Button) findViewById(R.id.planning);
		if (IAMaintenance.ID_SERVICE != IAMaintenance.ID_ADMINISTRATEUR) {
			gererAvion.setEnabled(false);
			gererAvion.setAlpha(0.3F);
			planifierRevisions.setEnabled(false);
			planifierRevisions.setAlpha(0.3F);
			gererRevisions.setEnabled(false);
			gererRevisions.setAlpha(0.3F);
			if (IAMaintenance.ID_SERVICE != IAMaintenance.ID_MAINTENANCE) {
				planning.setEnabled(false);
				planning.setAlpha(0.3F);
				gererOperation.setEnabled(false);
				gererOperation.setAlpha(0.3F);
			}
		}
		planning.setEnabled(false);
		planning.setVisibility(View.GONE);

		gererAvion.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(MenuPrincipal.this, ListeAvions.class);
				startActivity(t);
			}
		});

		planning.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(MenuPrincipal.this,
						PlanningRevisions.class);
				startActivity(t);
			}
		});

		gererOperation.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(MenuPrincipal.this, GererOperation.class);
				startActivity(t);
			}
		});

		gererRevisions.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(MenuPrincipal.this,
						GestionRevisions.class);
				startActivity(t);
			}
		});

		planifierRevisions.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(MenuPrincipal.this,
						PlanifierRevision.class);
				startActivity(t);

			}
		});
	}// onCreate

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_menu_principal, menu);
		return true;
	}
}
