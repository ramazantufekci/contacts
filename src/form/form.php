<?php

namespace DRContacts\form;

class form
{
	public static function valid($value)
	{
		if(preg_match("#[a-zA-Z0-9\.-ÖÇŞİĞÜöçşiğüı@]+#",$value))
		{
			return $value;
		}else
		{
			header("Refresh: 5; url=".$_SERVER["HTTP_HOST"]."/");
			die("<center>Kullanici adi veya sifre yanlis !!!<br />Anasayfa'ya yönlendiriliyorsunuz.</center>");
			
			
		}
	}
}