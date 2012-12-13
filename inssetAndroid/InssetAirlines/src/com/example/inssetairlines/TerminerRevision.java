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
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.ListView;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.RadioGroup.OnCheckedChangeListener;
import android.widget.SimpleAdapter;
import android.widget.AdapterView.OnItemClickListener;

public class TerminerRevision extends Activity {

	ListView listeTerminerRevision = null;
	RadioGroup radioGroup = null;
	
	String[] numImmatri = { "avion1", "avion2", "avion3","avion4","avion5","avion6" };
	String[] typeRev = { "grande", "petite", "grande","petite","grande","petite" };
	String[] numImmatriResultatRequete = null;
	ArrayList<HashMap<String, String>> lAvions = null;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_terminer_revision);
        listeTerminerRevision = (ListView) findViewById(R.id.listViewTerminerRevision);
        listeTerminerRevision.setOnItemClickListener(listenerListeTerminerRevision);
        radioGroup = (RadioGroup)findViewById(R.id.radioGroupTypeRev);
        radioGroup.setOnCheckedChangeListener(listenerRadio);
      
        numImmatriResultatRequete = numImmatri;
        afficherListeCompleteTerminerRevision();
    }

    private OnCheckedChangeListener listenerRadio = new OnCheckedChangeListener() {
		
		@Override
		public void onCheckedChanged(RadioGroup group, int checkedId) {
			// TODO Auto-generated method stub
			if(checkedId == R.id.radioButtonPetite) {
				//requete ioseb pour petites rev seulement
				//a remplacer par la requete:
				int nbPetiteRev = 0;
				for(int i = 0; i < numImmatri.length; i++) {
					if(typeRev[i].contentEquals("petite")) {
						nbPetiteRev++;
					}
				}
				numImmatriResultatRequete = new String[nbPetiteRev];
				nbPetiteRev = 0;
				for(int i = 0; i < numImmatri.length; i++) {
					if(typeRev[i].contentEquals("petite")) {
						numImmatriResultatRequete[nbPetiteRev] = numImmatri[i];
						nbPetiteRev++;
					}
				}
			}
			if(checkedId == R.id.radioButtonGrande) {
				//requete ioseb pour grandes rev seulement
				//a remplacer par la requete:
				int nbGrandeRev = 0;
				for(int i = 0; i < numImmatri.length; i++) {
					if(typeRev[i].contentEquals("grande")) {
						nbGrandeRev++;
					}
				}
				numImmatriResultatRequete = new String[nbGrandeRev];
				nbGrandeRev = 0;
				for(int i = 0; i < numImmatri.length; i++) {
					if(typeRev[i].contentEquals("grande")) {
						numImmatriResultatRequete[nbGrandeRev] = numImmatri[i];
						nbGrandeRev++;
					}
				}
			}
			remplaceHandlerPourTests(); //a supprimer
			
			//le handler est appelé automatiquement pour l'affichage après la requète
		}
	};
    
    private OnItemClickListener listenerListeTerminerRevision = new OnItemClickListener() {

		@Override
		public void onItemClick(AdapterView<?> arg0, View arg1, int position,
				long arg3) {
			// TODO Auto-generated method stub
		HashMap<String,String> map = null;
		map = lAvions.get(position);
		String numImmatri = map.get("numImmatri");
		map = new HashMap<String,String>();
		map.put("numImmatri", numImmatri);
		map.put("termineOuiNon", "OUI");
		lAvions.set(position, map);
		SimpleAdapter adapter = new SimpleAdapter(TerminerRevision.this,
				lAvions, R.layout.ligne_terminer_revision,
				new String[] { "numImmatri","termineOuiNon" }, new int[] {
						R.id.TextViewImmatri,R.id.textViewTermineOuiNon});
		listeTerminerRevision.setAdapter(adapter);
		
		//terminer la revision choisie
			Intent t = new Intent(TerminerRevision.this, TerminerRevChoisie.class);
			t.putExtra("idRevisionChoisie", position); //remplacer position par l'id de la revision à terminer
			startActivity(t);
		}
	};
	
    private void afficherListeCompleteTerminerRevision() {
    	//mettre requete IoSeb ioSeb = new IoSeb(); ioSeb.ajoutParam
    	
    	remplaceHandlerPourTests();  //a supprimer
    }
    
    public void remplaceHandlerPourTests() {
    	lAvions = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> avionRev = new HashMap<String, String>();
		for (int i = 0; i < numImmatriResultatRequete.length; i++) { // remplacer numImmatriResultatRequete... par
										// IoSeb.tabResultats.length
			avionRev = new HashMap<String, String>();
			avionRev.put("numImmatri", numImmatriResultatRequete[i]); // remplacer
														// numImmatriResultatRequete[i] par
														// IoSeb.tabResultats[i][0]
			avionRev.put("termineOuiNon", "NON");
			lAvions.add(avionRev);
		}
		SimpleAdapter adapter = new SimpleAdapter(TerminerRevision.this,
				lAvions, R.layout.ligne_terminer_revision,
				new String[] { "numImmatri","termineOuiNon" }, new int[] {
						R.id.TextViewImmatri,R.id.textViewTermineOuiNon});
		listeTerminerRevision.setAdapter(adapter);
    }
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_terminer_revision, menu);
        return true;
    }
}
