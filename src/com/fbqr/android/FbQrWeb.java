package com.fbqr.android;

import android.app.Activity;
import android.os.Bundle;
import android.webkit.WebView;

public class FbQrWeb extends Activity{
	private String access_token;
	WebView browser;
	FbQrDatabase db=new FbQrDatabase(this);
	 public void onCreate(Bundle savedInstanceState){
		 super.onCreate(savedInstanceState);		 
		 setContentView(R.layout.web);
		 browser=(WebView)findViewById(R.id.webkit);
	 }
	 public void onResume(){
		 super.onResume();
		 access_token=db.getAccessToken();
		 String URL="http://fbqr.tkroputa.in.th/a/"+"index.php?access_token="+access_token;
		 browser.loadUrl(URL);
		 browser.getSettings().setJavaScriptEnabled(true);
	 }
}