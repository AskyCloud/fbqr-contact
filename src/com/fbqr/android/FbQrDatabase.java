package com.fbqr.android;

import java.util.ArrayList;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;


public class FbQrDatabase{
  EventDataSQLHelper eventsData;
  Cursor cursor;
    public FbQrDatabase(Context context) {
    eventsData = new EventDataSQLHelper(context);
   // addEvent("Hello Android Event");
    //Cursor cursor = getEvents();
    //showEvents(cursor);
  }
  
   public void close() {
    eventsData.close();
  }
  
   public void delete() {
	   SQLiteDatabase db = eventsData.getReadableDatabase();
	   eventsData.delete(db);
   }


   public void addEvent(FbQrProfile data) {
    SQLiteDatabase db = eventsData.getWritableDatabase();
    ContentValues values = new ContentValues();
    values.put(EventDataSQLHelper.ADDRESS, data.address);
    values.put(EventDataSQLHelper.EMAIL, data.email);
    //values.put(EventDataSQLHelper.LAST_UPDATE, );
    values.put(EventDataSQLHelper.NAME, data.name);
    values.put(EventDataSQLHelper.PHONE, data.phone);
    values.put(EventDataSQLHelper.STATUS, data.status);
    values.put(EventDataSQLHelper.UID, data.id);
    values.put(EventDataSQLHelper.WEBSITE, data.website);
    db.insert(EventDataSQLHelper.TABLE, null, values);
  }

   public Cursor getEvents() {
    SQLiteDatabase db = eventsData.getReadableDatabase();
    Cursor cursor = db.query(EventDataSQLHelper.TABLE, null, null, null, null, null, null);    
   // startManagingCursor(cursor);
    return cursor;
  }
   
   public FbQrProfile getProfile(int id) {
	    SQLiteDatabase db = eventsData.getReadableDatabase();
	    Cursor cursor = db.query(EventDataSQLHelper.TABLE, null, null, null, null, null, null);    
	    cursor.moveToPosition(id);
	    return getProfile(cursor);
   }
   
   public FbQrProfile getProfile(Cursor cursor) {
	    FbQrProfile data=new FbQrProfile();
	    data.id=cursor.getString(1);
	    data.name=cursor.getString(2);
	    data.phone=cursor.getString(3);
	    data.email=cursor.getString(4);
	    data.status=cursor.getString(5);
	    data.address=cursor.getString(6);
	    data.website=cursor.getString(7);
	    data.last_update=cursor.getString(8);
	    return data;
  }

   public String showEvents() {
	Cursor cursor=getEvents();
    StringBuilder ret = new StringBuilder("Saved Events:\n\n");
    while (cursor.moveToNext()) {
      long id = cursor.getLong(0);
      ret.append(id+ ":" );
      String title = cursor.getString(1);
      ret.append(title + "\n");
      /*for(int i=0;i<9;i++){
    	  String title = cursor.getString(i);
    	  ret.append(title + "\n");
      }*/
    }
    return ret.toString();
  }
}