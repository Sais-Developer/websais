<?php
require("konek/koneksi.php");
$waktusandik = date('H:i');
try {
    $stmt = $pdo->query("SELECT * FROM status");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $mode_perpus = $data['perpus'];

        if ($mode_perpus == 1) {
            echo $waktusandik . " >>> PINJAM";
        } elseif ($mode_perpus == 2) {
            echo $waktusandik . " >> KEMBALI";
        } elseif ($mode_perpus == 3) {
            echo $waktusandik . " >>>> INPUT";
        } else {
            echo $waktusandik . " >>> MODE TIDAK DIKENAL";
        }
    } else {
        echo "Data tidak ditemukan.";
    }

} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>
