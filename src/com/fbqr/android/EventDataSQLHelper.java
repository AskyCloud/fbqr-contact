package com.fbqr.android;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.provider.BaseColumns;
import android.util.Log;

/** Helper to the database, manages versions and creation */
public class EventDataSQLHelper extends SQLiteOpenHelper {
	private static final String DATABASE_NAME = "fbqrdb.db";
	private static final int DATABASE_VERSION = 1;

	// Table name
	public static final String TABLE = "profiles";

	// Columns
	public static final String UID = "uid";
	public static final String NAME = "name";
	public static final String PHONE = "phone_number";
	public static final String EMAIL = "email";
	public static final String STATUS = "status";
	public static final String ADDRESS = "address";
	public static final String WEBSITE = "website";
	public static final String LAST_UPDATE = "last_update";
	public static final String DISPLAY = "display";

	public EventDataSQLHelper(Context context) {
		super(context, DATABASE_NAME, null, DATABASE_VERSION);
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
		String sql = "create table " + TABLE + "( " + BaseColumns._ID
				+ " integer primary key autoincrement, " + UID + " text not null,"
				+ NAME + " text," 
				+ PHONE + " text not null," 
				+ EMAIL + " text,"
				+ STATUS + " text," 
				+ ADDRESS + " text," 
				+ WEBSITE + " text," 		
				+ DISPLAY + " text," 	
				+ LAST_UPDATE + " intege);";
		Log.d("EventsData", "onCreate: " + sql);
		db.execSQL(sql);
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		db.execSQL("DROP TABLE IF EXISTS "+TABLE); 
        onCreate(db); 
	}
	
	public void delete(SQLiteDatabase db) {
		db.execSQL("DROP TABLE IF EXISTS "+TABLE); 
        onCreate(db); 
	}
	
	public void update(SQLiteDatabase db) {
		db.execSQL("DROP TABLE IF EXISTS "+TABLE); 
        onCreate(db); 
	}
}
