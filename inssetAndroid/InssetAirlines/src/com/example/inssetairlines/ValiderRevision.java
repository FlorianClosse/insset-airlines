package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.GregorianCalendar;
import java.util.HashMap;

import seb.util.IoSeb;
import seb.util.ToastSeb;
import android.app.Activity;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class ValiderRevision extends Activity {

	ListView listeValiderRevision = null;
	ArrayList<HashMap<String, String>> lAvions = null;
	String[] numImmatri = null;
	String[] idRevision = null;
	String[] idAvion = null;
	String dateDuJour = null;
	Boolean[] isValide = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_valider_revision);
		listeValiderRevision = (ListView) findViewById(R.id.listViewValiderRevision);
		listeValiderRevision
				.setOnItemClickListener(listenerListeValiderRevision);
		GregorianCalendar calendar = new GregorianCalendar();
		dateDuJour = String.valueOf(calendar.get(Calendar.YEAR)) + "-"
				+ String.valueOf(calendar.get(Calendar.MONTH) + 1) + "-"
				+ String.valueOf(calendar.get(Calendar.DAY_OF_MONTH));
		afficherListeValiderRevision();
	}

	private OnItemClickListener listenerListeValiderRevision = new OnItemClickListener() {

		@Override
		public void onItemClick(AdapterView<?> arg0, View arg1, int position,
				long arg3) {
			// TODO Auto-generated method stub

			if (!isValide[position]) {
				listeValiderRevision.setEnabled(false);
				HashMap<String, String> map = null;
				map = lAvions.get(position);
				String numImmatri = map.get("numImmatri");
				map = new HashMap<String, String>();
				map.put("numImmatri", numImmatri);
				map.put("valideOuiNon", "OUI");
				lAvions.set(position, map);
				isValide[position] = true;
				IoSeb ioSeb = new IoSeb();
				ioSeb.ajoutParam("idRevision", idRevision[position]);
				ioSeb.ajoutParam("dateDuJour", dateDuJour);
				ioSeb.ajoutParam("idAvion", idAvion[position]);
				ioSeb.inputSeb(UrlScriptsPhp.urlValiderRevision,
						handlerValidationRevision, getApplicationContext());
			}
		}
	};

	private void afficherListeValiderRevision() {

		IoSeb ioSeb = new IoSeb();
		ioSeb.ajoutParam("dateDuJour", dateDuJour);
		ioSeb.outputSeb(
				UrlScriptsPhp.urlLireListeRevisionsAvalider,
				new String[] { "idRevision", "immatriculationAvion", "idAvion" },
				getApplicationContext(), handlerLireRevisionAvalider);
	}

	private Handler handlerLireRevisionAvalider = new Handler() {
		public void handleMessage(Message msg) {
			numImmatri = new String[IoSeb.tabResultats.length];
			idAvion = new String[IoSeb.tabResultats.length];
			idRevision = new String[IoSeb.tabResultats.length];
			isValide = new Boolean[IoSeb.tabResultats.length];
			lAvions = new ArrayList<HashMap<String, String>>();
			HashMap<String, String> avionRev = new HashMap<String, String>();
			for (int i = 0; i < IoSeb.tabResultats.length; i++) {
				isValide[i] = false;
				numImmatri[i] = IoSeb.tabResultats[i][1];
				idRevision[i] = IoSeb.tabResultats[i][0];
				idAvion[i] = IoSeb.tabResultats[i][2];
				avionRev = new HashMap<String, String>();
				avionRev.put("numImmatri", numImmatri[i]);
				avionRev.put("valideOuiNon", "NON");
				lAvions.add(avionRev);
			}
			SimpleAdapter adapter = new SimpleAdapter(ValiderRevision.this,
					lAvions, R.layout.ligne_valider_revision, new String[] {
							"numImmatri", "valideOuiNon" }, new int[] {
							R.id.TextViewImmatri, R.id.textViewValideOuiNon });
			listeValiderRevision.setAdapter(adapter);
		}
	};

	private Handler handlerValidationRevision = new Handler() {
		public void handleMessage(Message msg) {
			SimpleAdapter adapter = new SimpleAdapter(ValiderRevision.this,
					lAvions, R.layout.ligne_valider_revision, new String[] {
							"numImmatri", "valideOuiNon" }, new int[] {
							R.id.TextViewImmatri, R.id.textViewValideOuiNon });
			listeValiderRevision.setAdapter(adapter);
			listeValiderRevision.setEnabled(true);
			ToastSeb.toastSeb(getApplicationContext(), "révision validée");
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_valider_revision, menu);
		return true;
	}
}
