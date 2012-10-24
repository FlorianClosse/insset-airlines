package com.example.inssetairlines;

import java.util.ArrayList;
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

public class ListeOperations extends Activity {
	ListView listeOperations = null;
	String[] nomOperations = {"changement du filtre � air", "changement du filtre � huile", "v�rification de l'ABS", "�talonnage de la sonde thermique", "v�rification du d�givrage arri�re", "Changement de la pompe � comburant"};
	

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_liste_operations);
        listeOperations = (ListView)findViewById(R.id.listOperations);
        afficherOperations();
        
        listeOperations.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int position,
					long arg3) {
				// TODO Auto-generated method stub
				Intent t = new Intent(ListeOperations.this, ValiderOperation.class);
				t.putExtra("idOperation", nomOperations[position]); //on envoie l'id de l'operation choisie au lieu du nom de l'operation
				startActivity(t);
			}
		});
    }
    
    
    public void afficherOperations() {
    	ArrayList<HashMap<String, String>> lOperations = new ArrayList<HashMap<String,String>>();
    	HashMap<String, String> operation = new HashMap<String, String>();
    	
    	for(int i = 0; i < nomOperations.length; i++) {
    		operation = new HashMap<String, String>();
    		operation.put("nomOperation", nomOperations[i]);
    		lOperations.add(operation);
    	}
    	
    	SimpleAdapter adapter = new SimpleAdapter(ListeOperations.this, lOperations, R.layout.ligne_operation, new String[] {"nomOperation"}, new int[] {R.id.TextNomOp});
    	listeOperations.setAdapter(adapter);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_liste_operations, menu);
        return true;
    }
}
