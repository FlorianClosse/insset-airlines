package com.example.inssetairlines;

import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;

public class PlanningRevisions extends Activity {

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_planning_revisions);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_planning_revisions, menu);
        return true;
    }
}
