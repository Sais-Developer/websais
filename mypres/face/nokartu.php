<?php
require("../../konek/koneksi.php"); 

$stmt = $pdo->prepare("SELECT nokartu FROM tmpface LIMIT 1");
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
$nokartu = $data['nokartu'] ?? '';
?>

<input type="text" id="lname" name="lname" placeholder="Tempelkan Kartu RFID Anda" 
       class="form-control" value="<?= $nokartu; ?>" required>
