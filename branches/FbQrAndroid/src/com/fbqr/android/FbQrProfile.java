package com.fbqr.android;

import java.util.Hashtable;

import org.ksoap2.serialization.SoapObject;

import android.util.Log;
import android.widget.TextView;

public class FbQrProfile {
	public String name,phone,address,email,website,id,status,last_update;
	
	public FbQrProfile(){
		
	}
	
	public FbQrProfile(SoapObject obj){
			set(obj);
	}
	
	private void set(SoapObject obj){
		if(obj.hasProperty("id"))	id=obj.getProperty("id").toString();
		if(obj.hasProperty("name")) name=obj.getProperty("name").toString();
		if(obj.hasProperty("phone")) phone=obj.getProperty("phone").toString();
		if(obj.hasProperty("address")) address=obj.getProperty("address").toString();
		if(obj.hasProperty("email")) email=obj.getProperty("email").toString();
		if(obj.hasProperty("website")) website=obj.getProperty("website").toString();
		if(obj.hasProperty("status")) status=obj.getProperty("status").toString();
	}
	
	public String show(){
		String display;
		//display=name+"\n"+phone+"\n"+address+"\n"+email+"\n"+website+"\n"+id+"\n"+status;
		display=name+"\n"+phone;
		return display;
	}
}
