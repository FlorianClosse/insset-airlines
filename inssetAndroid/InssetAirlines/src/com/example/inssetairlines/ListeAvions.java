package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class ListeAvions extends Activity {
	ListView listeAvions = null;
	Button ajouterAvion = null;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_liste_avions);
        listeAvions = (ListView)findViewById(R.id.listeAvions);
        ajouterAvion = (Button)findViewById(R.id.ajouter);
        
        ArrayList<HashMap<String, String>> listItem = new ArrayList<HashMap<String, String>>();
        HashMap<String, String> item = new HashMap<String, String>();
    	item.put("nom", "avion1");
    	listItem.add(item);

    	item = new HashMap<String, String>();
    	item.put("nom", "avion2");
    	listItem.add(item);
    	
    	item = new HashMap<String, String>();
    	item.put("nom", "avion3");
    	listItem.add(item);
    	
    	item = new HashMap<String, String>();
    	item.put("nom", "avion4");
    	listItem.add(item);
    	
   	 SimpleAdapter mSchedule = new SimpleAdapter (this.getBaseContext(), listItem, R.layout.ligne_avion,
			 new String[] {"nom"}, new int[] {R.id.nomAvion});
   	 
   	 listeAvions.setAdapter(mSchedule);
   	 
   	 listeAvions.setOnItemClickListener(new OnItemClickListener() {

		@Override
		public void onItemClick(AdapterView<?> arg0, View arg1, int position,
				long arg3) {
			// TODO Auto-generated method stub
			HashMap<String, String> item = (HashMap<String, String>) listeAvions.getItemAtPosition(position);
			Intent t = new Intent(ListeAvions.this, FicheAvion.class);
			//Intent intent = new Intent(MainActivity.this, MainActivity.class);
      		t.putExtra("nomAvion", item.get("nom"));
      		startActivity(t);
		}
	});
   	 
   	 ajouterAvion.setOnClickListener(new OnClickListener() {
		
		@Override
		public void onClick(View v) {
			// TODO Auto-generated method stub
			Intent t = new Intent(ListeAvions.this, AjouterAvion.class);
			startActivity(t);
		}
	});
   	 
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_liste_avions, menu);
        return true;
    }
}
