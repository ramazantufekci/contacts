<?php
session_start();
include_once("../vendor/autoload.php");
use DRContacts\db\db;
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$db = new db();
	if($_SESSION["id"]==$_POST["session"] && isset($_POST["g_gizli"]))
	{
		$adi = $_POST["g_adi"];
		$sadi = $_POST["g_sAdi"];
		$telNo = $_POST["g_telNo"];
		$cKisa = $_POST["g_cKisa"];
		$dKisa = $_POST["g_dKisa"];
		$gizli = $_POST["g_gizli"];
		var_export($db->noGuncelle($adi,$sadi,$telNo,$cKisa,$dKisa,$gizli));
	}
	
	if($_SESSION["id"]==$_POST["session"] && !isset($_POST["g_gizli"]))
	{
		
		//var_export($_POST);
		
		$adi = $_POST["adi"];
		$sadi = $_POST["sAdi"];
		$telNo = $_POST["telNo"];
		$cKisa = $_POST["cKisa"];
		$dKisa = $_POST["dKisa"];
		$db->noKaydet($adi,$sadi,$telNo,$cKisa,$dKisa);
	}
}
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if(is_numeric($_GET["id"]))
	{
		$db = new db();
		
		echo json_encode($db->gGetir($_GET["id"])); 
		
	}
}

