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

public class FbQrBackground extends Activity{
		public static final String APP_ID = "146472442045328";
		
		private Facebook facebook;
		private AsyncFacebookRunner mAsyncRunner;
		Button button,button2,button3,button4;
		private TextView tv;
		SOAPConnected mSoap = new SOAPConnected(FbQrBackground.this);
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
	       
	       Bundle extras = getIntent().getExtras(); 
	       if(extras !=null)
			 {
				 String MODE = extras.getString("MODE");
				 if(MODE.matches("READQR")){
					 Intent intent = new Intent("com.google.zxing.client.android.SCAN");
				        intent.putExtra("SCAN_MODE", "QR_CODE_MODE");
				        startActivityForResult(intent, 2);
				 }
			 }
 
	       /*
	       button4.setOnClickListener(new OnClickListener() {
	    	   public void onClick(View v) {
	    		   if(isOnline()) facebook.authorize(FbQrAndroid.this,new String[] {"offline_access"},new AuthorizeListener());
	    		   else Toast.makeText(FbQrAndroid.this, "No Internet Connection...", Toast.LENGTH_LONG).show();
			    }
	        });  */  
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
	   
	   class AuthorizeListener implements DialogListener {
		   
		   public void onComplete(Bundle values) {
			   Toast.makeText(FbQrBackground.this, "logined", Toast.LENGTH_LONG).show();
			   //Get PhoneBook
			   if(db.getAccessToken()==null){    
				   Toast.makeText(FbQrBackground.this, "Downloading PhoneBook", Toast.LENGTH_LONG).show();
				   mSoap.getPhoneBook(facebook.getAccessToken(),new getData());
			   }
			   db.setAccessToken(facebook.getAccessToken());  
		   }
		   public void onError(DialogError e)
		    {
			   Toast.makeText(FbQrBackground.this, "login fail...", Toast.LENGTH_LONG).show();
			   System.out.println("Error: " + e.getMessage());
		    }

		    public void onFacebookError(FacebookError e)
		    {
		    	Toast.makeText(FbQrBackground.this, "login fail...", Toast.LENGTH_LONG).show();
		        System.out.println("Error: " + e.getMessage());
		    }

		    
		    public void onCancel()
		    {
		    	Toast.makeText(FbQrBackground.this, "login fail...", Toast.LENGTH_LONG).show();
		    }
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
	   
	   public class TokenRequestListener extends BaseRequestListener {

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
	                facebook.authorize(FbQrBackground.this,new String[] {"offline_access"},new AuthorizeListener());
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