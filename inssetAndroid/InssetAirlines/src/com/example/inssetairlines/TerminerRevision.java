package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import seb.util.IoSeb;
import seb.util.ToastSeb;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
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
	String[] numImmatri = null;
	String[] idRevision = null;
	ArrayList<HashMap<String, String>> lAvions = null;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_terminer_revision);
        listeTerminerRevision = (ListView) findViewById(R.id.listViewTerminerRevision);
        listeTerminerRevision.setOnItemClickListener(listenerListeTerminerRevision);
        radioGroup = (RadioGroup)findViewById(R.id.radioGroupTypeRev);
        radioGroup.setOnCheckedChangeListener(listenerRadio);
        afficherListeCompleteTerminerRevision();
    }

    private OnCheckedChangeListener listenerRadio = new OnCheckedChangeListener() {
		
		@Override
		public void onCheckedChanged(RadioGroup group, int checkedId) {
			// TODO Auto-generated method stub
			if(checkedId == R.id.radioButtonPetite) {
				IoSeb ioSeb = new IoSeb();
				ioSeb.ajoutParam("typeRev", "petite");
		    	ioSeb.outputSeb(UrlScriptsPhp.urlLireListeRevisionsAterminer, new String[] {"idRevision","immatriculationAvion"}, getApplicationContext(), handlerLireListeRevisionAterminer);
			}
			if(checkedId == R.id.radioButtonGrande) {
				IoSeb ioSeb = new IoSeb();
				ioSeb.ajoutParam("typeRev", "grande");
		    	ioSeb.outputSeb(UrlScriptsPhp.urlLireListeRevisionsAterminer, new String[] {"idRevision","immatriculationAvion"}, getApplicationContext(), handlerLireListeRevisionAterminer);
			}
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
		
			Intent t = new Intent(TerminerRevision.this, TerminerRevChoisie.class);
			t.putExtra("idRevisionChoisie", idRevision[position]);
			startActivity(t);
			finish();
		}
	};
	
    private void afficherListeCompleteTerminerRevision() {
    	IoSeb ioSeb = new IoSeb();
    	ioSeb.ajoutParam("typeRev", "tout");
    	ioSeb.outputSeb(UrlScriptsPhp.urlLireListeRevisionsAterminer, new String[] {"idRevision","immatriculationAvion"}, getApplicationContext(), handlerLireListeRevisionAterminer);
    }
    
    private Handler handlerLireListeRevisionAterminer = new Handler() {
    public void handleMessage(Message msg) {
    	lAvions = new ArrayList<HashMap<String, String>>();
    	numImmatri = new String[IoSeb.tabResultats.length];
    	idRevision = new String[IoSeb.tabResultats.length];
		HashMap<String, String> avionRev = new HashMap<String, String>();
		for (int i = 0; i < IoSeb.tabResultats.length; i++) {
			numImmatri[i] = IoSeb.tabResultats[i][1];
			idRevision[i] = IoSeb.tabResultats[i][0];
			avionRev = new HashMap<String, String>();
			avionRev.put("numImmatri", numImmatri[i]);
			avionRev.put("termineOuiNon", "NON");
			lAvions.add(avionRev);
		}
		SimpleAdapter adapter = new SimpleAdapter(TerminerRevision.this,
				lAvions, R.layout.ligne_terminer_revision,
				new String[] { "numImmatri","termineOuiNon" }, new int[] {
						R.id.TextViewImmatri,R.id.textViewTermineOuiNon});
		listeTerminerRevision.setAdapter(adapter);
    }
    };
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_terminer_revision, menu);
        return true;
    }
}
