package com.fbqr.android;

import java.io.File;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import android.app.Activity;
import android.app.ListActivity;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CheckedTextView;
import android.widget.ImageView;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class FbQrContactlist extends ListActivity {
	/** Called when the activity is first created. */
	FbQrDatabase db=new FbQrDatabase(this);
	ArrayAdapter<ContactView>  adapList=null;
	ArrayList<ContactView> contactList=null;
	
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		//UI
		
		setContentView(R.layout.contactlayout);
		
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
	
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		  super.onActivityResult(requestCode, resultCode, data);
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
     	adapList.notifyDataSetChanged();
	}

	@Override
	protected void onListItemClick(ListView l, View v, int position, long id) {		
		super.onListItemClick(l, v, position, id);
		// Get the item that was clicked
		//Object o = this.getListAdapter().getItem(position);
		FbQrProfile profile=db.getProfile(contactList.get(position).getId());
		if (profile.phone == null)	return;
		profile.count++;
		db.updateData(profile);
		Intent intent = new Intent(Intent.ACTION_CALL, Uri.parse("tel:"+profile.phone));		     
		FbQrContactlist.this.startActivityForResult(intent,0);		
		
	}
	

	private static final int editBtnId = Menu.FIRST;

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		menu.add(0,editBtnId ,editBtnId,"Edit");
	    return super.onCreateOptionsMenu(menu);
	  }
	
	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		
	    // Handle item selection
	    switch (item.getItemId()) {
	    case editBtnId:
	    	Toast.makeText(this, "Edit" , Toast.LENGTH_LONG).show();
	    	Intent intent = new Intent(this, FbQrContactlistEdit.class);
	    	startActivityForResult(intent,1);		
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
	    private String name = "" ;  
	    private String uid = "" ;  
	    private int id;
	    private boolean checked = false ;  
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
}
