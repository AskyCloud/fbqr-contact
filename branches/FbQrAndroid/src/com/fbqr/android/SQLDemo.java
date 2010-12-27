package com.fbqr.android;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;


public class SQLDemo{
  EventDataSQLHelper eventsData;
  Cursor cursor;
    public SQLDemo(Context context) {
    eventsData = new EventDataSQLHelper(context);
   // addEvent("Hello Android Event");
    //Cursor cursor = getEvents();
    //showEvents(cursor);
  }
  
   public void close() {
    eventsData.close();
  }

   public void addEvent(String title) {
    SQLiteDatabase db = eventsData.getWritableDatabase();
    ContentValues values = new ContentValues();
    values.put(EventDataSQLHelper.TIME, System.currentTimeMillis());
    values.put(EventDataSQLHelper.TITLE, title);
    db.insert(EventDataSQLHelper.TABLE, null, values);
  }

   public Cursor getEvents() {
    SQLiteDatabase db = eventsData.getReadableDatabase();
    Cursor cursor = db.query(EventDataSQLHelper.TABLE, null, null, null, null, null, null);    
   // startManagingCursor(cursor);
    return cursor;
  }

   public String showEvents() {
	Cursor cursor=getEvents();
    StringBuilder ret = new StringBuilder("Saved Events:\n\n");
    while (cursor.moveToNext()) {
      long id = cursor.getLong(0);
      long time = cursor.getLong(1);
      String title = cursor.getString(2);
      ret.append(id + ": " + time + ": " + title + "\n");
    }
    return ret.toString();
  }
}