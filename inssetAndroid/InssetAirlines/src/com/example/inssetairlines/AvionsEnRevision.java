package com.example.inssetairlines;

import android.app.Activity;
import android.os.Bundle;
import android.view.Menu;

public class AvionsEnRevision extends Activity {

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_avions_en_revision);
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_avions_en_revision, menu);
		return true;
	}
}
