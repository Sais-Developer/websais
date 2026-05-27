<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';

if ($pg == 'model') {
    $idb = $_POST['idb'];

    $stmt = $pdo->prepare("SELECT * FROM m_bayar WHERE id = :idb");
    $stmt->execute([':idb' => $idb]);

    while ($kel = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $model = ($kel['model'] == 1) ? 'Sekali Bayar' : 'Bulanan';
        echo "<option value='" . htmlspecialchars($kel['model']) . "'>$model</option>";
    }
}

if ($pg == 'bayar') {
    $bulan   = date('m');
    $tahun   = date('Y');
    $tanggal = date('Y-m-d');

    $kelas   = $_POST['kelas'];
    $ids     = $_POST['idsiswa'];
    $idbayar = $_POST['idb'];
    $besar   = $_POST['besar'];
    $duit    = filter_var($besar, FILTER_SANITIZE_NUMBER_INT);

    $stmt = $pdo->prepare("
        SELECT 1 
        FROM trx_bayar 
        WHERE idsiswa = :ids 
          AND bulan = :bulan 
          AND tahun = :tahun 
          AND idbayar = :idbayar
    ");
    $stmt->execute([
        ':ids' => $ids,
        ':bulan' => $bulan,
        ':tahun' => $tahun,
        ':idbayar' => $idbayar
    ]);
    $cek = $stmt->rowCount();

    if ($cek == 0) {
       
        $stmt = $pdo->prepare("
            SELECT COUNT(*) AS total 
            FROM trx_bayar 
            WHERE idsiswa = :ids AND idbayar = :idbayar
        ");
        $stmt->execute([
            ':ids' => $ids,
            ':idbayar' => $idbayar
        ]);
        $trx = $stmt->fetchColumn();

        $ke = $trx + 1;
        $bukti = date('YmdHis') . '-' . $ke;

        $stmt = $pdo->prepare("
            INSERT INTO trx_bayar 
                (tanggal, idsiswa, kelas, idbayar, bayar, ke, bukti, bulan, tahun)
            VALUES 
                (:tanggal, :idsiswa, :kelas, :idbayar, :bayar, :ke, :bukti, :bulan, :tahun)
        ");
        $stmt->execute([
            ':tanggal' => $tanggal,
            ':idsiswa' => $ids,
            ':kelas'   => $kelas,
            ':idbayar' => $idbayar,
            ':bayar'   => $duit,
            ':ke'      => $ke,
            ':bukti'   => $bukti,
            ':bulan'   => $bulan,
            ':tahun'   => $tahun
        ]);

        echo "OK";
    } else {
        echo "GAGAL";
    }
}
?>
