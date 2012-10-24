package com.example.inssetairlines;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.GregorianCalendar;
import java.util.HashMap;
import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;

public class AfficherComment extends Activity {
	ListView listeComment = null;
	//creation des commentaires pour les tests:
	GregorianCalendar[] dateComment = {new GregorianCalendar(2012, 4, 22), new GregorianCalendar(2012, 5, 23), new GregorianCalendar(2011, 11, 12)};//mois: de 0 à 11
	String[] commentaires = {"Ceci est mon premier commentaire a entrer dans mon appli inssetAirlines. c'est du beau travail", "deuxième commentaire: le nouvel avion est très performant mais il faut changer les essuie-glaces","pour mon troisième commentaire, je vais être moins bavard"};
	String[] nomTechnicien = {"robert", "robert","roberto"};


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_afficher_comment);
        listeComment = (ListView)findViewById(R.id.listComment);
        
        afficherListeComment();
        
        listeComment.setOnItemClickListener(new OnItemClickListener() {

			@SuppressWarnings("unchecked")
			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int position,
					long arg3) {
				// TODO Auto-generated method stub
				HashMap<String, String> map = (HashMap<String, String>) listeComment.getItemAtPosition(position);
				alertDial(map);
				
			}
		});
    }
    
    public void afficherListeComment() {
    	ArrayList<HashMap<String, String>> lComment = new ArrayList<HashMap<String,String>>();
    	HashMap<String, String> comment = new HashMap<String, String>();
    	SimpleDateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy");
		String dateString = null;
    	for(int i = 0; i < dateComment.length; i++) {
    		comment = new HashMap<String, String>();
    		dateString = dateFormat.format(dateComment[i].getTime());
    		comment.put("date", dateString);
    		comment.put("comment", commentaires[i]);
    		comment.put("nomTechnicien", nomTechnicien[i]);
    		lComment.add(comment);
    	}
    	
    	SimpleAdapter adapter = new SimpleAdapter(AfficherComment.this, lComment, R.layout.ligne_comment, new String[] {"date","comment"}, new int[] {R.id.date, R.id.comment});
    	listeComment.setAdapter(adapter);
    }
    
    
	  public void alertDial(HashMap<String, String> map) {
	 
	  LayoutInflater factory = LayoutInflater.from(this); final View
	  alertDialogView = factory.inflate(R.layout.alert_dial_comment, null);
	  AlertDialog.Builder adb = new AlertDialog.Builder(this);
	  adb.setView(alertDialogView);
	  adb.setTitle("Détails du commentaire");
	  adb.setIcon(android.R.drawable.ic_dialog_alert);
	  TextView date = (TextView)alertDialogView.findViewById(R.id.textDate);
	  TextView nomTechni = (TextView)alertDialogView.findViewById(R.id.TextIdCreat);
	  TextView comment = (TextView)alertDialogView.findViewById(R.id.TextComment);
	  date.setText(map.get("date"));
	  nomTechni.setText(map.get("nomTechnicien"));
	  comment.setText(map.get("comment"));
	  adb.setPositiveButton("OK", new DialogInterface.OnClickListener() {public void onClick(DialogInterface dialog, int which) {
	  } 
	  });
	  
	  adb.show();
	  }
	 
    

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_afficher_comment, menu);
        return true;
    }
}
