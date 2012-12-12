package com.example.inssetairlines;

import seb.util.ToastSeb;
import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.CalendarView;
import android.widget.CalendarView.OnDateChangeListener;

public class Calendrier extends Activity {
	
	CalendarView calendrierRevisions = null;
	Button boutonValider = null;
	int annee = 0;
	int mois = 0;
	int jour = 0;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_calendrier);
        calendrierRevisions = (CalendarView)findViewById(R.id.calendarViewRevisions);
        calendrierRevisions.setOnDateChangeListener(listenerDateChange);
        boutonValider = (Button)findViewById(R.id.buttonValiderDateRevision);
        boutonValider.setOnClickListener(listenerValider);
        
        //ajouter intent...getExtra... avec idRevision et/ou idAvion
    }

    
    private OnClickListener listenerValider = new OnClickListener() {
		
		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			if(annee != 0) { // tester valider de la date choisie
				//si date valide:
				String date = String.valueOf(annee)+"-"+String.valueOf(mois)+"-"+String.valueOf(jour);
				ToastSeb.toastSeb(getApplicationContext(), date);
				//enregistrement de la date prévue de la revision
				finish();  //on peux mettre finish dans un handler
			}
		}
	};
	
	private OnDateChangeListener listenerDateChange = new OnDateChangeListener() {
		
		@Override
		public void onSelectedDayChange(CalendarView view, int year, int month,
				int dayOfMonth) {
			// TODO Auto-generated method stub
			annee = year;
			mois = month+1;   //les mois vont de 0 à 11
			jour = dayOfMonth;
		}
	};
	
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_calendrier, menu);
        return true;
    }
}
