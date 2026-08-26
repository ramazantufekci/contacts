<?php
// Terminalden çalıştırıldığından emin olalım
if (php_sapi_name() !== 'cli') {
    die("Bu dosya sadece terminal uzerinden calistirilabilir.");
}

// Bağımlılıkları ve .env yüklemesini dahil et
require_once __DIR__ . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

use DRContacts\db\migration;

// Migration'ı tetikle
$migration = new migration();
$migration->calistir();
