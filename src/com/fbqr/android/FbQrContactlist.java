package com.fbqr.android;

import android.app.ListActivity;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.Toast;

public class FbQrContactlist extends ListActivity {
	/** Called when the activity is first created. */
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		// Create an array of Strings, that will be put to our ListActivity
		
		
		
			
		FbQrDatabase db=new FbQrDatabase(this);
     	Cursor cursor=db.getEvents();
     	
     	String[] names = new String[cursor.getCount()];
     	int i=0;
     	FbQrProfile profile;
     	while (cursor.moveToNext()) {
     		  profile=db.getProfile(cursor);
     	      names[i++]=profile.phone;
     	      //ret.append(title + "\n");
     	      /*for(int i=0;i<9;i++){
     	    	  String title = cursor.getString(i);
     	    	  ret.append(title + "\n");
     	      }*/
     	    }
     	db.close();
				 
		
		// Use your own layout and point the adapter to the UI elements which contains the label
		this.setListAdapter(new ArrayAdapter<String>(this, R.layout.rowlayout,
				R.id.label, names));
	}

	@Override
	protected void onListItemClick(ListView l, View v, int position, long id) {
		super.onListItemClick(l, v, position, id);
		// Get the item that was clicked
		Object o = this.getListAdapter().getItem(position);
		String keyword = o.toString();
		Toast.makeText(this, "You selected: " + keyword, Toast.LENGTH_LONG)
				.show();

	}
}
