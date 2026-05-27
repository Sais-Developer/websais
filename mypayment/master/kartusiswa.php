<?php
require("../../konek/koneksi.php"); 
try {
    $stmt = $pdo->query("SELECT * FROM tmpbayar LIMIT 1");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $kartu = $data['nokartu'] ?? "";  
} catch (PDOException $e) {
    $kartu = "";
}
?>
<input type="text" name="kartusis" id="kartusis" placeholder="Tempel Kartu Siswa" 
       class="form-control" value="<?= htmlspecialchars($kartu); ?>" 
       required autocomplete="off">
