package com.example.inssetairlines;

import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;

public class FicheModele extends Activity {

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fiche_modele);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_fiche_modele, menu);
        return true;
    }
}
