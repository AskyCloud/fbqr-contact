package com.fbqr.android;

import java.util.ArrayList;
import java.util.Dictionary;
import java.util.HashMap;
import java.util.Hashtable;
import java.util.Vector;

import org.json.JSONException;
import org.json.JSONObject;
import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.serialization.SoapSerializationEnvelope;
import org.ksoap2.transport.HttpTransportSE;

import com.facebook.android.FacebookError;
import com.facebook.android.Util;

import android.app.Activity;
import android.os.Handler;
import android.util.Log;
import android.widget.Toast;

public class SOAPConnected {
			private ArrayList<FbQrProfile> profileList=new ArrayList<FbQrProfile>();
	        protected static final String TAG = "SOAPConnected";
	        
	        private static final String NAMESPACE = "urn:fbqrwsdl";
	        private static final String URL = "http://tkroputa.in.th/fbqr/webservice/t2_server.php";	//t2 for test
	        private boolean status;
	        private Activity act;
	        	        
	        	
	        final Handler mHandler = new Handler();
	       
	                       
	        public SOAPConnected(Activity act){
	        	this.act=act;	       
	        	
	        }
	        
	        public void getGroup(String gid,String access_token,final SoapConnectedListener listener){
	        	final String method = "getGroup";
	        	profileList.clear();
	        	final SoapObject request = new SoapObject(NAMESPACE, method);
	        	request.addProperty("qrid", gid);
	        	request.addProperty("access_token", access_token);
	        	status=false;
	        	new Thread() {
	        		public void run() {
	        			connect(method,request);
	        			mHandler.post(mUpdateResults);
	        			listener.onComplete(profileList);	        				        				        			
	        		}
	        	}.start();
	        	
	        	updateStartedInUI(); 
	        	
	        }
	        
	        public void share2Group(String gid,String privacy,String access_token,final SoapConnectedListener listener){
	        	final String method = "share2Group";
	        	profileList.clear();
	        	final SoapObject request = new SoapObject(NAMESPACE, method);
	        	request.addProperty("gid", gid);
	        	request.addProperty("privacy", privacy);
	        	request.addProperty("access_token", access_token);
	        	status=false;
	        	new Thread() {
	        		public void run() {
	        			connect(method,request);
	        			mHandler.post(mUpdateResults);
	        			listener.onComplete(profileList);	        				        				        			
	        		}
	        	}.start();
	        	
	        	updateStartedInUI();
	        }
	        
	        public void getPhoneBook(String access_token,final SoapConnectedListener listener){
	        	final String method = "getPhoneBook";
	        	profileList.clear();
	        	final SoapObject request = new SoapObject(NAMESPACE, method);
	        	request.addProperty("access_token", access_token);
	        	status=false;
	        	new Thread() {
	        		public void run() {
	        			connect(method,request);
	        			mHandler.post(mUpdateResults);
	        			listener.onComplete(profileList);	        				        				        			
	        		}
	        	}.start();
	        	
	        	updateStartedInUI(); 
	        	
	        }
	        
	        public void getMulti(String qrid,String access_token,String password,final SoapConnectedListener listener){
	        	   	
	        	final String method = "getMulti";
	        	profileList.clear();
	        	final SoapObject request = new SoapObject(NAMESPACE, method);	        	       	      	    	
	        	request.addProperty("qrid", qrid);
	        	request.addProperty("access_token", access_token);
	        	request.addProperty("password_in", password);	
	        	status=false;
	        	new Thread() {
	        		public void run() {
	        			connect(method,request);	
	        			mHandler.post(mUpdateResults);
	        			listener.onComplete(profileList);
	        		}
	        	}.start();
	        	
	        	updateStartedInUI(); 
	        	
	        }
	        
	        public void getFriendInfoBypass(String[] uids,String access_token,String[] password,final SoapConnectedListener listener){
	        	final String method = "getFriendInfoBypass";
	        	profileList.clear();
	        	final SoapObject request = new SoapObject(NAMESPACE, method);	  
	        	Vector<String> data = new Vector<String>();
	        	Vector<String> password_in = new Vector<String>();
	        	for(String i:uids)
	        		data.addElement(i);		
	        	for(String i:password)
	        		password_in.addElement(i);
	        	request.addProperty("uidFr", data);
	        	request.addProperty("access_token", access_token);
	        	request.addProperty("password_in", password_in);
	        	status=false;
	        	new Thread() {
	        		public void run() {
	        			connect(method,request);	
	        			mHandler.post(mUpdateResults);
	        			listener.onComplete(profileList);
	        		}
	        	}.start();
	        	
	        	updateStartedInUI(); 
	        	
	        }
	        
	        public void getFriendInfo(String[] uids,String access_token,final SoapConnectedListener listener){
	        	final String method = "getFriendInfo";
	        	profileList.clear();
	        	final SoapObject request = new SoapObject(NAMESPACE, method);
	        	Vector<String> data = new Vector<String>();
	        	for(String i:uids)
	        		data.addElement(i);	        	    	
	        	request.addProperty("uidFr", data);
	        	request.addProperty("access_token", access_token);
	        	status=false;
	        	new Thread() {
	        		public void run() {
	        			connect(method,request);	
	        			mHandler.post(mUpdateResults);
	        			listener.onComplete(profileList);
	        		}
	        	}.start();
	        	
	        	updateStartedInUI();        	
	        }
	        
	        private boolean connect(String method,SoapObject request){
	        	String SOAP_ACTION = NAMESPACE+"#"+method;	        	
      	
	        	SoapSerializationEnvelope envelope = new SoapSerializationEnvelope(SoapEnvelope.VER11);
	        	envelope.dotNet = false;
	        	envelope.setOutputSoapObject(request);	        	
	        	HttpTransportSE androidHttpTransport = new HttpTransportSE(URL);
	        	
	        	try {
		        	androidHttpTransport.call(SOAP_ACTION, envelope);
		        	SoapObject resultsRequestSOAP = (SoapObject)envelope.bodyIn;
		        	//SoapObject resultsRequestSOAP = (SoapObject)envelope.getResponse();
		        	
		        	Vector<SoapObject> XXXX = (Vector<SoapObject>) resultsRequestSOAP.getProperty(0);
		        			        	
					for(int i=0;i<XXXX.size();i++)
		        	    profileList.add(i,new FbQrProfile(XXXX.get(i)));
					
	        	} catch (Exception e) {
	        		Log.v(TAG, "EX:" + e.toString());
	            	return false;
	            }
	        	return true;
	     }
	        
	        
		       
        //for debug
        public ArrayList<FbQrProfile> getProfile(){
        	if(status) return profileList;
        	else return null;
        	
        }
        
        
        final Runnable mUpdateResults = new Runnable() {
        	public void run() {
        		updateResultsInUI();
        	}
        };
        
        private void updateStartedInUI(){
        	Toast.makeText(act, "Downloading", Toast.LENGTH_LONG).show();        	
        }
        
        private void updateResultsInUI() {	        	
        		        	       	
        }       
}

abstract class SoapConnectedListener {
	abstract public void onComplete(final ArrayList<FbQrProfile> response);	        	
}
