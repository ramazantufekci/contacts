<?php
require_once '../vendor/autoload.php';
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

use DRContacts\db\Db;
use DRContacts\form\Form;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $yeniKullaniciAdi = Form::valid(Form::clean($_POST['kullanici']));
    $yeniSifre        = Form::valid($_POST['sifre']);
    $adSoyad          = Form::clean($_POST['adi']);

    $db = new Db();
    $sonuc = $db->adminEkle($yeniKullaniciAdi, $yeniSifre, $adSoyad);

    if ($sonuc) {
        Header("Refresh: 5; url=/");
        echo "Yeni admin başarıyla eklendi!";
    } else {
        echo "Hata: Kullanıcı adı zaten kullanımda olabilir.";
    }
}
