package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import seb.util.ToastSeb;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class AjouterAvion extends Activity {
	ImageButton boutonMod = null;
	ListView listModele = null;
	ImageButton boutonAero = null;
	ListView listAero = null;
	ImageButton newModele = null;
	//liste de modele pour les tests
	String[] modeles = {"modele0", "modele1", "modele2", "modele3", "modele4", "modele5", "modele6", "modele7"};
	//liste d'aeroports pour les tests
	String[] aeroports = {"aeroport0", "aeroport1", "aeroport2", "aeroport3", "aeroport4", "aeroport5", "aeroport6", "aeroport7", "aeroport8", "aeroport9", "aeroport10", "aeroport11", "aeroport12", "aeroport13", "aeroport14"};
	

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ajouter_avion);
        boutonMod = (ImageButton)findViewById(R.id.boutonModele);
        listModele = (ListView)findViewById(R.id.listModele);
        boutonAero = (ImageButton)findViewById(R.id.boutonAeroport);
        listAero = (ListView)findViewById(R.id.listAeroport);
        newModele = (ImageButton)findViewById(R.id.newModele);
        
        initialiserListModele();
        initialiserListAero();
       
        
        boutonMod.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				ArrayList<HashMap<String, String>> lModele = new ArrayList<HashMap<String,String>>();
				HashMap<String, String> modele;
				for(int i = 0; i<modeles.length; i++) {
				modele = new HashMap<String, String>();
		        modele.put("nomModele", modeles[i]);
		        lModele.add(modele);
				}
				 SimpleAdapter adaptater = new SimpleAdapter(AjouterAvion.this, lModele, R.layout.ligne_modele_aeroport, new String[] {"nomModele"}, new int[] {R.id.nom_ligne});
				 listModele.setAdapter(adaptater);
				 listModele.setEnabled(true);
			}
		});
        
        listModele.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int position,
					long arg3) {
				// TODO Auto-generated method stub
				//on accede a la table pour savoir a quel modele correspond "position"
				//toast de test:
				ToastSeb.toastSeb(AjouterAvion.this, "modele choisi: "+modeles[position]);
				initialiserListModele();
				
			}
		});
        
 boutonAero.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				ArrayList<HashMap<String, String>> lAero = new ArrayList<HashMap<String,String>>();
				HashMap<String, String> aero;
				for(int i = 0; i<aeroports.length; i++) {
				aero = new HashMap<String, String>();
		        aero.put("nomAero", aeroports[i]);
		        lAero.add(aero);
				}
				 SimpleAdapter adaptater = new SimpleAdapter(AjouterAvion.this, lAero, R.layout.ligne_modele_aeroport, new String[] {"nomAero"}, new int[] {R.id.nom_ligne});
				 listAero.setAdapter(adaptater);
				 listAero.setEnabled(true);
			}
		});
        
        listAero.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int position,
					long arg3) {
				// TODO Auto-generated method stub
				//on accede a la table pour savoir a quel aeroport correspond "position"
				//toast de test:
				ToastSeb.toastSeb(AjouterAvion.this, "aeroport choisi: "+aeroports[position]);
				initialiserListAero();
				
			}
		}); 
        
        newModele.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent t = new Intent(AjouterAvion.this, AjouterModele.class);
				startActivity(t);
				
			}
		});
        
    }

    public void initialiserListModele() {
    	 listModele.setEnabled(false);
         
         ArrayList<HashMap<String, String>> lModele = new ArrayList<HashMap<String,String>>();
         HashMap<String, String> modele = new HashMap<String, String>();
         modele.put("nomModele", "nom du modele");
         lModele.add(modele);
         
         SimpleAdapter adaptater = new SimpleAdapter(AjouterAvion.this, lModele, R.layout.ligne_modele_aeroport, new String[] {"nomModele"}, new int[] {R.id.nom_ligne});
         listModele.setAdapter(adaptater);
    }
    
    public void initialiserListAero() {
    	listAero.setEnabled(false);
         
         ArrayList<HashMap<String, String>> lAero = new ArrayList<HashMap<String,String>>();
         HashMap<String, String> aero = new HashMap<String, String>();
         aero.put("nomAero", "nom de l'aéroport");
         lAero.add(aero);
         
         SimpleAdapter adaptater = new SimpleAdapter(AjouterAvion.this, lAero, R.layout.ligne_modele_aeroport, new String[] {"nomAero"}, new int[] {R.id.nom_ligne});
         listAero.setAdapter(adaptater);
    }
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_ajouter_avion, menu);
        return true;
    }
}
