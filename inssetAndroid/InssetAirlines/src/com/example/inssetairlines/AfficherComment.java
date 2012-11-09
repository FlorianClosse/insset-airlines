package com.example.inssetairlines;

import java.util.ArrayList;
import java.util.HashMap;

import seb.util.IoSeb;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
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
	Commentaire[] commentaires = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_afficher_comment);
		Intent t = getIntent();
		int idAvion = t.getIntExtra("idAvion", 1);
		listeComment = (ListView) findViewById(R.id.listComment);

		IoSeb ioSeb = new IoSeb();
		ioSeb.ajoutParam("idAvion", String.valueOf(idAvion));
		ioSeb.outputSeb(UrlScriptsPhp.urlLireCommentairesAvion, new String[] {
				"idCommentaire", "idAvion", "commentaire", "dateCommentaire" },
				getApplicationContext(), handlerListeCommentairesAvion);

		listeComment.setOnItemClickListener(new OnItemClickListener() {

			@SuppressWarnings("unchecked")
			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1,
					int position, long arg3) {
				// TODO Auto-generated method stub
				HashMap<String, String> map = (HashMap<String, String>) listeComment
						.getItemAtPosition(position);
				alertDial(map);

			}
		});
	}

	Handler handlerListeCommentairesAvion = new Handler() {
		public void handleMessage(Message msg) {
			if (IoSeb.tabResultats.length != 0) {
				commentaires = new Commentaire[IoSeb.tabResultats.length];
				String[] resultat = new String[IoSeb.tabResultats[0].length];
				for (int i = 0; i < IoSeb.tabResultats.length; i++) {
					for (int j = 0; j < IoSeb.tabResultats[i].length; j++) {
						resultat[j] = IoSeb.tabResultats[i][j];
					}
					commentaires[i] = new Commentaire(resultat);
				}
				afficherListeComment();
				IoSeb.viderTabResultats();
			}
		}
	};

	public void afficherListeComment() {
		ArrayList<HashMap<String, String>> lComment = new ArrayList<HashMap<String, String>>();
		HashMap<String, String> comment = new HashMap<String, String>();
		for (int i = 0; i < commentaires.length; i++) {
			comment = new HashMap<String, String>();
			comment.put("date", commentaires[i].getDateCommentaire());
			comment.put("comment", commentaires[i].getCommentaire());
			comment.put("nomTechnicien", "Robert");
			lComment.add(comment);
		}

		SimpleAdapter adapter = new SimpleAdapter(AfficherComment.this,
				lComment, R.layout.ligne_comment, new String[] { "date",
						"comment" }, new int[] { R.id.date, R.id.comment });
		listeComment.setAdapter(adapter);
	}

	public void alertDial(HashMap<String, String> map) {

		LayoutInflater factory = LayoutInflater.from(this);
		final View alertDialogView = factory.inflate(
				R.layout.alert_dial_comment, null);
		AlertDialog.Builder adb = new AlertDialog.Builder(this);
		adb.setView(alertDialogView);
		adb.setTitle("Détails du commentaire");
		adb.setIcon(android.R.drawable.ic_dialog_alert);
		TextView date = (TextView) alertDialogView.findViewById(R.id.textDate);
		TextView nomTechni = (TextView) alertDialogView
				.findViewById(R.id.TextIdCreat);
		TextView comment = (TextView) alertDialogView
				.findViewById(R.id.TextComment);
		date.setText(map.get("date"));
		nomTechni.setText(map.get("nomTechnicien"));
		comment.setText(map.get("comment"));
		adb.setPositiveButton("OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int which) {
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
