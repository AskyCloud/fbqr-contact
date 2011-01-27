package com.fbqr.android;

public class FbQrGroup {
	public int position;
	public String name=null,gid=null,website=null;
	public String[] uids=null;
	public String[] explode(String uidsText){
		String buff[] = uidsText.split(";") ;
		uids = new String[buff.length];
		for(int i=0;i<buff.length;i++){
			uids[i]=buff[i];
		}
		return uids;
	}
}
