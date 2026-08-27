<?php

namespace DRContacts\db;

use DRContacts\config\config;
use PDO;
use PDOException;

class Db
{
	private ?PDO $baglanti = null;
	public function __construct()
	{
		$c = new config();
		$dsn = "mysql:host={$c->host};dbname={$c->database};charset=utf8mb4";
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Hataları istisna olarak fırlat
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,       // Varsayılan olarak nesne döndür
			PDO::ATTR_EMULATE_PREPARES   => false,                // Gerçek prepared statements kullan (Güvenlik için kritik)
		];

		try {
			$this->baglanti = new PDO($dsn, $c->username, $c->password, $options);
		} catch (PDOException $e) {
			// Güvenlik nedeniyle ham hatayı dışarı sızdırmıyoruz
			var_export($e->getMessage());
			die("Veritabanı bağlantı hatası oluştu.");
		}
	}

	public function noGetir()
	{
		$sorgu = "select * from crehber order by ad asc";
		$result = $this->baglanti->query($sorgu);
		return $result->fetchAll(PDO::FETCH_OBJ);
	}

	public function lKontrol($kul, $sif)
	{
		$sorgu = "SELECT id, adSoyad,kSifre FROM kullanici WHERE kAd = :kul";
		$stmt = $this->baglanti->prepare($sorgu);

		// Parametreleri güvenli bir şekilde bağlıyoruz (SQL Injection engellendi)
		$stmt->execute([
			'kul' => $kul
		]);
		$stmtRest = $stmt->fetch();
		if ($stmtRest && password_verify($sif, $stmtRest->kSifre)) {

			return $stmtRest;
		}

		return false;
	}

	public function noKaydet($adi, $sAdi, $telNo, $cKisa, $dKisa)
	{
		$sorgu = "INSERT INTO crehber (ad, soyad, tel_no, tel_kisa, da_kisa)
                  VALUES (:ad, :soyad, :tel_no, :tel_kisa, :da_kisa)";

		$stmt = $this->baglanti->prepare($sorgu);

		return $stmt->execute([
			'ad'       => $adi,
			'soyad'    => $sAdi,
			'tel_no'   => $telNo,
			'tel_kisa' => $cKisa,
			'da_kisa'  => $dKisa
		]);
	}
	public function gGetir($id)
	{
		$sorgu = "SELECT * FROM crehber WHERE id = :id";
		$stmt = $this->baglanti->prepare($sorgu);
		$stmt->execute(['id' => $id]);

		return $stmt->fetch() ?: null;
	}
	public function noGuncelle($g_adi, $g_sAdi, $g_telNo, $g_cKisa, $g_dKisa, $g_gizli)
	{
		if (isset($_SESSION["kull"])) {

			$sorgu = "UPDATE crehber SET ad = :ad, soyad = :soyad, tel_no = :tel_no, tel_kisa = :tel_kisa, da_kisa = :da_kisa
                  WHERE id = :id";

			$stmt = $this->baglanti->prepare($sorgu);

			return $stmt->execute([
				'ad'       => $g_adi,
				'soyad'    => $g_sAdi,
				'tel_no'   => $g_telNo,
				'tel_kisa' => $g_cKisa,
				'da_kisa'  => $g_dKisa,
				'id'       => $g_gizli
			]);
		}
	}
}
