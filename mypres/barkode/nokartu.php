<?php
require("../../konek/koneksi.php");
$stmt = $db->prepare("SELECT nokartu FROM tmpreg LIMIT 1");
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
$nokartu = $data['nokartu'] ?? '';
?>
	
	<input type="text" name="nokartu" id="nokartu" placeholder="Scan Kartu Barcode Anda" class="form-control"  value="<?= $nokartu; ?>" required="true">
