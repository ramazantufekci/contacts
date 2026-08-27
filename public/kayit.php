<?php
session_start();
include_once "../vendor/autoload.php";
if (file_exists(__DIR__ . '/../.env')) {
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
	$dotenv->load();
}

use DRContacts\db\Db;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$db = new Db();
	if ($_SESSION["id"] == $_POST["session"] && isset($_POST["g_gizli"])) {
		$adi = $_POST["g_adi"];
		$sadi = $_POST["g_sAdi"];
		$telNo = $_POST["g_telNo"];
		$cKisa = $_POST["g_cKisa"];
		$dKisa = $_POST["g_dKisa"];
		$gizli = $_POST["g_gizli"];
		var_export($db->noGuncelle($adi, $sadi, $telNo, $cKisa, $dKisa, $gizli));
	}

	if ($_SESSION["id"] == $_POST["session"] && !isset($_POST["g_gizli"])) {

		$adi = $_POST["adi"];
		$sadi = $_POST["sAdi"];
		$telNo = $_POST["telNo"];
		$cKisa = $_POST["cKisa"];
		$dKisa = $_POST["dKisa"];
		echo $db->noKaydet($adi, $sadi, $telNo, $cKisa, $dKisa);
	}
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_numeric($_GET["id"]) && isset($_GET["token"]) && $_GET["token"] === $_SESSION["token"]) {
	$token = hash('sha256', time() . rand(1000, 9999));
	if (isset($_SESSION["token"]) && $token !== $_SESSION["token"]) {

		$_SESSION["token"] = $token;
	}
	$db = new Db();
	if ($db->noSil($_GET["id"])) {
		echo json_encode(["status" => "success", "message" => "Kayıt silindi."]);
	}
	return json_encode(["status" => "error", "message" => "Kayıt silinemedi."]);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_numeric($_GET["id"])) {
	$db = new Db();
	echo json_encode($db->gGetir($_GET["id"]));
}
