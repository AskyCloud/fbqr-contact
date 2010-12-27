package com.fbqr.android;

import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;

import android.app.Activity;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

public class FbQrArrayAdapter extends ArrayAdapter<String> {
	private final Activity context;
	private final String[] names;
	private final String[] displays;
	private final String PATH = "/data/data/com.fbqr.android/files/";  
	
	public FbQrArrayAdapter(Activity context, String[] names,String[] displays) {
		super(context, R.layout.rowlayout, names);
		this.context = context;
		this.names = names;
		this.displays = displays;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		LayoutInflater inflater = context.getLayoutInflater();
		View rowView = inflater.inflate(R.layout.rowlayout, null, true);
		
		TextView label = (TextView) rowView.findViewById(R.id.label);
		label.setText(names[position]);
		System.out.println(names[position]);
     	ImageView imageView = (ImageView) rowView.findViewById(R.id.icon);
		imageView.setImageBitmap(BitmapFactory.decodeFile(PATH+names[position]+".PNG"));		
     	
		return rowView;	}
}
