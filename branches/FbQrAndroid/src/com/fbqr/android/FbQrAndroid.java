package com.fbqr.android;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import org.json.JSONException;
import org.json.JSONObject;


import android.app.Activity;
import android.app.TabActivity;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.content.pm.ResolveInfo;
import android.content.res.Resources;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.Contacts.People;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TabHost;
import android.widget.TabHost.TabSpec;
import android.widget.TextView;
import android.widget.Toast;



import com.facebook.android.*;
import com.facebook.android.Facebook.DialogListener;

public class FbQrAndroid extends TabActivity{
	   FbQrDatabase db=new FbQrDatabase(this);
	   @Override
	   public void onCreate(Bundle savedInstanceState) {
	       super.onCreate(savedInstanceState);
	       //GUI
	       Resources res = getResources(); // Resource object to get Drawables
	       TabHost tabHost = getTabHost();  // The activity TabHost
	       TabHost.TabSpec spec;  // Resusable TabSpec for each tab
	       Intent intent;  // Reusable Intent for each tab
	       
	       //Add Tab
	       intent = new Intent().setClass(this, FbQrContactlistFav.class);
	       spec = tabHost.newTabSpec("contact").setIndicator("Favorite",
	                         res.getDrawable(R.drawable.favorite_tab))
	                     .setContent(intent);
	       tabHost.addTab(spec);
	       
		   intent = new Intent().setClass(this, FbQrContactlist.class);
	       spec = tabHost.newTabSpec("contact").setIndicator("Contact",
	                         res.getDrawable(R.drawable.contact_tab))
	                     .setContent(intent);
	       tabHost.addTab(spec);
	       
	       intent = new Intent().setClass(this, FbQrGrouplist.class);
	       spec = tabHost.newTabSpec("contact").setIndicator("Group",
	                         res.getDrawable(R.drawable.group_tab))
	                     .setContent(intent);
	       tabHost.addTab(spec);
	       
	       intent = new Intent().setClass(this, FbQrWeb.class);
	       spec = tabHost.newTabSpec("profile").setIndicator("Profile",
	                         res.getDrawable(R.drawable.profile_tab))
	                     .setContent(intent);
	       tabHost.addTab(spec);
	       
	       intent = new Intent().setClass(this, FbQrBackground.class);
	       intent.putExtra("MODE", "READQR");
	       spec = tabHost.newTabSpec("readqr").setIndicator("ReadQR",
	                         res.getDrawable(R.drawable.barcodescan_tab))
	                     .setContent(intent);	     
	       tabHost.addTab(spec);	   
	       
           //setMainTab
	       tabHost.setCurrentTab(0); 	       
	   }
	   public void onStop(Bundle savedInstanceState) {
	       super.onStop();
	       db.close();
	   }
}