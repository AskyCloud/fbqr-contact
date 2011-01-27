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
import java.util.Arrays;
import java.util.List;

import com.facebook.android.AsyncFacebookRunner;
import com.facebook.android.Facebook;
import com.fbqr.android.FbQrBackground.getData;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ListActivity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.content.pm.ResolveInfo;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CheckedTextView;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class FbQrContactlistGroup extends ListActivity {
	/** Called when the activity is first created. */
	private final String PATH = "/data/data/com.fbqr.android/files/"; 
	private FbQrDatabase db=null;
	private ArrayAdapter<ContactView>  adapList=null;
	private ArrayList<ContactView> contactList=null;
	private String name,gid,display,website;
	TextView groupName;
	ImageView groupLogo;
	
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		//UI
		setContentView(R.layout.contactlayout_group);	
		groupName = (TextView) findViewById(R.id.groupName);
		groupLogo = (ImageView) findViewById(R.id.groupLogo);	
		
	}
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		  super.onActivityResult(requestCode, resultCode, data);
		  finish();
	}
	
	public void onStart(){
		super.onStart();
		db=new FbQrDatabase(this);
		Bundle extras = getIntent().getExtras();
		 if(extras !=null){
			 name = extras.getString("name");
			 if(name!=null){
				 groupName.setText(name);
			 }
			 gid = extras.getString("gid");
			 display = extras.getString("display");
			 website = extras.getString("website");
			 if(display != null){
					File img=new File(PATH+gid+".PNG");
				    if(img.exists())
				    	groupLogo.setImageBitmap(BitmapFactory.decodeFile(img.getPath())); 
				    	
			 }
			 
			 int[] ids= extras.getIntArray("ids"); 
			 if(website != null){
			 groupLogo.setOnClickListener(new View.OnClickListener() {
			    	
		            public void onClick(View v) {
		            	Openweb(website);
		            }
		        });
			 groupName.setOnClickListener(new View.OnClickListener() {
			    	
		            public void onClick(View v) {
		            	Openweb(website);
		            }
		        });
			 }
			if(ids!=null) showGroup(ids);
		 }
	}
	
	public void onResume(){
		super.onResume();
	}
	
	 public void onPause(){
		 super.onPause();
		 db.close();
	 }
	 
	 public void onStop(Bundle savedInstanceState) {
	       super.onStop();
	       db.close();
	 }
	
	private void showGroup(int[] ids){		
		//start activity code
		FbQrProfile profile=null;
     	contactList = new ArrayList<ContactView>();  
     	for(int i:ids) {    
     		if(i<0) continue;
     		profile=db.getProfile(i);
     		if(profile!=null) contactList.add(new  ContactView(profile.name,profile.uid,profile.position));
	    }     
     	db.close();
     	adapList=new FbQrArrayAdapter(this,contactList);
     	this.setListAdapter(adapList);
     	adapList.notifyDataSetChanged();
	}

	@Override
	protected void onListItemClick(ListView l, View v, int position, long id) {		
		super.onListItemClick(l, v, position, id);
		Intent intent = new Intent(this, FbQrDisplayProfile.class);
		intent.putExtra("ID", contactList.get(position).getId());
		startActivityForResult(intent,4);		
	}
	
	
	private static final int updateBtn = Menu.FIRST;
	private static final int shareBtn = Menu.FIRST+1;
	private static final int delBtn = Menu.FIRST+2;
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		 menu.add(0,updateBtn ,shareBtn,"Update");
		 menu.add(0,shareBtn ,shareBtn,"Share");
		 menu.add(0,delBtn ,shareBtn,"Delete");
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
	    case updateBtn:
	    	SOAPConnected mSoap = new SOAPConnected(this);
	    	mSoap.getGroup(gid,db.getAccessToken(),new getData());
	    	return true;
	    
	    case delBtn:
	    	db.removeGroup(gid);
	    	File img=new File(gid+".PNG");
      	    if(img.exists()) img.delete();
      	    int ids[]=new int[contactList.size()];
      	    for(int i=0;i<contactList.size();i++)
      	    	ids[i]=contactList.get(i).id;
      	    Intent intent = new Intent(this, FbQrContactlistEdit.class);
      	    intent.putExtra("ids", ids);
      	    startActivityForResult(intent,4);	
      	    return true;      
      	    
	    case shareBtn:
	    	final CharSequence[] items = {"Name","Phone","Address","Website","Display","Statis","Email"};
	    	final boolean[] states = {true, true, true,true,true,true,true,false};
	        AlertDialog.Builder builder = new AlertDialog.Builder(this);
	        builder.setTitle("Setting")
	        
	        .setPositiveButton("OK", new DialogInterface.OnClickListener() {
	            public void onClick(DialogInterface dialog, int id) {
	            	String setting="";
	            	for(boolean i:states){
	            		if(i==true) setting+="T";
	            		else setting+="F";
	            	}
	            	SOAPConnected mSoap = new SOAPConnected(FbQrContactlistGroup.this);
	            	mSoap.share2Group(gid, setting, db.getAccessToken(),new getDataSetting());
	                dialog.dismiss();
	           }
	       })
	       .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
	           public void onClick(DialogInterface dialog, int id) {
	                dialog.cancel();
	           }
	       });;
	        builder.setMultiChoiceItems(items, states, new DialogInterface.OnMultiChoiceClickListener(){
	            public void onClick(DialogInterface dialogInterface, int item, boolean state) {
	            	states[item]=state;
	                //Toast.makeText(getApplicationContext(), items[item] + " set to " + state, Toast.LENGTH_SHORT).show();
	            }
	        });
	        builder.create().show();
	    	return true;
	    
	    default:
	        return super.onOptionsItemSelected(item);
	    }
	}
	
	public static class FbQrArrayAdapter extends ArrayAdapter<ContactView> {
		private final Activity context;
		private final String PATH = "/data/data/com.fbqr.android/files/"; 
		private LayoutInflater inflater;  		
		private final List<ContactView> contactLists;
		
		public FbQrArrayAdapter(Activity context,List<ContactView> contactLists) {			
			super(context, R.layout.rowlayout,contactLists);
			inflater = LayoutInflater.from(context) ;
			this.context=context;
			this.contactLists=contactLists;
		}

		@Override
		public View getView(final int position, View convertView, ViewGroup parent) {
			final ContactView contact = contactLists.get(position);  
		    
		   convertView = inflater.inflate(R.layout.rowlayout, null); 
		   		   
		   TextView textView = (TextView) convertView.findViewById( R.id.label );  
		   ImageView imageView = (ImageView) convertView.findViewById(R.id.icon);
	       	
	       File img=new File(PATH+contact.getUid()+".PNG");
		   if(img.exists())
		         imageView.setImageBitmap(BitmapFactory.decodeFile(img.getPath()));    

		   convertView.setTag( new ViewHolder(textView,null) );        
 		        
		    // Display planet data  
  
		    textView.setText( contact.getName() );        
		        
		    return convertView;  
		  } 			
	}
	
	protected static class ViewHolder{ 
		public ImageView imageView;
	    private CheckBox checkBox ;  
	    private TextView label;  
	    public ViewHolder() {}  
	    public ViewHolder( TextView textView, CheckBox checkBox ) {  
	      this.checkBox = checkBox ;  
	      this.label = textView ;  
	    }  
	    public CheckBox getCheckBox() {  
	      return checkBox;  
	    }  
	    public void setCheckBox(CheckBox checkBox) {  
	      this.checkBox = checkBox;  
	    }  
	    public TextView getTextView() {  
	      return label;  
	    }  
	    public void setTextView(TextView textView) {  
	      this.label = textView;  
	    }     
	    
	  }  
	
	protected static class ContactView {  
	    String name = "" ;  
	    String uid = "" ;  
	    int id;
	    boolean checked = false ;  
	    public ContactView() {}  
	    public ContactView( String name,String uid,int id ) {  
	      this.name = name ;  
	      this.uid = uid ; 
	      this.id = id ; 
	    }  
	    public ContactView( String name, boolean checked ) {  
	      this.name = name ;  
	      this.checked = checked ;  
	    }  
	    public String getName() {  
	      return name;  
	    }  
	    public void setName(String name) {  
	      this.name = name;  
	    }  
	    public void setUid(String uid){
	    	this.uid = uid;
	    }
	    public String getUid(){
	    	return uid;
	    }
	    public void setId(int id){
	    	this.id = id;
	    }
	    public int getId(){
	    	return id;
	    }
	    public boolean isChecked() {  
	      return checked;  
	    }  
	    public void setChecked(boolean checked) {  
	      this.checked = checked;  
	    }  
	    public String toString() {  
	      return name ;   
	    }  
	    public void toggleChecked() {  
	      checked = !checked ;  
	    }  
	  }    
	void Openweb(String Url){
		Intent intent = new Intent(Intent.ACTION_VIEW);
		Uri data = Uri.parse(Url);
		intent.setData(data);
		startActivity(intent);
	}
	
	public class getData extends SoapConnectedListener{
        @Override
        public void onComplete(final ArrayList<FbQrProfile> response) {
                // TODO Auto-generated method stub\
        	if(response.size()==1&&response.get(0).name.matches("you are not the member")){
   				final String errCode = response.get(0).uid;
   				
   				FbQrContactlistGroup.this.runOnUiThread(new Runnable() {
	                public void run() {
	                		Toast.makeText(FbQrContactlistGroup.this, "you are not the member", Toast.LENGTH_LONG).show();
	                		if(errCode.matches("-1")||errCode.matches("-2")) Openweb(response.get(0).website);
	                }
                });
    		}else{
                try {
                        
                	FbQrContactlistGroup.this.runOnUiThread(new Runnable() {
				                public void run() {
					               FbQrProfile x;
	                               for(int i=(response.size()>1)?1:0;i<response.size();i++){
	                            	   x=response.get(i);
	                                   db.addData(x);                                       
	                                   saveDisplay(x.display,x.uid);
	                                    //display+=x.show()+"\n";
	                               }
	                               //db.close();		                               
	                               if(response.size()>0){
	                            	   Toast.makeText(FbQrContactlistGroup.this, "Download Completed", Toast.LENGTH_LONG).show();
	                            	   String[] uids = new String[response.size()-1];
	                            	   int[] ids = new int[response.size()-1];
	                            	   for(int i=1;i<response.size();i++){
	                            		   ids[i-1] = db.getIdByUid(response.get(i).uid);
	                            		   uids[i-1] = response.get(i).uid;
		                               }
	                            	   if(response.get(0).display!=null){
	                            		   saveDisplay(response.get(0).display,response.get(0).uid);
	                            	   }
	                            	   db.addGroup(response.get(0).uid,response.get(0).name,response.get(0).website, uids);		
	                            	   showGroup(ids);
	                               }else Toast.makeText(FbQrContactlistGroup.this, "There is nothing", Toast.LENGTH_LONG).show();
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
        	 Toast.makeText(FbQrContactlistGroup.this, e.toString(), Toast.LENGTH_LONG).show();
		}
	}
	public class getDataSetting extends SoapConnectedListener{
        @Override
        public void onComplete(final ArrayList<FbQrProfile> response) {
                // TODO Auto-generated method stub\
        	Toast.makeText(FbQrContactlistGroup.this, "Updated", Toast.LENGTH_LONG).show();
        }       
        public void onError(String e)
		{
        	 Toast.makeText(FbQrContactlistGroup.this, e.toString(), Toast.LENGTH_LONG).show();
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
}