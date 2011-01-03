package com.fbqr.android;

import java.io.File;

import android.app.Activity;
import android.content.Intent;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.ImageView;

public class FbQrDisplayProfile extends Activity{

	//super.onCreate(savedInstanceState);
   // setContentView.(R.layout.main_layout);
	Button bUser_name,bUser_phone,bUser_address,bUser_stat,bUser_website,bUser_email
			,bUser_textMessage,bUser_ShareContact,bUser_AddToFavorite;//,bUser_,bUser_,bUser_;
	ImageView ivUser_pic;
	private final String PATH = "/data/data/com.fbqr.android/files/"; 
	private Bundle extras=null;
	private FbQrDatabase db=new FbQrDatabase(this);
	private int id;
	
	private FbQrProfile profile=null;
	
	@Override
	public void onCreate(Bundle savedInstanceState) {		
		super.onCreate(savedInstanceState);
		
		extras = getIntent().getExtras(); 	       
		if(extras !=null)  id= extras.getInt("ID");
		
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
	}
	
	void Call(){
		if (profile.phone == null)	return;
			profile.count++;
			db.updateData(profile);
			Intent intent = new Intent(Intent.ACTION_CALL, Uri.parse("tel:"+profile.phone));		     
			FbQrDisplayProfile.this.startActivityForResult(intent,3);		
	}
}
