package com.example.inssetairlines;

import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;

public class FicheRevision extends Activity {

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fiche_revision);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_fiche_revision, menu);
        return true;
    }
}
