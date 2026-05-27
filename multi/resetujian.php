<?php
require(__DIR__ . "/../konek/koneksi.php");
header('Content-Type: application/json; charset=utf-8');

try {
    $hapus_flag = '1';

    /* ===============================
       HITUNG DATA YANG AKAN DIHAPUS
       =============================== */
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM nilai WHERE hapus = :hapus");
    $stmt->execute([':hapus' => $hapus_flag]);
    $jumlah = (int) $stmt->fetchColumn();

    if ($jumlah === 0) {
        echo json_encode([
            "status"  => "error",
            "message" => "Tidak ada aktivitas penghapusan (hapus=1)."
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    /* ===============================
       HAPUS DATA
       =============================== */
    $stmt = $pdo->prepare("DELETE FROM nilai WHERE hapus = :hapus");
    $stmt->execute([':hapus' => $hapus_flag]);
    $deleted_rows = $stmt->rowCount();

    echo json_encode([
        "status"  => "success",
        "message" => "Berhasil dihapus.",
        "deleted" => $deleted_rows
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "Terjadi kesalahan: " . $e->getMessage()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
