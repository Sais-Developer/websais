<?php
require("../konek/koneksi.php");
require("../konek/function.php");
require("../konek/crud.php");

$kartu = $_POST['uid'];

$stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM datareg
    WHERE nokartu = :kartu
");
$stmt->execute(['kartu' => $kartu]);
$jsiswa = $stmt->fetchColumn();

if ($jsiswa == 0) {
    echo "GAGAL";
    
} else {
   
    $stmt = $pdo->prepare("
        SELECT siswa.*, datareg.*
        FROM datareg
        INNER JOIN siswa ON siswa.id_siswa = datareg.idsiswa
        WHERE datareg.nokartu = :kartu
    ");
    $stmt->execute(['kartu' => $kartu]);
    $datax = $stmt->fetch(PDO::FETCH_ASSOC);

    $ids = $datax['id_siswa'];

    $stmt = $pdo->prepare("
        SELECT *
        FROM trx_bayar
        WHERE idsiswa = :ids
        ORDER BY id_trx DESC
        LIMIT 1
    ");
    $stmt->execute(['ids' => $ids]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

   
    if ($data && $ids == $data['idsiswa']) {
       
        $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :id");
        $stmt->execute(['id' => $data['idsiswa']]);
        $sis = $stmt->fetch(PDO::FETCH_ASSOC);

     
        $nama = (strlen($sis['nama']) > 20)
                ? substr($sis['nama'], 0, 20)." .."
                : $sis['nama'];

       
        $bulan = $data['bulan'];
        $tahun = $data['tahun'];

      
        $stmt_bulan = $pdo->prepare("SELECT ket FROM bulan WHERE bln = :bln");
        $stmt_bulan->execute(['bln' => $bulan]);
        $bulane = $stmt_bulan->fetch(PDO::FETCH_ASSOC);

        
        $stmt = $pdo->prepare("SELECT * FROM m_bayar WHERE id = :id");
        $stmt->execute(['id' => $data['idbayar']]);
        $kode = $stmt->fetch(PDO::FETCH_ASSOC);

       
        $stmt = $pdo->prepare("
            SELECT SUM(bayar) AS jumlah
            FROM trx_bayar
            WHERE bulan = :bulan
            AND tahun = :tahun
            AND idsiswa = :ids
            AND idbayar = :idbayar
        ");
        $stmt->execute([
            'bulan' => $data['bulan'],
            'tahun' => $data['tahun'],
            'ids' => $ids,
            'idbayar' => $data['idbayar']
        ]);
        $Total = $stmt->fetch(PDO::FETCH_ASSOC);

       
        $totalMasuk = isset($Total['jumlah']) ? number_format($Total['jumlah']) : "0";

        echo "      SMK SADAM CISURUPAN       \n";
        echo "  Jalan Serang RT. 006 RW. 005  \n";
        echo "================================\n";
        echo "     CEK PEMBAYARAN TERAKHIR   \n\n";
        echo "Bulan  : ".$bulane['ket']." ".$tahun."\n";
        echo "Nama   : ".$nama."\n";
        echo "Untuk  : TRX ".$kode['kode']."\n";
        echo "Tgl Byr: ".date('d-m-Y', strtotime($data['tanggal']))."\n";
        echo "Besar  : RP. ".number_format($data['bayar'])."\n";
        echo "Byr Ke : ".$data['ke']."\n";
        echo "Reff   : ".$data['bukti']."\n";
        echo "================================\n";
        echo "Tot Masuk : RP. ".$totalMasuk."\n";
        echo "================================\n";
        echo "        TERIMA KASIH            ";
        echo " Cetak pada ".date('d-m-Y H:i:s')." ";
    } else {
        echo "GAGAL";
    }
}
?>
