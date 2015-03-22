package com.fbqr.android;

import java.io.File;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

public class FbQrDisplayProfile extends Activity{

	//super.onCreate(savedInstanceState);
   // setContentView.(R.layout.main_layout);
	TextView nameText,phoneText,addressText,statText,websiteText,emailText;
	ImageView statImg,phoneImg,emailImg,websiteImg,adsImg,ivUser_pic;
	TableRow phoneTr,addressTr,statTr,websiteTr,emailTr;

	private final String PATH = "/data/data/com.fbqr.android/files/"; 
	private Bundle extras=null;
	private FbQrDatabase db=null;
	private int id;
	
	private FbQrProfile profile=null;
	
	@Override
	public void onCreate(Bundle savedInstanceState) {		
		super.onCreate(savedInstanceState);
		
		extras = getIntent().getExtras(); 	       
		if(extras !=null)  id= extras.getInt("ID");
		db=new FbQrDatabase(this);	
		profile=db.getProfile(id);
		
		//UI
		setContentView(R.layout.user);
		
		//TableRow
		TableLayout table = (TableLayout)findViewById(R.id.table);
		TableLayout nameTl=(TableLayout)findViewById(R.id.TrName);
		phoneTr=(TableRow)findViewById(R.id.TrPhone);
		addressTr=(TableRow)findViewById(R.id.TrAddress);
		statTr=(TableRow)findViewById(R.id.TrStatus);
		websiteTr=(TableRow)findViewById(R.id.TrWebsite);
		emailTr=(TableRow)findViewById(R.id.TrEmail);
		
		
		
		//ImageView
		ivUser_pic = (ImageView) findViewById(R.id.image_name);		
		statImg=(ImageView) findViewById(R.id.image_status);
		phoneImg=(ImageView) findViewById(R.id.image_phone);
		emailImg=(ImageView) findViewById(R.id.image_email);
		websiteImg=(ImageView) findViewById(R.id.image_website);
		adsImg=(ImageView) findViewById(R.id.image_address);
		
		//TextView		
		nameText = (TextView) findViewById(R.id.text_name);
		phoneText = (TextView) findViewById(R.id.text_phone);
		addressText = (TextView) findViewById(R.id.text_address);
		statText = (TextView) findViewById(R.id.text_status);
		websiteText = (TextView) findViewById(R.id.text_website);
		emailText = (TextView) findViewById(R.id.text_email);

		
		//SET user profile
		File img=new File(PATH+profile.uid+".PNG");
	    if(img.exists())
	    	ivUser_pic.setImageBitmap(BitmapFactory.decodeFile(img.getPath())); 
	    if(profile.name==null){
	    	nameTl.removeAllViews();
	    }
		else nameText.setText(profile.name);
	    if(profile.status==null){
	    	table.removeView(statTr);
	    }
		else statText.setText(profile.status);
	    if(profile.phone==null) {
	    	table.removeView(phoneTr);  	
	    }
		else phoneText.setText(profile.phone);
	    if(profile.email==null) {
	    	table.removeView(emailTr);
	    }
		else emailText.setText(profile.email);
	    if(profile.website==null){
	    	table.removeView(websiteTr);
	    }
		else websiteText.setText(profile.website);
	    if(profile.address==null){
	    	table.removeView(addressTr);
	    }
		else addressText.setText(profile.address);
	    
	    phoneImg.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
            	Call();
            }
        });
	    phoneText.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
            	Call();
            }
        });
		db.close();
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
	
	void Call(){
		if (profile.phone == null)	return;
			profile.count++;
			db.updateData(profile);
			Intent intent = new Intent(Intent.ACTION_CALL, Uri.parse("tel:"+profile.phone));		     
			FbQrDisplayProfile.this.startActivityForResult(intent,3);		
	}
	
	
	private static final int pwdBtnId = Menu.FIRST;
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		menu.add(0,pwdBtnId ,pwdBtnId,"Password");
	    return super.onCreateOptionsMenu(menu);
	  }
	
	@Override
	public boolean onPrepareOptionsMenu (Menu menu){
	    return super.onPrepareOptionsMenu(menu);		
	}
	
	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		
	    // Handle item selection
		
	    switch (item.getItemId()) {
	    case pwdBtnId:
	    	showAddDialog(); 
	        return true;
	    default:
	        return super.onOptionsItemSelected(item);
	    }
	}
	
	private void showAddDialog() { 

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
				profile.password=textbox.getText().toString();
				if(profile.password!=null)
					db.updateData(profile);
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
}
