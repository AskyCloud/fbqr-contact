package com.fbqr.android;

import java.util.ArrayList;

import android.app.Activity;
import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;


public class FbQrDatabase extends Activity{
  EventDataSQLHelper eventsData=null;
  Cursor cursor;
  
  public FbQrDatabase(Context context) {
	  eventsData = new EventDataSQLHelper(context);
  }
  
  public boolean isOpen() {
	  SQLiteDatabase db = eventsData.getReadableDatabase();
	  return db.isOpen();
 }  
  
  public void close() {
	   eventsData.close();
  }
  
   public void delete() {
	   SQLiteDatabase db = eventsData.getReadableDatabase();
	   eventsData.delete(db);
   }
   
   private ContentValues addValues(FbQrProfile data){
	   ContentValues values = new ContentValues();
	    values.put(EventDataSQLHelper.ADDRESS, data.address);
	    values.put(EventDataSQLHelper.EMAIL,data.email);
	    values.put(EventDataSQLHelper.LAST_UPDATE,System.currentTimeMillis());
	    if(data.count!=-1) values.put(EventDataSQLHelper.COUNT,data.count);
	    values.put(EventDataSQLHelper.NAME, (data.name!=null)?data.name:data.phone);
	    values.put(EventDataSQLHelper.PHONE, data.phone);
	    values.put(EventDataSQLHelper.STATUS, data.status);
	    values.put(EventDataSQLHelper.UID, data.uid);
	    values.put(EventDataSQLHelper.WEBSITE, data.website);
	    values.put(EventDataSQLHelper.DISPLAY, data.display);
	    values.put(EventDataSQLHelper.PASSWORD, data.password);
	    return values;
	   
   }
   
  
  public void addData(FbQrProfile data) {
	  SQLiteDatabase db = eventsData.getWritableDatabase();
	  if(data.phone!=null||data.uid!=null){
		  if(updateData(data)) return;
		  data.count=0;
		  db.insert(EventDataSQLHelper.TABLE, null, addValues(data));   
	  }
  }
  
  public boolean updateData(FbQrProfile data) {
	  SQLiteDatabase db = eventsData.getWritableDatabase();
	  int updated=0;
	  if(data.uid==null){
		  updated=db.update(EventDataSQLHelper.TABLE, addValues(data), EventDataSQLHelper.PHONE+ " = " +"'"+ data.phone+"'", null );		  
	  }
	  else {
		  //Bug
		  copyProfile(data);
		  updated=db.update(EventDataSQLHelper.TABLE, addValues(data), EventDataSQLHelper.UID+ " = " + "'"+data.uid+"'", null);
		  if(updated==0) updated=db.update(EventDataSQLHelper.TABLE, addValues(data), EventDataSQLHelper.PHONE+ " = " +"'"+ data.phone+"'", null );
	  }
	  return updated>0;
 }
  
  public boolean deleteData(String uid){
	  SQLiteDatabase db = eventsData.getWritableDatabase();
	  return db.delete(EventDataSQLHelper.TABLE, EventDataSQLHelper.UID+ "=" + uid, null)>0;
  } 
  
  public boolean deleteData(int id){
	  SQLiteDatabase db = eventsData.getWritableDatabase();
	  return db.delete(EventDataSQLHelper.TABLE, EventDataSQLHelper.ID+ "=" + id, null)>0;
  } 
  
  public Cursor getData() {
	  SQLiteDatabase db = eventsData.getReadableDatabase();
	  Cursor cursor = db.query(EventDataSQLHelper.TABLE, null, null, null, null, null, EventDataSQLHelper.COUNT + " DESC"); 
	  startManagingCursor(cursor);
	  return cursor;
  }
  
  public FbQrProfile getProfile(String uid) {
	  SQLiteDatabase db = eventsData.getReadableDatabase();
	  Cursor cursor = db.query(EventDataSQLHelper.TABLE, null, EventDataSQLHelper.UID+ " = "+ "'"+uid+"'", null, null, null, null);   
	  startManagingCursor(cursor);
	  if(!cursor.moveToFirst()) return null;
	  else  return getProfile(cursor);
   }
  
  public FbQrProfile getProfile(int id) {
	  SQLiteDatabase db = eventsData.getReadableDatabase();
	  Cursor cursor = db.query(EventDataSQLHelper.TABLE, null, EventDataSQLHelper.ID+ " = " + id, null, null, null, null);
	  startManagingCursor(cursor);
	  cursor.moveToFirst();
	  if(!cursor.moveToFirst()) return null;
	  else  return getProfile(cursor);
   }
  
  public int getIdByUid(String uid) {
	  SQLiteDatabase db = eventsData.getReadableDatabase();
	  Cursor cursor = db.query(EventDataSQLHelper.TABLE, null, EventDataSQLHelper.UID+ " = "+ "'"+uid+"'", null, null, null, null);   
	  startManagingCursor(cursor);
	  if(!cursor.moveToFirst()) return -1;
	  else  return cursor.getInt(0);
   }
  
  public void setAccessToken(String access_token){
	  SQLiteDatabase db = eventsData.getWritableDatabase();
	  ContentValues values = new ContentValues();
	    values.put(EventDataSQLHelper.ACCESS_TOKEN, access_token);
	  Boolean update=db.update(EventDataSQLHelper.cfgTABLE, values, EventDataSQLHelper.ID+ " = 1", null)>0;
	  if(update) return ;
	  else db.insert(EventDataSQLHelper.cfgTABLE, null, values);  
   }
  
  public String getAccessToken(){
	  String AccessToken=null;
	  SQLiteDatabase db = eventsData.getWritableDatabase();
	  Cursor cursor = db.query(EventDataSQLHelper.cfgTABLE, null, null, null, null, null, null);
	  startManagingCursor(cursor);
	  if(!cursor.moveToFirst()) AccessToken=null;	  
	  else AccessToken=cursor.getString(1);
	  return AccessToken;
   }
   
 public FbQrProfile getProfile(Cursor cursor) {
	 	if(cursor==null) return null;
	    FbQrProfile data=new FbQrProfile();
	    data.uid=cursor.getString(1);
	    data.name=cursor.getString(2);
	    data.phone=cursor.getString(3);
	    data.email=cursor.getString(4);
	    data.status=cursor.getString(5);
	    data.address=cursor.getString(6);
	    data.website=cursor.getString(7);
	    data.display=cursor.getString(8);
	    data.password=cursor.getString(9);
	    data.count=cursor.getLong(10);
	    data.last_update=cursor.getLong(11);
	    return data;
  }
   


   public String showData() {
	Cursor cursor=getData();
	startManagingCursor(cursor);
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
   
   private void copyProfile(FbQrProfile data){
	   FbQrProfile old = getProfile(data.uid);
	   if(old==null) return;
	   if(data.phone==null) data.phone=old.phone;
	   if(data.address==null) data.address=old.address;
	   if(data.display==null) data.display=old.display;
	   if(data.email==null) data.email=old.email;
	   if(data.name==null) data.name=old.name;
	   if(data.password==null) data.password=old.password;
	   if(data.status==null) data.status=old.status;
	   if(data.website==null) data.website=old.website;	   
   }
}