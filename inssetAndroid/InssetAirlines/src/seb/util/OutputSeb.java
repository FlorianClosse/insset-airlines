package seb.util;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.security.KeyStore;
import java.util.ArrayList;

import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.conn.scheme.Scheme;
import org.apache.http.conn.scheme.SchemeRegistry;
import org.apache.http.conn.ssl.SSLSocketFactory;
import org.apache.http.conn.ssl.X509HostnameVerifier;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.impl.conn.SingleClientConnManager;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.example.inssetairlines.R;

import android.content.Context;
import android.os.AsyncTask;
import android.os.Handler;
import android.util.Log;

public class OutputSeb extends AsyncTask<String, Integer, String> {
	private ArrayList<NameValuePair> params;
	private String urlPhp;
	private String[] nomCol;
	private String[][] res;
	private Handler handler;
	private Context context;

	public OutputSeb(String urlPhp, String[] nomCol, Context context,
			Handler handler) {
		this.urlPhp = urlPhp;
		this.nomCol = nomCol;
		this.handler = handler;
		this.context = context;
	}

	public String[][] getRes() {
		return this.res;
	}
	
	public void setParams(ArrayList<NameValuePair> params) {
		this.params = params;
	}

	protected String doInBackground(String... arg0) {
		// TODO Auto-generated method stub
		InputStream is = null;
		String resultat = "";
		try {
			
			HostnameVerifier hostnameVerifier = org.apache.http.conn.ssl.SSLSocketFactory.ALLOW_ALL_HOSTNAME_VERIFIER;
			DefaultHttpClient client = new DefaultHttpClient();
			SchemeRegistry registry = new SchemeRegistry();
			SSLSocketFactory socketFactory = null;
			KeyStore trusted = KeyStore.getInstance("BKS");
			InputStream in = context.getResources().openRawResource(R.raw.mykeystore);
			try {
				trusted.load(in, "android".toCharArray());
			}finally {
					in.close();
			}
			socketFactory = new SSLSocketFactory(trusted);
			socketFactory.setHostnameVerifier(SSLSocketFactory.STRICT_HOSTNAME_VERIFIER);

			registry.register(new Scheme("https", socketFactory, 443));
			SingleClientConnManager mgr = new SingleClientConnManager(client.getParams(), registry);
			DefaultHttpClient hclient = new DefaultHttpClient(mgr, client.getParams());
			HttpsURLConnection.setDefaultHostnameVerifier(hostnameVerifier);
			HttpPost hpost = new HttpPost(urlPhp);
			hpost.setEntity(new UrlEncodedFormEntity(params));
			
			HttpResponse response = hclient.execute(hpost);
			HttpEntity entity = response.getEntity();
			is = entity.getContent();
		} catch (Exception e) {
			Log.e("log_tag", "Erreur dans connection http" + e.getMessage());
			IoSeb.erreur = "connection";
			
		}
		
		if(!IoSeb.erreur.equals("connection")) {
			try {
				BufferedReader reader = new BufferedReader(new InputStreamReader(
						is, "ISO-8859-1"), 8);
				StringBuilder sb = new StringBuilder();	
				String line = null;
				while ((line = reader.readLine()) != null) {
					sb.append(line + "\n");
				}
				is.close();
				resultat = sb.toString();
			} catch (Exception e) {
				//Log.e("log_tag", "Erreur de convertion du resultat" + e.toString());
				IoSeb.erreur = "convertion";
			}
		}
		if(!IoSeb.erreur.equals("convertion") && !IoSeb.erreur.equals("connection")) {
			try {
				JSONArray jArray = new JSONArray(resultat);
				res = new String[jArray.length()][nomCol.length];
				for (int i = 0; i < jArray.length(); i++) {
					JSONObject json_data = null;
					json_data = jArray.getJSONObject(i);
					for (int j = 0; j < nomCol.length; j++) {
						res[i][j] = json_data.getString(nomCol[j]);
					}
				}
			} catch (JSONException e) {
				//Log.e("log_tag", "Erreur recuperation donnees" + e.toString());
				//res = new String[0][0];
				IoSeb.erreur = "recuperation";
			}
		
		IoSeb.tabResultats = res; // resultats de la requete stockés dans
		}							// IoSeb.tabResultats
		handler.sendMessage(handler.obtainMessage());
		return null;
	}
	
}
