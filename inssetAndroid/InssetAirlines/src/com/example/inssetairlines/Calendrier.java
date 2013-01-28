package com.example.inssetairlines;

import seb.util.IoSeb;
import seb.util.ToastSeb;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.CalendarView;
import android.widget.CalendarView.OnDateChangeListener;

public class Calendrier extends Activity {
	
	CalendarView calendrierRevisions = null;
	Button boutonValider = null;
	int idAvion;
	String statutRevision;
	String immatriculationAvion;
	String datePrevue;
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
        Intent t = getIntent();
        idAvion = t.getIntExtra("idAvion", 0);
        immatriculationAvion = t.getStringExtra("numImmatri");
        statutRevision = t.getStringExtra("statutRev");
    }

    
    private OnClickListener listenerValider = new OnClickListener() {
		
		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			boutonValider.setEnabled(false);
				datePrevue = String.valueOf(annee)+"-"+String.valueOf(mois)+"-"+String.valueOf(jour);
				IoSeb ioSeb = new IoSeb();
				ioSeb.ajoutParam("idAvion", String.valueOf(idAvion));
				ioSeb.ajoutParam("datePrevue", datePrevue);
				ioSeb.ajoutParam("immatriculationAvion", immatriculationAvion);
				ioSeb.ajoutParam("statutRevision", statutRevision);
				ioSeb.inputSeb(UrlScriptsPhp.urlValiderDateRevisionPrevue, handlerValiderDate, getApplicationContext());
		}
	};
	
	private Handler handlerValiderDate = new Handler() {
		public void handleMessage(Message msg) {
			ToastSeb.toastSeb(getApplicationContext(), "Révision prévue le "+datePrevue+" pour "+immatriculationAvion);
			finish();
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
