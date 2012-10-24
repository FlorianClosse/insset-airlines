package com.example.inssetairlines;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.GregorianCalendar;
import java.util.HashMap;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class GererOperation extends Activity {
	ListView listeAvionRev = null;
	
	//liste avions en rev pour les tests
	
	String[] immatriAvion = {"A412 23z", "B52 Killer 12", "Magnum257", "A7315 B+"};
	String[] typeRev = {"grande", "petite", "petite", "grande"};
	GregorianCalendar[] datesRevisions = {new GregorianCalendar(2012, 4, 22), new GregorianCalendar(2012, 5, 23), new GregorianCalendar(2011, 11, 12), new GregorianCalendar(1983, 6, 4)};//mois: de 0 à 11
	


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_gerer_opera);
        listeAvionRev = (ListView)findViewById(R.id.listAvionRevision);
        
        afficherListeAvionRevision();
        
        listeAvionRev.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int position,
					long arg3) {
				// TODO Auto-generated method stub
				Intent t = new Intent(GererOperation.this, ListeOperations.class);
				t.putExtra("idRevision", position);  //il faut envoyer l'id de la revision correspondant à "position"
				startActivity(t);
			}
		});
        
    }// oncreate
    
    
    public void afficherListeAvionRevision() {
    	ArrayList<HashMap<String, String>> lAvions = new ArrayList<HashMap<String,String>>();
    	HashMap<String, String> avionRev = new HashMap<String, String>();
    	SimpleDateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy");
		String dateString = null;
		
		for(int i = 0; i < immatriAvion.length; i++) {
			avionRev = new HashMap<String, String>();
			avionRev.put("immatriculation", immatriAvion[i]);
			avionRev.put("typeRevision", typeRev[i]);
			dateString = dateFormat.format(datesRevisions[i].getTime());
			avionRev.put("dateRevision", dateString);
			lAvions.add(avionRev);
		}
		SimpleAdapter adapter = new SimpleAdapter(GererOperation.this, lAvions, R.layout.ligne_avion_en_revision, new String[] {"immatriculation","typeRevision","dateRevision"}, new int[] {R.id.TextImmatri, R.id.TextTypeRev, R.id.TextDateRev});
		listeAvionRev.setAdapter(adapter);
    }

    
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_gerer_opera, menu);
        return true;
    }
}
