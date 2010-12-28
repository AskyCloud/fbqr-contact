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
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class FbQrArrayAdapter extends ArrayAdapter<String> {
	private final Activity context;
	public boolean[] del;
	private final String[] names;
	private final String[] uids;
	private final String PATH = "/data/data/com.fbqr.android/files/";  
	
	public FbQrArrayAdapter(Activity context, String[] names,String[] uids) {
		super(context, R.layout.rowlayout, names);
		this.context = context;
		this.names = names;
		this.uids = uids;
		del=new boolean[uids.length];
	}

	@Override
	public View getView(final int position, View convertView, ViewGroup parent) {
		LayoutInflater inflater = context.getLayoutInflater();
		View rowView = inflater.inflate(R.layout.rowlayout_chkbox, null, true);
		final TextView label = (TextView) rowView.findViewById(R.id.label);
		CheckBox chkbox = (CheckBox) rowView.findViewById(R.id.CheckBox01);
		label.setText(names[position]);
		System.out.println(names[position]);
     	ImageView imageView = (ImageView) rowView.findViewById(R.id.icon);
		imageView.setImageBitmap(BitmapFactory.decodeFile(PATH+uids[position]+".PNG"));	
		
		chkbox.setOnCheckedChangeListener(new OnCheckedChangeListener() {			 
			@Override
			public void onCheckedChanged(CompoundButton buttonView,
					boolean isChecked) {
				if (isChecked == true) {
					del[position]=true;
				}else del[position]=false;	
				// TODO Auto-generated method stub
				
			}
		});

		return rowView;	
	}
}
