package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import seb.util.IoSeb;
import seb.util.ToastSeb;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class AjouterAvion extends Activity {
	ImageButton boutonMod = null;
	ListView listModele = null;
	ImageButton boutonAero = null;
	ListView listAero = null;
	ImageButton newModele = null;
	String[][] modeles;
	String[][] aeroports;
	private Avion avion;
	private EditText editImmatri;
	private EditText editDateMisEnService;
	private Button boutonValider;

	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ajouter_avion);
        boutonMod = (ImageButton)findViewById(R.id.boutonModele);
        listModele = (ListView)findViewById(R.id.listModele);
        boutonAero = (ImageButton)findViewById(R.id.boutonAeroport);
        listAero = (ListView)findViewById(R.id.listAeroport);
        newModele = (ImageButton)findViewById(R.id.newModele);
        editImmatri = (EditText)findViewById(R.id.editText1);
        editDateMisEnService = (EditText)findViewById(R.id.editText2);
        boutonValider = (Button)findViewById(R.id.valider);
        avion = new Avion(getApplicationContext());
        
        initialiserListModele("nom du modèle");
        initialiserListAero("nom de l'aéroport");
        

        boutonMod.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				 IoSeb ioSeb = new IoSeb();
				 ioSeb.ajoutParam("nomTable", "modele");
				 ioSeb.outputSeb(UrlScriptsPhp.urlListeModeleOuAeroport, new String[] {"idModele","nomModele"}, getApplicationContext(), handlerListeModele);
			}
				
		});
        
        listModele.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int position,
					long arg3) {
				// TODO Auto-generated method stub
				//on accede a la table pour savoir a quel modele correspond "position"
				//toast de test:
				ToastSeb.toastSeb(AjouterAvion.this, "modele "+modeles[position][0]+" choisi: "+modeles[position][1]);
				avion.setIdModele(Integer.parseInt(modeles[position][0]));
				initialiserListModele(modeles[position][1]);
				
			}
		});
        
        boutonAero.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				IoSeb ioSeb = new IoSeb();
				ioSeb.ajoutParam("nomTable", "aeroport");
				ioSeb.outputSeb(UrlScriptsPhp.urlListeModeleOuAeroport, new String[] {"idAeroport","nomAeroport"}, getApplicationContext(), handlerListeAeroport);
			}
				
		});
        
        listAero.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int position,
					long arg3) {
				// TODO Auto-generated method stub
				//on accede a la table pour savoir a quel aeroport correspond "position"
				//toast de test:
				ToastSeb.toastSeb(AjouterAvion.this, "aeroport "+aeroports[position][0]+" choisi: "+aeroports[position][1]);
				avion.setIdAeroport(Integer.parseInt(aeroports[position][0]));
				initialiserListAero(aeroports[position][1]);
				
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
        
        boutonValider.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				avion.setNumImmatriculation(editImmatri.getText().toString());
				avion.setDateMisEnService(editDateMisEnService.getText().toString());
				avion.ajouterAvion();
			}
		});
        
    }//onCreate
	
	 Handler handlerListeModele = new Handler() { // fonction appelee quand le 2eme thread
			// envoie un message et se termine
		 @Override
		 public void handleMessage(Message msg) {
			 modeles = IoSeb.tabResultats;
			// seb.util.ToastSeb.toastSeb(getApplicationContext(), String.valueOf(modeles.length));
			 ArrayList<HashMap<String, String>> lModele = new ArrayList<HashMap<String,String>>();
				HashMap<String, String> modele;
				for(int i = 0; i<modeles.length; i++) {
				modele = new HashMap<String, String>();
		        modele.put("nomModele", modeles[i][1]);
		        lModele.add(modele);
				}
				 SimpleAdapter adaptater = new SimpleAdapter(AjouterAvion.this, lModele, R.layout.ligne_modele_aeroport, new String[] {"nomModele"}, new int[] {R.id.nom_ligne});
				 listModele.setAdapter(adaptater);
				 listModele.setEnabled(true);
			}
		 };
		 
		 Handler handlerListeAeroport = new Handler() { // fonction appelee quand le 2eme thread
				// envoie un message et se termine
			 @Override
			 public void handleMessage(Message msg) {
				 aeroports = IoSeb.tabResultats;
				// seb.util.ToastSeb.toastSeb(getApplicationContext(), String.valueOf(aeroports.length));
				 ArrayList<HashMap<String, String>> lAero = new ArrayList<HashMap<String,String>>();
					HashMap<String, String> aero;
					for(int i = 0; i<aeroports.length; i++) {
					aero = new HashMap<String, String>();
			        aero.put("nomAero", aeroports[i][1]);
			        lAero.add(aero);
					}
					 SimpleAdapter adaptater = new SimpleAdapter(AjouterAvion.this, lAero, R.layout.ligne_modele_aeroport, new String[] {"nomAero"}, new int[] {R.id.nom_ligne});
					 listAero.setAdapter(adaptater);
					 listAero.setEnabled(true);
				}
			 };
			 
			

	public void initialiserListModele(String nomDuModele) {
		listModele.setEnabled(false);

		ArrayList<HashMap<String, String>> lModele = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> modele = new HashMap<String, String>();
		modele.put("nomModele", nomDuModele);
		lModele.add(modele);

		SimpleAdapter adaptater = new SimpleAdapter(AjouterAvion.this, lModele,
				R.layout.ligne_modele_aeroport, new String[] { "nomModele" },
				new int[] { R.id.nom_ligne });
		listModele.setAdapter(adaptater);
	}

	public void initialiserListAero(String nomDeAeroport) {
		listAero.setEnabled(false);

		ArrayList<HashMap<String, String>> lAero = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> aero = new HashMap<String, String>();
		aero.put("nomAero", nomDeAeroport);
		lAero.add(aero);

		SimpleAdapter adaptater = new SimpleAdapter(AjouterAvion.this, lAero,
				R.layout.ligne_modele_aeroport, new String[] { "nomAero" },
				new int[] { R.id.nom_ligne });
		listAero.setAdapter(adaptater);
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_ajouter_avion, menu);
		return true;
	}
}
