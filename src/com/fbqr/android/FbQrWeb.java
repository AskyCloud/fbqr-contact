package com.fbqr.android;

import android.R.color;
import android.app.Activity;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.webkit.WebView;
import android.widget.Toast;

public class FbQrWeb extends Activity{
	private String access_token;
	WebView browser;
	FbQrDatabase db=null;
	
	 public void onCreate(Bundle savedInstanceState){
		 super.onCreate(savedInstanceState);		 
		 setContentView(R.layout.web);
		 browser=(WebView)findViewById(R.id.webkit);
		 //browser.setBackgroundColor(color.white);
	 }
	 
	 public void onResume(){
		 super.onResume();
		 db=new FbQrDatabase(this);
		 if(isOnline()){
			 Toast.makeText(this, "Loading", Toast.LENGTH_LONG).show();
			 //browser.setBackgroundColor(color.white);
			 access_token=db.getAccessToken();
			 String URL="http://fbqr.tkroputa.in.th/a/"+"index.php?access_token="+access_token;
			 browser.loadUrl(URL);
			 browser.getSettings().setJavaScriptEnabled(true);
		 }//else browser.setBackgroundColor(color.black);
	 }
	 
	 public void onPause(){
		 super.onPause();
		 db.close();
	 }
	 
	   public boolean isOnline() {		   
		    ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
		    NetworkInfo netInfo = cm.getActiveNetworkInfo();
		    if (netInfo != null && netInfo.isConnectedOrConnecting()){
		    	if(db.getAccessToken()!=null)
		    		return true;
		    	else{
		    		Toast.makeText(this, "Please Login", Toast.LENGTH_LONG).show();
		    		return false;
		    	}
		    }
		    else {
		    	Toast.makeText(this, "No Internet Connection", Toast.LENGTH_LONG).show();
		    	return false;
		    }
		}
}