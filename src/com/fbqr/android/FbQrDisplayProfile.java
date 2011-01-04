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
import android.widget.TextView;
import android.widget.Toast;

public class FbQrDisplayProfile extends Activity{

	//super.onCreate(savedInstanceState);
   // setContentView.(R.layout.main_layout);
	Button bUser_name,bUser_phone,bUser_address,bUser_stat,bUser_website,bUser_email
			,bUser_textMessage,bUser_ShareContact,bUser_AddToFavorite;//,bUser_,bUser_,bUser_;
	ImageView ivUser_pic;
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
		Button statBtn,phoneBtn,emailBtn,websiteBtn,adsBtn;
		statBtn=(Button) findViewById(R.id.statbtn);
		phoneBtn=(Button) findViewById(R.id.phoneBtn);
		emailBtn=(Button) findViewById(R.id.emailBtn);
		websiteBtn=(Button) findViewById(R.id.websiteBtn);
		adsBtn=(Button) findViewById(R.id.adsBtn);
		ivUser_pic = (ImageView) findViewById(R.id.user_pic);
		bUser_name = (Button) findViewById(R.id.user_name);
		bUser_stat = (Button) findViewById(R.id.user_stat);
		bUser_phone = (Button) findViewById(R.id.user_mobile);
		bUser_email = (Button) findViewById(R.id.user_email);
		bUser_website = (Button) findViewById(R.id.user_website);
		bUser_address = (Button) findViewById(R.id.user_address);
		bUser_textMessage = (Button) findViewById(R.id.user_textMessage);
		bUser_ShareContact = (Button) findViewById(R.id.user_ShareContact);
		bUser_AddToFavorite = (Button) findViewById(R.id.user_AddToFavorite);
		//bUser_pic = (Button) findViewById(R.id.updateBtn);
		
		bUser_textMessage.setVisibility(Button.INVISIBLE);
		bUser_ShareContact.setVisibility(Button.INVISIBLE);
		bUser_AddToFavorite.setVisibility(Button.INVISIBLE);
		
		//SET user profile
		File img=new File(PATH+profile.uid+".PNG");
	    if(img.exists())
	    	ivUser_pic.setImageBitmap(BitmapFactory.decodeFile(img.getPath())); 
	    if(profile.name==null){
	    	bUser_name.setVisibility(Button.INVISIBLE);
	    }
		else bUser_name.setText("Call :"+profile.name);
	    if(profile.status==null){
	    	//statBtn.setVisibility(Button.INVISIBLE);
	    	//bUser_stat.setVisibility(Button.INVISIBLE);
	    }
		else bUser_stat.setText(profile.status);
	    if(profile.phone==null) {
	    	//phoneBtn.setVisibility(Button.INVISIBLE);
	    	//bUser_phone.setVisibility(Button.INVISIBLE);
	    }
		else bUser_phone.setText(profile.phone);
	    if(profile.email==null) {
	    	//emailBtn.setVisibility(Button.INVISIBLE);
	    	//bUser_email.setVisibility(Button.INVISIBLE);
	    }
		else bUser_email.setText(profile.email);
	    if(profile.website==null){
	    	//websiteBtn.setVisibility(Button.INVISIBLE);
	    	//bUser_website.setVisibility(Button.INVISIBLE);
	    }
		else bUser_website.setText(profile.website);
	    if(profile.address==null){
	    	//adsBtn.setVisibility(Button.INVISIBLE);
	    	//bUser_address.setVisibility(Button.INVISIBLE);
	    }
		else bUser_address.setText(profile.address);
		
		bUser_phone.setOnClickListener(new OnClickListener() {
	    	   public void onClick(View v) {		    		   
	    		   Call();
	    	   }} 	
	    );
		bUser_name.setOnClickListener(new OnClickListener() {
	    	   public void onClick(View v) {		    		   
	    		   Call();
	    	   }} 	
	    );
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
	    	Toast.makeText(getBaseContext(), "Test", Toast.LENGTH_LONG) 
	    	.show(); 
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
