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
     	Cursor cursor=db.getData();
     	//String[] names = {"1","2","3","4"};
     	//String[] displays = {"http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs427.ash2/70683_1515823225_105544_q.jpg","http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs1319.snc4/161115_100001728618691_59195_q.jpg",
     	//		"http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs427.ash2/70683_1515823225_105544_q.jpg","http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs335.snc4/41705_100000212124399_1244707_q.jpg"};
     	String[] names = new String[cursor.getCount()];
     	String[] uids = new String[cursor.getCount()];
     	int i=0;
     	FbQrProfile profile;
     	while (cursor.moveToNext()) {
     		  profile=db.getProfile(cursor);
     	      names[i]=profile.phone;
     	      uids[i++]=profile.id;
     	      //ret.append(title + "\n");
     	      /*for(int i=0;i<9;i++){
     	    	  String title = cursor.getString(i);
     	    	  ret.append(title + "\n");
     	      }*/
     	    }
     	db.close();
				 
		// Use your own layout and point the adapter to the UI elements which contains the label
     	this.setListAdapter(new FbQrArrayAdapter(this, names,uids));
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
