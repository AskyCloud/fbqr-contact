package com.fbqr.android;



import java.util.ArrayList;

import org.ksoap2.serialization.SoapObject;

public class ReadFbQR{
	ArrayList<FbQrProfile> profileList=new ArrayList();
	public String type;
	public String name;
	public String qrid;
	public String qrtext;
	
	public void read(String qrtext){
		profileList.clear();
		if(qrtext.startsWith("MECARD:")){ //if multi data
			qrtext = qrtext.replaceFirst("MECARD:",""); 
			String[] str=qrtext.split(";");
			
			if(str[0].startsWith("N:FbQRContact")){ //if multi contact
				multiqr(str);
			}
			else addSingleProfile(str); //individual qr
		}
		else{ //if single data
			if(qrtext.startsWith("tel:")) addSingledata(qrtext,"tel:","phone");
			else if(qrtext.startsWith("mailto:")) addSingledata(qrtext,"mailto:","email");
				else if(qrtext.startsWith("http://")) addSingledata(qrtext,"http://","website");		
					else {
						type="etc";
						this.qrtext=qrtext;
					}
		}
	}
	private boolean addSingledata(String qrtext,String tag,String val){
		type="data";
		SoapObject x=new SoapObject("","");
		if(qrtext.indexOf(tag) > -1){
			x.addProperty(val, qrtext.toString());
			profileList.add(new FbQrProfile(x));
	 	  }
		return true;
	}
	
	private boolean addSingleProfile(String[] str){
		type="single";
		String[] val={"name","phone","address","website","status","email","id"};
		String[] tagQR={"N:","TEL:","ADR:","URL:","NOTE:","EMAIL:","UID:"};
		int i=0;
		SoapObject x=new SoapObject("","");
		for(String istr:str){
			while(istr.indexOf(tagQR[i]) <= -1) if(++i>val.length) return false;
			x.addProperty(val[i].toString(), istr.replaceFirst(tagQR[i],"").toString());
		}
		profileList.add(new FbQrProfile(x));
		return true;
	}
	
	private boolean multiqr(String[] str){
		if(str[2].indexOf("TYPE:") > -1){
			type=str[2].replaceFirst("TYPE:","").toString();
			if(type.matches("multiqr_p")){
				addMultiProfile(str,"password");
			}
			else if(type.matches("multiqr_n")){
				addMultiProfile(str);
			}
		}
		return true;
	}
	
	private boolean addMultiProfile(String[] str){
		return addMultiProfile(str,"");
	}
	
	private boolean addMultiProfile(String[] str,String password){
		String[] tagQR={"name","phone"};
		name=str[3].replaceFirst("GN:","");
		qrid=str[4].replaceFirst("QRID:","");
		for(int i=5;i<str.length;i++){
			if(str[i].startsWith("P:")){
				SoapObject x=new SoapObject("","");
				str[i]=str[i].replaceFirst("P:","");
				String[] data=str[i].split(",");
				for(int j=0;j<data.length;j++)
					x.addProperty( tagQR[j].toString(), data[j].toString());
				profileList.add(new FbQrProfile(x));				
			}
		}		
		return true;
	}
}

