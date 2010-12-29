package com.fbqr.android;

import android.app.ListActivity;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.net.Uri;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.CheckedTextView;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.Toast;

public class FbQrContactlist extends ListActivity {
	/** Called when the activity is first created. */
	FbQrDatabase db=new FbQrDatabase(this);
	FbQrArrayAdapter adapList=null;
	private int[] idx;
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		// Create an array of Strings, that will be put to our ListActivity
		
		
     	Cursor cursor=db.getData();
     	//String[] names = {"1","2","3","4"};
     	//String[] displays = {"http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs427.ash2/70683_1515823225_105544_q.jpg","http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs1319.snc4/161115_100001728618691_59195_q.jpg",
     	//		"http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs427.ash2/70683_1515823225_105544_q.jpg","http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs335.snc4/41705_100000212124399_1244707_q.jpg"};
     	String[] names = new String[cursor.getCount()];
     	String[] uids = new String[cursor.getCount()];
     	idx= new int[cursor.getCount()];
     	int i=0;
     	FbQrProfile profile;
     	while (cursor.moveToNext()) {
     		  profile=db.getProfile(cursor);
     	      names[i]=profile.name;
     	      idx[i]=cursor.getPosition();
     	      uids[i++]=profile.uid;
     	      //ret.append(title + "\n");
     	      /*for(int i=0;i<9;i++){
     	    	  String title = cursor.getString(i);
     	    	  ret.append(title + "\n");
     	      }*/
     	    }
     	db.close();
				 
		// Use your own layout and point the adapter to the UI elements which contains the label
     	this.setListAdapter(adapList=new FbQrArrayAdapter(this, names,uids));
	}

	@Override
	protected void onListItemClick(ListView l, View v, int position, long id) {
		
		super.onListItemClick(l, v, position, id);
		// Get the item that was clicked
		//Object o = this.getListAdapter().getItem(position);
		FbQrProfile profile=db.getProfile(idx[position]);
		//String keyword = profile.name;
		//Toast.makeText(this, "You selected: " + keyword, Toast.LENGTH_LONG).show();
		if (profile.phone == null)	return;
		Intent intent = new Intent(Intent.ACTION_CALL, Uri.parse("tel:"+profile.phone));		     
		FbQrContactlist.this.startActivity(intent);		
	}
	

	private static final int searchBtnId = Menu.FIRST;
	private static final int updateBtnId = Menu.FIRST+1;
	private static final int deleteBtnId = Menu.FIRST+2;
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		//menu.add(0,searchBtnId ,searchBtnId,"Search");
		//menu.add(0,updateBtnId ,updateBtnId,"Update");
		menu.add(0,deleteBtnId ,deleteBtnId,"Delete");
	    return super.onCreateOptionsMenu(menu);

	  }
	
	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
	    // Handle item selection
	    switch (item.getItemId()) {
	    case searchBtnId:
	    	Toast.makeText(this, "You selected: Search" , Toast.LENGTH_LONG).show();
	        return true;
	    case updateBtnId:
	    	Toast.makeText(this, "You selected: Update", Toast.LENGTH_LONG).show();
	        return true;
	    case deleteBtnId:
	    	/*int _size =this.getListView().getCount();
	    	for (int i =0; i< _size; i++) {
	    		if(adapList.del[i]){
	    			db.deleteData(idx[i]);
	    		}
	    			    		
	    	}*/
	    	db.delete();	
	    	adapList.notifyDataSetChanged ();
	    	Toast.makeText(this, "You selected: Delete", Toast.LENGTH_LONG).show();
	        return true;
	    default:
	        return super.onOptionsItemSelected(item);
	    }
	}

}
