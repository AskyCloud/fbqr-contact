package com.fbqr.android;

import java.util.Hashtable;

import org.ksoap2.serialization.SoapObject;

import android.util.Log;
import android.widget.TextView;

public class FbQrProfile {
	public String name,phone,address,email,website,uid,status,display,password;
	public long count,last_update;
	
	public FbQrProfile(){
		
	}
	
	public FbQrProfile(SoapObject obj){
			set(obj);
	}
	
	private void set(SoapObject obj){
		if(obj.hasProperty("id"))	{
			uid=obj.getProperty("id").toString();
			if(uid.equals("")) uid=null;
		}
		if(obj.hasProperty("name")) {
			name=obj.getProperty("name").toString();
			if(name.equals("")) name=null;
		}
		if(obj.hasProperty("phone")){
			phone=obj.getProperty("phone").toString();
			if(phone.equals("")) phone=null;
		}
		if(obj.hasProperty("address")){
			address=obj.getProperty("address").toString();
			if(address.equals("")) address=null;
		}
		if(obj.hasProperty("email")) {
			email=obj.getProperty("email").toString();
			if(email.equals("")) email=null;
		}
		if(obj.hasProperty("website")){
			website=obj.getProperty("website").toString();
			if(website.equals("")) website=null;
		}
		if(obj.hasProperty("status")){
			status=obj.getProperty("status").toString();
			if(status.equals("")) status=null;
		}
		if(obj.hasProperty("display")){ 
			display=obj.getProperty("display").toString();
			if(display.equals("")) display=null;
		}
		count=-1;
	}
	
	public String show(){
		String text;
		//display=name+"\n"+phone+"\n"+address+"\n"+email+"\n"+website+"\n"+id+"\n"+status;
		text=name+"\n"+display+"\n";
		return text;
	}
}
