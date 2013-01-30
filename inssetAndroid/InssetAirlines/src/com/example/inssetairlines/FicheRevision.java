package com.example.inssetairlines;

import seb.util.IoSeb;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.widget.TextView;

public class FicheRevision extends Activity {

	TextView viewNumImmatri = null;
	TextView viewModele = null;
	TextView viewTypeRev = null;
	TextView viewValeurDateDebutOuPrevue = null;
	TextView viewDateDebutOuPrevue = null;
	TextView viewDateFin = null;
	TextView viewCommentaire = null;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fiche_revision);
        viewNumImmatri = (TextView)findViewById(R.id.textViewImmatriAvion);
        viewModele = (TextView)findViewById(R.id.TextViewModele);
        viewTypeRev = (TextView)findViewById(R.id.TextViewTypeRev);
        viewValeurDateDebutOuPrevue = (TextView)findViewById(R.id.TextViewValeurDateDebut);
        viewDateDebutOuPrevue = (TextView)findViewById(R.id.TextViewDateDebutOuPrevue);
        viewDateFin = (TextView)findViewById(R.id.TextViewValeurDateFin);
        viewCommentaire = (TextView)findViewById(R.id.textViewCommentaire);

        Intent t = getIntent();
        String idRevision = String.valueOf(t.getIntExtra("idRevision",0));
        IoSeb ioSeb = new IoSeb();
        ioSeb.ajoutParam("id", idRevision);
        ioSeb.ajoutParam("nomTable", "revision");
        ioSeb.outputSeb(UrlScriptsPhp.urlLireLigneCompleteAvecId, new String[] {"immatriculationAvion","datePrevue","dateDebut","dateFin","commentaire","statutRevision","nomModele"}, getApplicationContext(), handlerLireLigneCompleteAvecId);
        
    }

    private Handler handlerLireLigneCompleteAvecId = new Handler() {
    	public void handleMessage(Message msg) {
    		viewNumImmatri.setText(IoSeb.tabResultats[0][0]);
    		viewModele.setText(IoSeb.tabResultats[0][6]);
    		viewTypeRev.setText(IoSeb.tabResultats[0][5]);
    		if(IoSeb.tabResultats[0][2].contentEquals("0")) {
    			viewValeurDateDebutOuPrevue.setText(IoSeb.tabResultats[0][1]);
    			viewDateDebutOuPrevue.setText("Date prévue:");
    		}
    		else {
    			viewValeurDateDebutOuPrevue.setText(IoSeb.tabResultats[0][2]);
    			viewDateDebutOuPrevue.setText("Date de début:");
    		}
    		if(IoSeb.tabResultats[0][3].contentEquals("0")) {
    			viewDateFin.setText("-");
    		}
    		else {
    			viewDateFin.setText(IoSeb.tabResultats[0][3]);
    		}
    		if(IoSeb.tabResultats[0][4].contentEquals("0")) {
    			viewCommentaire.setText("-");
    		}
    		else {
    			viewCommentaire.setText(IoSeb.tabResultats[0][4]);
    		}
    	}
    };
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_fiche_revision, menu);
        return true;
    }
}
