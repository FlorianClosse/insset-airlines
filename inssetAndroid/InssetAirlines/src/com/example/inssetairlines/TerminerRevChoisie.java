package com.example.inssetairlines;

import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;

public class TerminerRevChoisie extends Activity {

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_terminer_rev_choisie);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_terminer_rev_choisie, menu);
        return true;
    }
}
