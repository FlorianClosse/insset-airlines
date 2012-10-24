package com.example.inssetairlines;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.HashMap;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.text.format.DateFormat;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;

public class FicheAvion extends Activity {
	
	TextView immatri = null;
	Button boutonComment = null;
	ListView listeRevisions = null;
	ImageButton boutonModele = null;
	String modeleAvionChoisi = "exemple modèle"; //modele de l'avion selectionné dans la liste des avions
	//liste de revisions contenant une date pour les tests
	GregorianCalendar[] datesRevisions = {new GregorianCalendar(2012, 4, 22), new GregorianCalendar(2012, 5, 23), new GregorianCalendar(2011, 11, 12)};//mois: de 0 à 11
	String[] typeRevisions = {"grande","petite","grande"};//liste de types de revisions pour les tests

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fiche_avion);
        Intent extra = getIntent();
		final String immatriAvion= extra.getStringExtra("nomAvion");
		immatri = (TextView)findViewById(R.id.immatri);
		immatri.setText(immatriAvion); //test
		boutonComment = (Button)findViewById(R.id.commentaires);
		listeRevisions = (ListView)findViewById(R.id.revisions);
		boutonModele = (ImageButton)findViewById(R.id.boutonModele);
		
		afficherRevisions();
		
		boutonComment.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(FicheAvion.this, AfficherComment.class);
				t.putExtra("immatriAvion", immatriAvion);
				startActivity(t);
			}
		});
		
		listeRevisions.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int position,
					long arg3) {
				// TODO Auto-generated method stub
				Intent t = new Intent(FicheAvion.this, FicheRevision.class);
				t.putExtra("idRevision", position); //il faut envoyer l'id de la revision au lieu de la position
				startActivity(t);
			}
		});
		
		boutonModele.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(FicheAvion.this, FicheModele.class);
				t.putExtra("modele", modeleAvionChoisi);
				startActivity(t);
			}
		});
		
    }//fin onCreate
    
    public void afficherRevisions() {
    	ArrayList<HashMap<String, String>> listeRev = new ArrayList<HashMap<String,String>>();
		HashMap<String, String> revision = new HashMap<String, String>();
		SimpleDateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy");
		String dateString = null;
		for(int i = 0; i < datesRevisions.length; i++) {	
			revision = new HashMap<String, String>();
			//conversion gregoriancalendar en string
			dateString = dateFormat.format(datesRevisions[i].getTime());
			revision.put("date", dateString);
			revision.put("type", typeRevisions[i]);
			listeRev.add(revision);
		}
		
		SimpleAdapter adapter = new SimpleAdapter(FicheAvion.this, listeRev, R.layout.ligne_revision, new String[] {"date","type"}, new int[] {R.id.textDateRev, R.id.textTypeRev});
		listeRevisions.setAdapter(adapter);
    }//fin afficherRevisions

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_fiche_avion, menu);
        return true;
    }
}
