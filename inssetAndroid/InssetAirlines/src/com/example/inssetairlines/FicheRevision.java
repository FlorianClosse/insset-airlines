package com.example.inssetairlines;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.widget.TextView;

public class FicheRevision extends Activity {

	
	int idRevision;
	TextView viewNumImmatri = null;
	TextView viewModele = null;
	TextView viewTypeRev = null;
	TextView viewDateDebutOuPrevue = null;
	TextView viewDateFin = null;
	TextView viewCommentaire = null;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fiche_revision);
        Intent t = getIntent();
        t.getIntExtra("idRevision", 0);
        
        //requete pour obtenir les infos sur la révision
        //puis affichage dans le handler
        
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_fiche_revision, menu);
        return true;
    }
}
