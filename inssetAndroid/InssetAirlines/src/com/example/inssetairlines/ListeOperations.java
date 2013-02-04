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
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.SimpleAdapter;

public class ListeOperations extends Activity {
	ListView listeOperations = null;
	String idRevision;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_liste_operations);
		listeOperations = (ListView) findViewById(R.id.listOperations);
		Intent t = getIntent();
		idRevision = t.getStringExtra("idRevision");
		afficherOperations();

		listeOperations.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1,
					int position, long arg3) {
				// TODO Auto-generated method stub
				Intent t = new Intent(ListeOperations.this,
						ValiderOperation.class);
				t.putExtra("idOperation", IoSeb.tabResultats[position][0]);
				finish();
				startActivity(t);
			}
		});
	}

	public void afficherOperations() {

		IoSeb ioSeb = new IoSeb();
		ioSeb.ajoutParam("idRevision", idRevision);
		ioSeb.outputSeb(UrlScriptsPhp.urlLireListeOperations, new String[] {
				"idOperation", "nomOperationType" }, getApplicationContext(),
				handlerLireListeOperations);
	}

	Handler handlerLireListeOperations = new Handler() {
		public void handleMessage(Message msg) {
			ToastSeb.toastSeb(getApplicationContext(), "nombre d'opérations: "
					+ String.valueOf(IoSeb.tabResultats.length));
			ArrayList<HashMap<String, String>> lOperations = new ArrayList<HashMap<String, String>>();
			HashMap<String, String> operation = new HashMap<String, String>();

			for (int i = 0; i < IoSeb.tabResultats.length; i++) {
				operation = new HashMap<String, String>();
				operation.put("nomOperation", IoSeb.tabResultats[i][1]);
				lOperations.add(operation);
			}
			SimpleAdapter adapter = new SimpleAdapter(ListeOperations.this,
					lOperations, R.layout.ligne_operation,
					new String[] { "nomOperation" },
					new int[] { R.id.TextNomOp });
			listeOperations.setAdapter(adapter);
		}
	};

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_liste_operations, menu);
		return true;
	}
}
