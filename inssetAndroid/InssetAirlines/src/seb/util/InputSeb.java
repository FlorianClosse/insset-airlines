package seb.util;

import java.io.InputStream;
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
import org.apache.http.conn.scheme.PlainSocketFactory;
import org.apache.http.conn.scheme.Scheme;
import org.apache.http.conn.scheme.SchemeRegistry;
import org.apache.http.conn.ssl.SSLSocketFactory;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.impl.conn.SingleClientConnManager;

import com.example.inssetairlines.R;

import android.content.Context;
import android.os.AsyncTask;
import android.os.Handler;
import android.os.Message;
import android.util.Log;

public class InputSeb extends AsyncTask<String, String, String> {
	private ArrayList<NameValuePair> params;
	private String urlPhp;
	private Handler handler;
	private Context context;


	public InputSeb(String urlPhp, Handler handler, Context context) {
		setUrlPhp(urlPhp);
		this.handler = handler;
		this.context = context;
	}

	public void setUrlPhp(String urlPhp) {
		this.urlPhp = urlPhp;
	}

	@Override
	protected String doInBackground(String... arg0) {
		// TODO Auto-generated method stub
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
			registry.register(new Scheme("http", PlainSocketFactory.getSocketFactory(), 80));
			registry.register(new Scheme("https", socketFactory, 443));
			SingleClientConnManager mgr = new SingleClientConnManager(client.getParams(), registry);
			DefaultHttpClient hclient = new DefaultHttpClient(mgr, client.getParams());
			HttpsURLConnection.setDefaultHostnameVerifier(hostnameVerifier);
			HttpPost httppost = new HttpPost(urlPhp);
			httppost.setEntity(new UrlEncodedFormEntity(params));
			HttpResponse response = hclient.execute(httppost);
			HttpEntity entity = response.getEntity();
			entity.getContent();
		} catch (Exception e) {
			//Log.e("log_tag", "Error in http connection " + e.toString());
			IoSeb.erreur = "connection";
			Message message = handler.obtainMessage();
			message.what = 2;
			
			handler.sendMessage(message);

		}
		Message message = handler.obtainMessage();
		message.what = 1;
		handler.sendMessage(message);
		return null;
	}

	public void setParams(ArrayList<NameValuePair> params) {
		this.params = params;
	}
}
