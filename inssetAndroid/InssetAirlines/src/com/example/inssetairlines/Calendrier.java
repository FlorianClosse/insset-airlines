package com.example.inssetairlines;

import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.CalendarView;

public class Calendrier extends Activity {
	
	CalendarView calendrierRevisions = null;
	Button boutonValider = null;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_calendrier);
        calendrierRevisions = (CalendarView)findViewById(R.id.calendarViewRevisions);
        boutonValider = (Button)findViewById(R.id.buttonValiderDateRevision);
        boutonValider.setOnClickListener(listenerValider);
    }

    
    private OnClickListener listenerValider = new OnClickListener() {
		
		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			
			
		}
	};
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_calendrier, menu);
        return true;
    }
}
