package com.fbqr.android;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

import org.json.JSONException;
import org.json.JSONObject;


import android.app.Activity;
import android.app.TabActivity;
import android.content.Context;
import android.content.Intent;
import android.content.res.Resources;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.Contacts.People;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TabHost;
import android.widget.TabHost.TabSpec;
import android.widget.TextView;
import android.widget.Toast;



import com.facebook.android.*;
import com.facebook.android.Facebook.DialogListener;

public class FbQrAndroid extends TabActivity{
		public static final String APP_ID = "146472442045328";
		
		private Facebook facebook;
		private AsyncFacebookRunner mAsyncRunner;
		Button button,button2,button3,button4;
		private TextView tv;
		SOAPConnected mSoap = new SOAPConnected(FbQrAndroid.this);
		FbQrDatabase db=new FbQrDatabase(this);
		ReadFbQR readQR=new ReadFbQR() ;
 
	   /** Called when the activity is first created. */
	   @Override
	   public void onCreate(Bundle savedInstanceState) {
	       super.onCreate(savedInstanceState);
	       
           //Facebook
	       facebook = new Facebook(APP_ID);		    
	       mAsyncRunner = new AsyncFacebookRunner(facebook);      
	       
	       if(isOnline()){
	    	   facebook.setAccessToken(db.getAccessToken());
	    	   mAsyncRunner.request("me", new TokenRequestListener());
	       }	       
	       
	       //GUI
	       Resources res = getResources(); // Resource object to get Drawables
	       TabHost tabHost = getTabHost();  // The activity TabHost
	       TabHost.TabSpec spec;  // Resusable TabSpec for each tab
	       Intent intent;  // Reusable Intent for each tab
	       
	    // Create an Intent to launch an Activity for the tab (to be reused)
	       intent = new Intent().setClass(this, FbQrContactlist.class);

	       // Initialize a TabSpec for each tab and add it to the TabHost
	       spec = tabHost.newTabSpec("contact").setIndicator("Contact",
	                         res.getDrawable(R.drawable.tab_one))
	                     .setContent(intent);
	       tabHost.addTab(spec);

	       // Do the same for the other tabs
	       intent = new Intent().setClass(this, FbQrWeb.class);
	       intent.putExtra("access_token", facebook.getAccessToken());
	       spec = tabHost.newTabSpec("profile").setIndicator("Profile",
	                         res.getDrawable(R.drawable.tab_one))
	                     .setContent(intent);
	       tabHost.addTab(spec);

	       //
	       // Initialize a TabSpec for each tab and add it to the TabHost
	       intent = new Intent().setClass(this, FbQrBackground.class);
  	       intent.putExtra("MODE", "READQR");
	       spec = tabHost.newTabSpec("readqr").setIndicator("ReadQR",
	                         res.getDrawable(R.drawable.tab_one))
	                     .setContent(intent);	       
	         
	       tabHost.addTab(spec);	       
	       tabHost.setCurrentTab(0);       
	     }

	   public boolean isOnline() {		   
		    ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
		    NetworkInfo netInfo = cm.getActiveNetworkInfo();
		    if (netInfo != null && netInfo.isConnectedOrConnecting()) return true;		    
		    else return false;
		}	   
	      
	   class AuthorizeListener implements DialogListener {
		   
		   public void onComplete(Bundle values) {
			   Toast.makeText(FbQrAndroid.this, "logined", Toast.LENGTH_LONG).show();
			   //Get PhoneBook
			   if(db.getAccessToken()==null){    
				   Toast.makeText(FbQrAndroid.this, "Downloading PhoneBook", Toast.LENGTH_LONG).show();
				   mSoap.getPhoneBook(facebook.getAccessToken(),new getData());
			   }
			   db.setAccessToken(facebook.getAccessToken());  
		   }
		   public void onError(DialogError e)
		    {
			   Toast.makeText(FbQrAndroid.this, "login fail...", Toast.LENGTH_LONG).show();
			   System.out.println("Error: " + e.getMessage());
		    }

		    public void onFacebookError(FacebookError e)
		    {
		    	Toast.makeText(FbQrAndroid.this, "login fail...", Toast.LENGTH_LONG).show();
		        System.out.println("Error: " + e.getMessage());
		    }

		    
		    public void onCancel()
		    {
		    	Toast.makeText(FbQrAndroid.this, "login fail...", Toast.LENGTH_LONG).show();
		    }
		 }
	   
	   public class getData extends SoapConnectedListener{
			@Override
			public void onComplete(final ArrayList<FbQrProfile> response) {
				// TODO Auto-generated method stub
				try {
					
					FbQrAndroid.this.runOnUiThread(new Runnable() {
	                    public void run() {
	                       FbQrProfile x;
	     				   String display=""+response.size();
	     				   for(int i=0;i<response.size();i++){
	     					   	if(response.get(i).phone!=null)
	     					   		db.addData(response.get(i));
	     					    x=response.get(i);
	     					    if(x.display!=null) saveDisplay(x.display,x.uid);
	     			           	//display+=x.show()+"\n";
	     			       }
	     				   isDone();
	     				   //tv.setText(display);	                   
	                    }
	                });
				 	
				} catch (Exception e) {
					Log.w("getData", e.toString());
	            } 
			}	
			private void isDone(){
				Toast.makeText(FbQrAndroid.this, "Download Completed", Toast.LENGTH_LONG).show();
			}
	   }
	   
	   public class TokenRequestListener extends BaseRequestListener {

	        public void onComplete(final String response) {
	            try {
	                
	                Log.d("Facebook-Example", "Response: " + response.toString());
	                JSONObject json = Util.parseJson(response);
	                final String name = json.getString("name");
	                FbQrAndroid.this.runOnUiThread(new Runnable() {
	                    public void run() {
	                       // tv.setText("Hello there, " + name + "!");
	                    }
	                });
	            } catch (JSONException e) {
	                Log.w("Facebook-Example", "JSON Error in response");
	            } catch (final FacebookError e) {
	                Log.w("Facebook-Example", "Facebook Error: " + e.getMessage());
	                facebook.authorize(FbQrAndroid.this,new String[] {"offline_access"},new AuthorizeListener());
	            }
	        }
	    }
	   
		private void saveDisplay(String fileUrl,String uid){
			String PATH = "/data/data/com.fbqr.android/files/";  
			
			URL myFileUrl =null; 
			Bitmap bmImg;
			try {
				myFileUrl= new URL(fileUrl);
			} catch (MalformedURLException e) {		
				e.printStackTrace();
			}
			try {
				HttpURLConnection conn= (HttpURLConnection)myFileUrl.openConnection();
				conn.setDoInput(true);
				conn.connect();
				//int length = conn.getContentLength();
				//int[] bitmapData =new int[length];
				//byte[] bitmapData2 =new byte[length];
				InputStream is = conn.getInputStream();
			
				bmImg= BitmapFactory.decodeStream(is);
				
				OutputStream outStream = null;
				File dir = new File(PATH);
				dir.mkdirs();
				File file = new File(PATH,uid+".PNG");
				   
				outStream = new FileOutputStream(file);
				bmImg.compress(Bitmap.CompressFormat.PNG, 100, outStream);
				outStream.flush();
				outStream.close();
				   
				//Toast.makeText(this, "Saved", Toast.LENGTH_LONG).show();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
}