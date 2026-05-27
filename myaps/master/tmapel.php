<?php
require("../../konek/koneksi.php"); 
require("../../konek/crud.php");

$idu = $_POST['id'] ?? 0;

if ($idu) {
    delete("mapel", ["id" => $idu]);
    $rows = select("mapel", [], "id ASC");
    $no = 1;
    foreach ($rows as $r) {
        update("mapel", ["id" => $no], ["id" => $r["id"]]);
        $no++;
    }
    $db->exec("ALTER TABLE mapel AUTO_INCREMENT = $no");

    echo "ok";
}
