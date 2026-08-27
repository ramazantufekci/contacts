<?php
include_once "../vendor/autoload.php";
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

use DRContacts\db\db;

function exportExcel($filename = 'ExportExcel', $columns = array())
{
    header('Content-Encoding: UTF-8');
    header('Content-Type: text/plain; charset=utf-8');
    header("Content-disposition: attachment; filename=" . $filename . ".xls");
    echo "\xEF\xBB\xBF"; // UTF-8 BOM

    echo '<table border="1"><tr>';
    foreach ($columns as $v) {
        echo '<th style="background-color:#FFA500">' . trim($v) . '</th>';
    }
    echo '</tr>';
    $dv = new db();
    $noBilgi = $dv->noGetir();
    foreach ($noBilgi as $obj) {
        $obj->tel_no = preg_replace("#^(\D{1,4})(\d{1,3})(\d{1,2})#", "($1) $2 $3 ", $obj->tel_no);
        echo "<tr>";
        printf('<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>', $obj->ad, $obj->soyad, $obj->tel_no, $obj->tel_kisa, $obj->da_kisa);
        echo "</tr>";
    }
    /**
     * daha eski bir kullanıım
     * say değişkenini tanımlamalısın
     * $say = count($columns);
    foreach($data as $val){
        echo '<tr>';
        for($i=0; $i < $say; $i++){
 
            if(in_array($i,$replaceDotCol)){
                echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
            }else{
                echo '<td>'.$val[$i].'</td>';
            }
        }
        echo '</tr>';
    }
     */
}

$kolon = array("AD", "SOYAD", "GSM TEL", "CEP DEN KISA KOD", "DAHILI KISA KOD");
exportExcel("Cep-kısa-kod-ve-numaralar", $kolon);
