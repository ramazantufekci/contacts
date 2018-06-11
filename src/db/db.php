<?php
namespace DRContacts\db;
use DRContacts\config\config;
class db
{
	private $baglanti;
	public function __construct()
	{
		$c = new config();
		$this->baglanti = new \mysqli($c->host,$c->username,$c->password,$c->database);
		$this->baglanti->set_charset("utf8");
	}
	
	public function noGetir()
	{
		$sorgu = "select * from crehber order by ad asc";
		$result = $this->baglanti->query($sorgu);
		return $result;
	}
	
	public function lKontrol($kul,$sif)
	{
		$sorgu = "select id,adSoyad from kullanici where kAd='".$kul."' AND kSifre='".md5($sif)."'";
		$result = $this->baglanti->query($sorgu);
		return $result->fetch_object();
	}
	
	public function noKaydet($adi,$sAdi,$telNo,$cKisa,$dKisa)
	{
		$smt = $this->baglanti->query("INSERT INTO crehber(ad,soyad,tel_no,tel_kisa,da_kisa) VALUES('".$adi."','".$sAdi."','".$telNo."','".$cKisa."','".$dKisa."')");
		if($smt)
		{
			return true;
		}else
		{
			return false;
		}
		
		
	}
	public function gGetir($id)
	{
		$sorgu = "SELECT * FROM crehber where id=".$id;
		$result = $this->baglanti->query($sorgu);
		return $result->fetch_object();
	}
	public function noGuncelle($g_adi,$g_sAdi,$g_telNo,$g_cKisa,$g_dKisa,$g_gizli)
	{
		$sorgu = "UPDATE crehber SET ad='".$g_adi."',soyad='".$g_sAdi."',tel_no='".$g_telNo."',tel_kisa='".$g_cKisa."',da_kisa='".$g_dKisa."' WHERE id=".$g_gizli;
		if($this->baglanti->query($sorgu))
		{
			return true;
		}else
		{
			return false;
		}
	}
}

