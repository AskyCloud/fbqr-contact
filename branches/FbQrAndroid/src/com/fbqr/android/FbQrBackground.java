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
import android.app.Dialog;
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
import android.graphics.Matrix;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.Contacts.People;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TabHost;
import android.widget.TabHost.TabSpec;
import android.widget.TextView;
import android.widget.Toast;



import com.facebook.android.*;
import com.facebook.android.Facebook.DialogListener;
import com.fbqr.android.FbQrContactlist.ContactView;

public class FbQrBackground extends Activity{
		public static final String APP_ID = "146472442045328";
		
		private Facebook facebook;
		private AsyncFacebookRunner mAsyncRunner;
		private String[] req_perm=new String[]{"offline_access","email","user_status","user_website","user_birthday","user_location","user_hometown","publish_stream",
				"friends_birthday","friends_status","friends_hometown","friends_location","friends_website"};
		
		private FbQrDatabase db=null;
		private ReadFbQR readQR=new ReadFbQR() ;
		private SOAPConnected mSoap = new SOAPConnected(FbQrBackground.this);
		private String MODE=null;
		private String multiqr_password=null;
		
		private TextView tv=null;
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
					 setContentView(R.layout.background);
					 
					 tv=(TextView)findViewById(R.id.TextView01);
					 tv.setVisibility(TextView.INVISIBLE);
					 Button scanqr=(Button)findViewById(R.id.scanqr);
					 					 
					 scanqr.setOnClickListener(new OnClickListener() {
				    	   public void onClick(View v) {
				    		   Intent intent = new Intent("com.google.zxing.client.android.SCAN");
						        intent.putExtra("SCAN_MODE", "QR_CODE_MODE");
						        startActivityForResult(intent, 2);
						    }
				        });
					
				 }else{
					 Toast.makeText(FbQrBackground.this, "Barcode Scanner not installed", Toast.LENGTH_LONG).show();
				 }
			 }
			 else if(MODE.matches("login")){
					 if(isOnline()){
						 	db=new FbQrDatabase(this);
				    	   facebook.setAccessToken(db.getAccessToken());
				    	   mAsyncRunner.request("me", new TokenRequestListener());
				    	   db.close();
				     }			 
			 }		 
	   }
	   
		 public void onStart(){
			 super.onStart();
			 db=new FbQrDatabase(this);
		 }
		 
		 public void onResume(){
			 super.onResume();
			 db=new FbQrDatabase(this);
		 }
		 
		 public void onPause(){
			 super.onPause();
			 db.close();
		 }
		 
		 public void onStop(Bundle savedInstanceState) {
		       super.onStop();
		       db.close();
		   }

	   public boolean isOnline() {	
		    ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
		    NetworkInfo netInfo = cm.getActiveNetworkInfo();
		    db=new FbQrDatabase(this);
		    String AccessToken=db.getAccessToken();
		    db.close();
		    if (netInfo != null && netInfo.isConnectedOrConnecting()){
		    	if(AccessToken!=null||MODE.matches("login")){		    		
		    		return true;
		    	}
		    	else{
		    		//Toast.makeText(this, "Please Login", Toast.LENGTH_LONG).show();
		    		return false;
		    	}
		    }
		    else {
		    	//Toast.makeText(this, "No Internet Connection", Toast.LENGTH_LONG).show();
		    	return false;
		    }
		   
		    
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
                            //Reject unknow type QR
                            if(readQR.type.matches("etc")) Toast.makeText(FbQrBackground.this, "FbQr not support this QRcode", Toast.LENGTH_LONG).show();
                            //MultiQR
                            if(readQR.type.matches("multiqr_n")){                                       
                                //add data to db
                            	for(int i=0;i<readQR.profileList.size();i++)                             		
                            		db.addData(readQR.profileList.get(i));
                            	Toast.makeText(FbQrBackground.this, "Completed", Toast.LENGTH_LONG).show();
                                if(isOnline()){
                                        mSoap.getMulti(readQR.qrid, db.getAccessToken(),"",new getData());
                                }                                
                            }                   
                            else{
                            	if(readQR.type.matches("multiqr_p")){   
                            		if(isOnline()){
                            			askPasswordforMultiQR();                                        
                            		}else Toast.makeText(this, "No Internet Connection", Toast.LENGTH_LONG).show();      
                            	}
                                else{
                                    //add data to db
                                	if(readQR.type.matches("single")){
                                		for(int i=0;i<readQR.profileList.size();i++)                             		
                                			db.addData(readQR.profileList.get(i));     
                                        //FbQr type     
                                        if(readQR.profileList.get(0).uid!=null){
                                                if(isOnline()){                                        
                                                        String[] uids=new String[readQR.profileList.size()];
                                                        for(int i=0;i<readQR.profileList.size();i++)
                                                                uids[i]=readQR.profileList.get(i).uid;
                                                        Toast.makeText(FbQrBackground.this, "Downloading", Toast.LENGTH_LONG).show();
                                                        mSoap.getFriendInfo(uids, db.getAccessToken(),new getData());
                                                }else{
                                                	if(readQR.profileList.get(0).phone!=null) displayResult(readQR.profileList.get(0).uid);
                                                }
                                        }
                                        Toast.makeText(FbQrBackground.this, "Completed", Toast.LENGTH_LONG).show();
                                	}
                                }
                           }                       
               } else if (resultCode == RESULT_CANCELED) {
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
                    // TODO Auto-generated method stub\
           		if(response.size()==1&&response.get(0).uid.matches("wrong password")){
            			FbQrBackground.this.runOnUiThread(new Runnable() {
			                public void run() {
			                		Toast.makeText(FbQrBackground.this, "Wrong Password", Toast.LENGTH_LONG).show();
			                		askPasswordforMultiQR();
			                }
                        });
            		}
                else{
                    try {
                            
	                            FbQrBackground.this.runOnUiThread(new Runnable() {
					                public void run() {
						               FbQrProfile x;
		                               for(int i=0;i<response.size();i++){
		                            	   x=response.get(i);
		                                   db.addData(x);                                       
		                                   saveDisplay(x.display,x.uid);
		                                    //display+=x.show()+"\n";
		                               }
		                               //db.close();
		                               Toast.makeText(FbQrBackground.this, "Download Completed", Toast.LENGTH_LONG).show();
		                               if(response.size()==1){
		                            	   if(response.get(0).phone!=null)
		                            		   displayResult(response.get(0).uid);
		                               }
		                               //tv.setText(display);   
					                }
                             });
                             
                    } catch (Exception e) {
                            Log.w("getData", e.toString());
                    } 
            }
            }       
            public void onError(String e)
			{
            	 Toast.makeText(FbQrBackground.this, e.toString(), Toast.LENGTH_LONG).show();
			}
		}
		
		private void saveDisplay(String fileUrl,String uid){
			String PATH = "/data/data/com.fbqr.android/files/";  
			
			URL myFileUrl =null; 
			Bitmap bmImg,resizedbmImg = null;
			if(fileUrl==null||uid==null) return;
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
				
				//Resize to 50x50
	            
	            int width = bmImg.getWidth();
	            int height = bmImg.getWidth();
	            
	            if(width!=50&&height!=50){
	                int newWidth = 50;
	                int newHeight = 50;
	               
	                // calculate the scale - in this case = 0.4f
	                float scaleWidth = ((float) newWidth) / width;
	                float scaleHeight = ((float) newHeight) / height;
	               
	                Matrix matrix = new Matrix(); // createa matrix for the manipulation
	                matrix.postScale(scaleWidth, scaleHeight);  // resize the bit map
	                matrix.postRotate(0);  // rotate the Bitmap
	                
	             // recreate the new Bitmap
	                resizedbmImg = Bitmap.createBitmap(bmImg, 0, 0,width, height, matrix, true);
	            
	            }
				
				OutputStream outStream = null;
				File dir = new File(PATH);
				dir.mkdirs();
				File file = new File(PATH,uid+".PNG");
				   
				outStream = new FileOutputStream(file);
				if(width!=50&&height!=50) resizedbmImg.compress(Bitmap.CompressFormat.PNG, 100, outStream);
				else bmImg.compress(Bitmap.CompressFormat.PNG, 100, outStream);
				
				outStream.flush();
				outStream.close();
				   
				//Toast.makeText(this, "Saved", Toast.LENGTH_LONG).show();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		
		private void askPasswordforMultiQR() { 

			final String TAG = "pwd"; 
			final Dialog dialog = new Dialog(this); 
			dialog.getWindow().setFlags( 
			WindowManager.LayoutParams.FLAG_BLUR_BEHIND, 
			WindowManager.LayoutParams.FLAG_BLUR_BEHIND); 
			dialog.setTitle("Add Password"); 

			LayoutInflater li = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE); 
			View dialogView = li.inflate(R.layout.dialog, null); 
			dialog.setContentView(dialogView); 

			dialog.show(); 
			TextView tv = (TextView) dialogView.findViewById(R.id.textview_dialog); 
			final EditText textbox = (EditText) dialogView.findViewById(R.id.textbox_dialog);
			Button addButton = (Button) dialogView.findViewById(R.id.sumbit_button); 
			Button cancelButton = (Button) dialogView.findViewById(R.id.cancel_button); 

			tv.setText("Password for Update");
			
			addButton.setOnClickListener(new OnClickListener() { 
				// @Override 
				public void onClick(View v) { 
					multiqr_password=textbox.getText().toString();
					if(multiqr_password!=null)
						mSoap.getMulti(readQR.qrid, db.getAccessToken(),multiqr_password,new getData());
					dialog.dismiss(); 
				} 
			}); 

			cancelButton.setOnClickListener(new OnClickListener() { 
				// @Override 
				public void onClick(View v) { 
					dialog.dismiss(); 
				} 
			}); 
		} 
		
		private void displayResult(String uid){
     	   	Intent intent = new Intent(this, FbQrDisplayProfile.class);     	   	;
  			intent.putExtra("ID", db.getIdByUid(uid));
  			startActivityForResult(intent,4);			
		}
}
