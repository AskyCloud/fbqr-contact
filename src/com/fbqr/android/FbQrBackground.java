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
import java.util.List;

import org.json.JSONException;
import org.json.JSONObject;


import android.app.Activity;
import android.app.TabActivity;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.content.pm.ResolveInfo;
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

public class FbQrBackground extends Activity{
		public static final String APP_ID = "146472442045328";
		
		private Facebook facebook;
		private AsyncFacebookRunner mAsyncRunner;
		private String[] req_perm=new String[]{"offline_access","email","user_status","user_website","user_birthday","user_location","user_hometown","publish_stream",
				"friends_birthday","friends_status","friends_hometown","friends_location","friends_website"};
		
		private FbQrDatabase db=new FbQrDatabase(this);
		private ReadFbQR readQR=new ReadFbQR() ;
		private SOAPConnected mSoap = new SOAPConnected(FbQrBackground.this);
		private String MODE=null;
	   /** Called when the activity is first created. */
	   @Override
	   public void onCreate(Bundle savedInstanceState) {
	       super.onCreate(savedInstanceState);
	       
           //Facebook
	       facebook = new Facebook(APP_ID);		    
	       mAsyncRunner = new AsyncFacebookRunner(facebook);   
	       
	       Bundle extras = getIntent().getExtras(); 	       
	       if(extras !=null)  MODE= extras.getString("MODE");
	       
			 if(MODE.matches("READQR")){
				 final boolean scanAvailable = isIntentAvailable(this,
			        "com.google.zxing.client.android.SCAN");
				 if(scanAvailable){
					 Intent intent = new Intent("com.google.zxing.client.android.SCAN");
				        intent.putExtra("SCAN_MODE", "QR_CODE_MODE");
				        startActivityForResult(intent, 2);
				 }else{
					 Toast.makeText(FbQrBackground.this, "Barcode Scanner not installed", Toast.LENGTH_LONG).show();
				 }
			 }
			 else if(MODE.matches("login")){
					 if(isOnline()){
				    	   facebook.setAccessToken(db.getAccessToken());
				    	   mAsyncRunner.request("me", new TokenRequestListener());
				     }else{
						   Bundle stats = new Bundle();
						   Intent intent = new Intent();
						   stats.putString("Error", "No Internet Connection");
					       intent.putExtras(stats);
				           setResult(RESULT_CANCELED, intent);
				           finish();
				     }				 
			 }
	       
	   }
		 public void onResume(){
			 super.onResume();

		 }

	   public boolean isOnline() {		   
		    ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
		    NetworkInfo netInfo = cm.getActiveNetworkInfo();
		    if (netInfo != null && netInfo.isConnectedOrConnecting()) return true;		    
		    else return false;
		}
	   
	   public void onActivityResult(int requestCode, int resultCode, Intent data) {
		  super.onActivityResult(requestCode, resultCode, data);
		  facebook.authorizeCallback(requestCode, resultCode, data);
		//Result of QRscan
          if (requestCode == 2) {
                                if (resultCode == RESULT_OK) {
                                // Handle successful scan
                                        String contents = data.getStringExtra("SCAN_RESULT");                      
                           
                            readQR.read(contents);
                            
                            //MultiQR
                            if(readQR.type.matches("multiqr_n")){                                       
                                //add data to db
                                for(int i=0;i<readQR.profileList.size();i++) {
                                        if(readQR.profileList.get(i).phone!=null)
                                                db.addData(readQR.profileList.get(i));
                                }
                                if(isOnline()&&facebook.getAccessToken()!=null)
                                        mSoap.getMulti(readQR.qrid, facebook.getAccessToken(),"",new getData());
                            }                       
                            else{
                                //Reject unknow type QR
                                if(readQR.profileList.size()<1) Toast.makeText(FbQrBackground.this, "FbQr not support this QRcode", Toast.LENGTH_LONG).show();
                                else{
                                        //add data to db
                                        for(int i=0;i<readQR.profileList.size();i++) {
                                                if(readQR.profileList.get(i).phone!=null)
                                                        db.addData(readQR.profileList.get(i));
                                        }                                                       
                                        //FbQr type     
                                        if(readQR.profileList.get(0).uid!=null){
                                                if(isOnline()&&facebook.getAccessToken()!=null){
                                        
                                                        String[] uids=new String[readQR.profileList.size()];
                                                        for(int i=0;i<readQR.profileList.size();i++)
                                                                uids[i]=readQR.profileList.get(i).uid;
                                                        mSoap.getFriendInfo(uids, facebook.getAccessToken(),new getData());
                                                                                                
                                                }
                                        }
                                }
                            }                       
                } else if (resultCode == RESULT_CANCELED) {
                    // Handle cancel
                }
           }                          
	   }
	   
	   private class AuthorizeListener implements DialogListener {
		   private Bundle stats = new Bundle();
		   private Intent intent = new Intent();
		   public void onComplete(Bundle values) {
			   Toast.makeText(FbQrBackground.this, "logined", Toast.LENGTH_LONG).show();
			   //Get PhoneBook
			   if(db.getAccessToken()==null)
				   stats.putString("MODE", "getPhoneBook");
			   else  stats.putBoolean("getPhoneBook", false); 
		       intent.putExtras(stats);
	           setResult(RESULT_OK, intent);
			   db.setAccessToken(facebook.getAccessToken());  
			   finish();
		   }
		   public void onError(DialogError e)
		    {
			   Toast.makeText(FbQrBackground.this, "login fail...", Toast.LENGTH_LONG).show();
			   System.out.println("Error: " + e.getMessage());
			   stats.putString("Error", e.getMessage());
		       intent.putExtras(stats);
	           setResult(RESULT_CANCELED, intent);
	           finish();
		    }

		    public void onFacebookError(FacebookError e)
		    {
		    	Toast.makeText(FbQrBackground.this, "login fail...", Toast.LENGTH_LONG).show();
		        System.out.println("Error: " + e.getMessage());
			    stats.putString("Error", e.getMessage());
		        intent.putExtras(stats);
	            setResult(RESULT_CANCELED, intent);
	            finish();
		    }

		    public void onCancel()
		    {
		    	Toast.makeText(FbQrBackground.this, "login fail...", Toast.LENGTH_LONG).show();
	            setResult(RESULT_CANCELED, null);
	            finish();
		    }
		 }
	   
	   private class TokenRequestListener extends BaseRequestListener {

	        public void onComplete(final String response) {
	            try {
	                
	                Log.d("Facebook-Example", "Response: " + response.toString());
	                JSONObject json = Util.parseJson(response);
	                final String name = json.getString("name");
	                FbQrBackground.this.runOnUiThread(new Runnable() {
	                    public void run() {
	                       // tv.setText("Hello there, " + name + "!");
	                    }
	                });
	            } catch (JSONException e) {
	                Log.w("Facebook-Example", "JSON Error in response");
	            } catch (final FacebookError e) {
	                Log.w("Facebook-Example", "Facebook Error: " + e.getMessage());
	                facebook.authorize(FbQrBackground.this,req_perm,new AuthorizeListener());
	            }
	        }
			public void onError(DialogError e)
			{
				   setResult(RESULT_CANCELED, null);
				   finish();
			}
	    } 

		public static boolean isIntentAvailable(Context context, String action) {
		    final PackageManager packageManager = context.getPackageManager();
		    final Intent intent = new Intent(action);
		    List<ResolveInfo> list =
		            packageManager.queryIntentActivities(intent,
		                    PackageManager.MATCH_DEFAULT_ONLY);
		    return list.size() > 0;
		}
		
		public class getData extends SoapConnectedListener{
            @Override
            public void onComplete(final ArrayList<FbQrProfile> response) {
                    // TODO Auto-generated method stub
                    try {
                            
                            FbQrBackground.this.runOnUiThread(new Runnable() {
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
                    Toast.makeText(FbQrBackground.this, "Download Completed", Toast.LENGTH_LONG).show();
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
