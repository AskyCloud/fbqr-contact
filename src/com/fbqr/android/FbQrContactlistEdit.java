package com.fbqr.android;

import java.io.File;
import java.util.ArrayList;
import java.util.List;

import android.app.Activity;
import android.app.ListActivity;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.content.pm.ResolveInfo;
import android.database.Cursor;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class FbQrContactlistEdit extends FbQrContactlist {
		/** Called when the activity is first created. */
		FbQrDatabase db=new FbQrDatabase(this);
		ArrayAdapter<ContactView>  adapList=null;
		ArrayList<ContactView> contactList=null;
		Button delBtn,updateBtn;
		
		
		public void onCreate(Bundle savedInstanceState) {
			super.onCreate(savedInstanceState);
			//UI
			
			setContentView(R.layout.contactlayout_edit);
			delBtn = (Button) findViewById(R.id.deleteBtn);
			updateBtn = (Button) findViewById(R.id.updateBtn);
			
			delBtn.setOnClickListener(new OnClickListener() {
		    	   public void onClick(View v) {		    		   
		    		    int _size = contactList.size();
		    	        for (int i = 0; i < _size; i++) {
		    	          boolean isChecked = contactList.get(i).isChecked();
		    	          if(isChecked==true) db.deleteData(contactList.get(i).getUid());
		    	        } 	 		    	        
		    	        //adapList.notifyDataSetChanged();
		    	        Bundle stats = new Bundle();
		    			Intent intent = new Intent();
		    			stats.putString("MODE", "delete");
		    			intent.putExtras(stats);
		    			
		    			setResult(RESULT_OK, intent);
		    		    finish();
				    }
		        });
			updateBtn.setOnClickListener(new OnClickListener() {
		    	   public void onClick(View v) {  
		    		   ArrayList<String> uidList=new ArrayList<String>();
		    		   
		    		   int _size = contactList.size() - 1;
		    		   
		    	        for (int i = 0; i < _size; i++) {
		    	          boolean isChecked = contactList.get(i).isChecked();
		    	          if (isChecked == true) {
		    	        	  uidList.add(contactList.get(i).getUid());
		    	          }
		    	        } 	 
		    	        
		    	        String[] uids=new String[uidList.size()];
		    	        for(int i=0;i<uidList.size();i++)
		    	        	uids[i]=uidList.get(i);
		    	        
		    	        Bundle stats = new Bundle();
		    			Intent intent = new Intent();
		    			stats.putString("MODE","update");
		    			stats.putStringArray("uids", uids);
		    			intent.putExtras(stats);
		    			
		    			setResult(RESULT_OK, intent);
		    		    finish();
				    }
		        });
			
			
			//start activity code
	     	Cursor cursor=db.getData();
	     	int i=0;
	     	FbQrProfile profile;
	     	contactList = new ArrayList<ContactView>();  
	     	while (cursor.moveToNext()) {     		  
	     		profile=db.getProfile(cursor);
	     		contactList.add(new  ContactView(profile.name,profile.uid,cursor.getPosition()));
		    
	     	}
	     	db.close();
	     	adapList=new FbQrArrayAdapter(this,contactList);
	     	this.setListAdapter(adapList);
		}
	
		@Override
		protected void onListItemClick(ListView l, View v, int position, long id) {			
			super.onListItemClick(l, v, position, id);			
		}
		
		public boolean onPrepareOptionsMenu (Menu menu){
			menu.close();		
			return super.onPrepareOptionsMenu(menu);	
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
			    
			   convertView = inflater.inflate(R.layout.rowlayout_chkbox, null); 
			   
			   
			   final TextView textView = (TextView) convertView.findViewById( R.id.label );  
			   CheckBox checkBox = (CheckBox) convertView.findViewById( R.id.CheckBox01 );  
		       ImageView imageView = (ImageView) convertView.findViewById(R.id.icon);
		       	
		          
		        File img=new File(PATH+contact.getUid()+".PNG");
			    if(img.exists())
			         imageView.setImageBitmap(BitmapFactory.decodeFile(img.getPath()));    
	
			    convertView.setTag( new ViewHolder(textView,checkBox) );  
			  			    
			    checkBox.setOnClickListener( new View.OnClickListener() {  
			    	public void onClick(View v) {  
			            CheckBox cb = (CheckBox) v ;  		            
			            contact.setChecked( cb.isChecked() ); 
			            textView.setText(contact.getName());
			          }  
			    });          
			     
			      checkBox.setTag( contact );   
			        
			      // Display planet data  
			      checkBox.setChecked( contact.isChecked() );  
			      textView.setText( contact.getName() );        
			        
			      return convertView;  
			    } 			
		}		
	}
