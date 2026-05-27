<?php
require("../konek/koneksi.php");

$tabel = $_POST['tabel'] ?? '';

if ($tabel) {
    try {
        
        $allowedTables = ['jawaban','soal','nilai']; 
        if (!in_array($tabel, $allowedTables)) {
            throw new Exception("Tabel tidak diizinkan.");
        }

        $sql = "OPTIMIZE TABLE `$tabel`";
        $stmt = $pdo->query($sql); 

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Tabel <b>$tabel</b> berhasil dioptimasi.<br>";
        foreach ($result as $row) {
            echo "Table: {$row['Table']}, Status: {$row['Msg_text']}<br>";
        }

    } catch (PDOException $e) {
        echo "Error saat optimasi: " . $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "Nama tabel tidak boleh kosong.";
}
?>
