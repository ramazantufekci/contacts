<?php

namespace DRContacts\db;

use DRContacts\config\config;
use PDO;
use PDOException;

class Migration
{
    private PDO $baglanti;

    public function __construct()
    {
        $c = new config();
        // İlk bağlantıda veritabanı adını seçmiyoruz çünkü veritabanı hiç var olmayabilir
        $dsn = "mysql:host={$c->host};charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->baglanti = new PDO($dsn, $c->username, $c->password, $options);

            // 1. Veritabanı yoksa otomatik oluştur
            $this->baglanti->exec("CREATE DATABASE IF NOT EXISTS `{$c->database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            // 2. Oluşturulan veritabanını seç
            $this->baglanti->exec("USE `{$c->database}`");
        } catch (PDOException $e) {
            die("Migration bağlantı hatası: " . $e->getMessage());
        }
    }

    public function calistir(): void
    {
        echo "Migration baslatiliyor...\n";

        // Kullanıcı tablosu şeması
        $kullaniciTablosu = "
            CREATE TABLE IF NOT EXISTS `kullanici` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `kAd` VARCHAR(50) NOT NULL UNIQUE,
                `kSifre` VARCHAR(255) NOT NULL,
                `adSoyad` VARCHAR(100) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        // Rehber tablosu şeması
        $rehberTablosu = "
            CREATE TABLE IF NOT EXISTS `crehber` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `ad` VARCHAR(100) NOT NULL,
                `soyad` VARCHAR(100) NOT NULL,
                `tel_no` VARCHAR(20) NOT NULL,
                `tel_kisa` VARCHAR(10) NULL,
                `da_kisa` VARCHAR(10) NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        try {
            // Tabloları oluştur
            $this->baglanti->exec($kullaniciTablosu);
            echo "[OK] 'kullanici' tablosu hazir.\n";

            $this->baglanti->exec($rehberTablosu);
            echo "[OK] 'crehber' tablosu hazir.\n";

            // Varsayılan bir admin kullanıcısı ekle (Eğer tablo boşsa)
            $kontrol = $this->baglanti->query("SELECT COUNT(*) as toplam FROM kullanici")->fetch();
            if ($kontrol->toplam == 0) {
                $varsayilanSifre = password_hash('admin123', PASSWORD_BCRYPT); // İleride password_hash() yapılabilir
                $ekle = $this->baglanti->prepare("INSERT INTO kullanici (kAd, kSifre, adSoyad) VALUES (:kad, :sifre, :isim)");
                $ekle->execute([
                    'kad' => 'admin',
                    'sifre' => $varsayilanSifre,
                    'isim' => 'Sistem Yöneticisi'
                ]);
                echo "[SEED] Varsayilan kullanici olusturuldu (Kullanici: admin / Sifre: admin123)\n";
            }

            echo "Migration basariyla tamamlandi!\n";
        } catch (PDOException $e) {
            die("[HATA] Tablolar olusturulamadi: " . $e->getMessage() . "\n");
        }
    }
}
