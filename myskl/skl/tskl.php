<?php
require("../../konek/koneksi.php"); // harus berisi koneksi PDO: $pdo

$std        = $_POST['std'] ?? 0;
$sstp       = $_POST['sstp'] ?? 0;
$dibuka     = $_POST['buka'];
$ditutup    = $_POST['tutup'];
$nama_surat = $_POST['nama'];
$tingkat    = $_POST['level'];
$no_surat   = $_POST['no_surat'];
$tgl_surat  = $_POST['tgl_surat'];
$pembuka    = $_POST['pembuka'];
$isi_surat  = $_POST['isi'];
$penutup    = $_POST['penutup'];
$kuri       = $_POST['kuri'];

$upload_dir = '../../images/';
$ekstensi   = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];

$header = null;
$ttd    = null;
$stp    = null;

if (!empty($_FILES['file']['name'])) {
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext  = pathinfo($file, PATHINFO_EXTENSION);

    if (in_array($ext, $ekstensi)) {
        $newName = 'header_' . time() . '.' . $ext;
        $dest = $upload_dir . $newName;
        if (move_uploaded_file($temp, $dest)) {
            $header = $newName;
        }
    }
}

if (!empty($_FILES['ttd']['name'])) {
    $file = $_FILES['ttd']['name'];
    $temp = $_FILES['ttd']['tmp_name'];
    $ext  = pathinfo($file, PATHINFO_EXTENSION);

    if (in_array($ext, $ekstensi)) {
        $newName = 'ttd_' . time() . '.' . $ext;
        $dest = $upload_dir . $newName;
        if (move_uploaded_file($temp, $dest)) {
            $ttd = $newName;
        }
    }
}

if (!empty($_FILES['stp']['name'])) {
    $file = $_FILES['stp']['name'];
    $temp = $_FILES['stp']['tmp_name'];
    $ext  = pathinfo($file, PATHINFO_EXTENSION);

    if (in_array($ext, $ekstensi)) {
        $newName = 'stempel_' . time() . '.' . $ext;
        $dest = $upload_dir . $newName;
        if (move_uploaded_file($temp, $dest)) {
            $stp = $newName;
        }
    }
}

$sql = "UPDATE skl 
        SET header = COALESCE(:header, header),
            ttd = COALESCE(:ttd, ttd),
            stempel = COALESCE(:stempel, stempel),
            dibuka = :dibuka,
            ditutup = :ditutup,
            nama_surat = :nama_surat,
            tingkat = :tingkat,
            tgl_surat = :tgl_surat,
            pembuka = :pembuka,
            isi_surat = :isi_surat,
            penutup = :penutup,
            no_surat = :no_surat,
            kuri = :kuri,
            sttd = :std,
            sstp = :sstp
        WHERE id_skl = 1";

$stmt = $pdo->prepare($sql);

$success = $stmt->execute([
    ':header'      => $header,
    ':ttd'         => $ttd,
    ':stempel'     => $stp,
    ':dibuka'      => $dibuka,
    ':ditutup'     => $ditutup,
    ':nama_surat'  => $nama_surat,
    ':tingkat'     => $tingkat,
    ':tgl_surat'   => $tgl_surat,
    ':pembuka'     => $pembuka,
    ':isi_surat'   => $isi_surat,
    ':penutup'     => $penutup,
    ':no_surat'    => $no_surat,
    ':kuri'        => $kuri,
    ':std'         => $std,
    ':sstp'        => $sstp
]);

if ($success) {
    echo "Data berhasil diperbarui.";
} else {
    echo "Gagal memperbarui data.";
}
?>
