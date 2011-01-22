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

import android.app.Activity;
import android.app.ListActivity;
import android.content.Context;
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
			 showGroup(ids);
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
     		contactList.add(new  ContactView(profile.name,profile.uid,profile.position));
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
	
	private static final int shareBtn = Menu.FIRST;
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		 menu.add(0,shareBtn ,shareBtn,"Share to group");
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
}