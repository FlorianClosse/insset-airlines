package com.example.inssetairlines;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.widget.CalendarView;
import android.widget.CalendarView.OnDateChangeListener;

public class PlanningRevisions extends Activity {

	CalendarView planning = null;
	
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_planning_revisions);
        planning = (CalendarView)findViewById(R.id.calendarViewPlanning);
        planning.setOnDateChangeListener(listenerPlanning);
        
    }

    private OnDateChangeListener listenerPlanning = new OnDateChangeListener() {
		
		@Override
		public void onSelectedDayChange(CalendarView view, int year, int month,
				int dayOfMonth) {
			// TODO Auto-generated method stub
			Intent t = new Intent(PlanningRevisions.this, RevisionsJour.class);
			t.putExtra("annee", year);
			t.putExtra("mois", month);
			t.putExtra("jour", dayOfMonth);
			startActivity(t);
		}
	};
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_planning_revisions, menu);
        return true;
    }
}
