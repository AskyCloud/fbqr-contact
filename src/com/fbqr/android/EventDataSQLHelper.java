package com.fbqr.android;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.provider.BaseColumns;
import android.util.Log;

/** Helper to the database, manages versions and creation */
public class EventDataSQLHelper extends SQLiteOpenHelper {
	private static final String DATABASE_NAME = "fbqrdb.db";
	private static final int DATABASE_VERSION = 18;

	// Table name
	public static final String TABLE = "profiles";
	public static final String cfgTABLE = "config";

	// Columns
	public static final String ID = BaseColumns._ID;
	public static final String UID = "uid";
	public static final String NAME = "name";
	public static final String PHONE = "phone";
	public static final String EMAIL = "email";
	public static final String STATUS = "status";
	public static final String ADDRESS = "address";
	public static final String WEBSITE = "website";
	public static final String LAST_UPDATE = "last";
	public static final String DISPLAY = "display";
	public static final String PASSWORD = "password";
	public static final String COUNT = "count";
	public static final String ACCESS_TOKEN = "accesstoken";

	public EventDataSQLHelper(Context context) {
		super(context, DATABASE_NAME, null, DATABASE_VERSION);
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
		String sql = "create table " + TABLE + "( " + BaseColumns._ID
				+ " integer primary key autoincrement, " + UID + " text,"
				+ NAME + " text," 
				+ PHONE + " text not null," 
				+ EMAIL + " text,"
				+ STATUS + " text," 
				+ ADDRESS + " text," 
				+ WEBSITE + " text," 		
				+ DISPLAY + " text," 	
				+ PASSWORD + " text," 
				+ COUNT + " integer," 
				+ LAST_UPDATE + " intege);";
		Log.d("EventsData", "onCreate: " + sql);		
		db.execSQL(sql);		
		sql = "create table " + cfgTABLE + "(" + BaseColumns._ID
				+ " integer primary key autoincrement, " +ACCESS_TOKEN + " text);";
		db.execSQL(sql);
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		db.execSQL("DROP TABLE IF EXISTS "+TABLE); 
		db.execSQL("DROP TABLE IF EXISTS "+cfgTABLE); 
        onCreate(db); 
	}
	
	public void delete(SQLiteDatabase db) {
		db.execSQL("DROP TABLE IF EXISTS "+TABLE); 
		db.execSQL("DROP TABLE IF EXISTS "+cfgTABLE); 
        onCreate(db); 
	}
}
