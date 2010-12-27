package com.fbqr.android;

import android.app.Activity;
import android.os.Bundle;
import android.webkit.WebView;

public class FbQrWeb extends Activity{
	private String access_token;
	WebView browser;
	
	 public void onCreate(Bundle savedInstanceState){
		 super.onCreate(savedInstanceState);
		 
		 Bundle extras = getIntent().getExtras(); 
		 if(extras !=null)
		 {
			 access_token = extras.getString("access_token");
		 }

		 setContentView(R.layout.main2);
		 browser=(WebView)findViewById(R.id.webkit);
		 access_token="146472442045328|d5fa47fe1faab31cf9694a8d-100001036241534|e_BgsO6N9FHqLoyKJUAZEvjcl10";
		 String URL="http://fbqr.tkroputa.in.th/a/"+"index.php?access_token="+access_token;
		 browser.loadUrl(URL);
		 browser.getSettings().setJavaScriptEnabled(true);

	 }
}