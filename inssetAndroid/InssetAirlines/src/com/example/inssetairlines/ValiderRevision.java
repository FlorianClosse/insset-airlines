package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import seb.util.ToastSeb;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.AdapterView.OnItemClickListener;

public class ValiderRevision extends Activity {

	ListView listeValiderRevision = null;
	ArrayList<HashMap<String, String>> lAvions = null;
	String[] numImmatri = { "avion1", "avion2", "avion3" };
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_valider_revision);
        listeValiderRevision = (ListView) findViewById(R.id.listViewValiderRevision);
        listeValiderRevision.setOnItemClickListener(listenerListeValiderRevision);
		afficherListeValiderRevision();
    }

	private OnItemClickListener listenerListeValiderRevision = new OnItemClickListener() {

		@Override
		public void onItemClick(AdapterView<?> arg0, View arg1, int position,
				long arg3) {
			// TODO Auto-generated method stub
			HashMap<String,String> map = null;
			map = lAvions.get(position);
			String numImmatri = map.get("numImmatri");
			map = new HashMap<String,String>();
			map.put("numImmatri", numImmatri);
			map.put("valideOuiNon", "OUI");
			lAvions.set(position, map);
			SimpleAdapter adapter = new SimpleAdapter(ValiderRevision.this,
					lAvions, R.layout.ligne_valider_revision,
					new String[] { "numImmatri","valideOuiNon" }, new int[] {
							R.id.TextViewImmatri,R.id.textViewValideOuiNon});
			listeValiderRevision.setAdapter(adapter);
			//requète à la base pour valider la revision choisie
			ToastSeb.toastSeb(getApplicationContext(), "révision validée"); //à mettre dans le handler aprés la requete.
		}
	};
    
    private void afficherListeValiderRevision() {
    	//mettre requete IoSeb ioSeb = new IoSeb(); ioSeb.ajoutParam
    	
    	remplaceHandlerPourTests();  //a supprimer
    }
    
    public void remplaceHandlerPourTests() {
    	lAvions = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> avionRev = new HashMap<String, String>();
		for (int i = 0; i < 3; i++) { // remplacer 3 par
										// IoSeb.tabResultats.length
			avionRev = new HashMap<String, String>();
			avionRev.put("numImmatri", numImmatri[i]); // remplacer
														// numImmatri[i] par
														// IoSeb.tabResultats[i][0]
			avionRev.put("valideOuiNon", "NON");
			lAvions.add(avionRev);
		}
		SimpleAdapter adapter = new SimpleAdapter(ValiderRevision.this,
				lAvions, R.layout.ligne_valider_revision,
				new String[] { "numImmatri","valideOuiNon" }, new int[] {
						R.id.TextViewImmatri, R.id.textViewValideOuiNon});
		listeValiderRevision.setAdapter(adapter);
    }
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_valider_revision, menu);
        return true;
    }
}
