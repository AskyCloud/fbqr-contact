package com.fbqr.android;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.provider.BaseColumns;
import android.util.Log;

/** Helper to the database, manages versions and creation */
public class EventDataSQLHelper extends SQLiteOpenHelper {
	private static final String DATABASE_NAME = "fbqrdb.db";
	private static final int DATABASE_VERSION = 24;

	// Table name
	public static final String TABLE = "profiles";
	public static final String cfgTABLE = "config";
	public static final String favTABLE = "favorite";
	public static final String grpTABLE = "groups";

	// Columns
	public static final String ID = BaseColumns._ID;
	public static final String UID = "uid";
	public static final String GID = "uid";
	public static final String UIDS = "uids";
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
				+ " integer primary key autoincrement, "
				+ UID + " text,"
				+ NAME + " text," 
				+ PHONE + " text," 
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
				+ " integer primary key autoincrement, " +ACCESS_TOKEN + " text not null);";
		db.execSQL(sql);
		sql = "create table " + favTABLE + "(" + BaseColumns._ID
			+ " integer primary key autoincrement, " 
			+ UID + " text not null);";
		db.execSQL(sql);
		sql = "create table " + grpTABLE + "(" + BaseColumns._ID
			+ " integer primary key autoincrement, " 
			+ GID + " text not null,"
			+ NAME + " text,"
			+ WEBSITE + " text," 
			+ UIDS + " text );";
		db.execSQL(sql);
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		db.execSQL("DROP TABLE IF EXISTS "+TABLE); 
		db.execSQL("DROP TABLE IF EXISTS "+cfgTABLE); 
		db.execSQL("DROP TABLE IF EXISTS "+favTABLE); 
		db.execSQL("DROP TABLE IF EXISTS "+grpTABLE); 
        onCreate(db); 
	}
	
	public void delete(SQLiteDatabase db) {
		db.execSQL("DROP TABLE IF EXISTS "+TABLE); 
		db.execSQL("DROP TABLE IF EXISTS "+cfgTABLE); 
		db.execSQL("DROP TABLE IF EXISTS "+favTABLE); 
		db.execSQL("DROP TABLE IF EXISTS "+grpTABLE); 
        onCreate(db); 
	}
}
