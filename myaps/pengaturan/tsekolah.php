<?php
require("../../konek/koneksi.php");

$data = [
    'sekolah'  => $_POST['sekolah'] ?? '',
    'jenjang'  => $_POST['jenjang'] ?? '',
    'npsn'     => $_POST['npsn']    ?? '',
    'kepsek'   => $_POST['kepsek']  ?? '',
    'nip'      => $_POST['nip']     ?? '',
    'nowa'     => $_POST['nowa']    ?? '',
    'alamat'   => $_POST['alamat']  ?? '',
    'desa'     => $_POST['desa']    ?? '',
    'kecamatan'=> $_POST['kec']     ?? '',
    'kabupaten'=> $_POST['kab']     ?? '',
    'propinsi' => $_POST['prop']    ?? '',
    'email'    => $_POST['email']   ?? '',
    'waktu'    => $_POST['waktu']   ?? '',
    'semester' => $_POST['semester'] ?? '',
    'tp'       => $_POST['tp']      ?? '',
    'wa_token'   => $_POST['wa_token']  ?? '',
    'url_api'  => $_POST['apiwa']   ?? '',
    'header'   => $_POST['laporan'] ?? ''
];
$query = "UPDATE pengaturan SET
    sekolah=:sekolah,
    jenjang=:jenjang,
    npsn=:npsn,
    kepsek=:kepsek,
    nip=:nip,
    nowa=:nowa,
    alamat=:alamat,
    desa=:desa,
    kecamatan=:kecamatan,
    kabupaten=:kabupaten,
    propinsi=:propinsi,
    email=:email,
    waktu=:waktu,
    semester=:semester,
    tp=:tp,
    wa_token=:wa_token,
    url_api=:url_api,
    header=:header
    WHERE id_aplikasi=1";

$exec = $pdo->prepare($query)->execute($data);

if ($exec && !empty($_FILES['logo']['name'])) {

    $allowed = ['jpg','jpeg','png','svg'];
    $logo = $_FILES['logo']['name'];
    $temp = $_FILES['logo']['tmp_name'];
    $ext  = strtolower(pathinfo($logo, PATHINFO_EXTENSION));
    $folder = '../../images/';

    if (in_array($ext, $allowed)) {
        $stmtOld = $pdo->query("SELECT logo FROM pengaturan WHERE id_aplikasi=1");
        $old = $stmtOld->fetchColumn();
        if ($old && file_exists($folder.$old)) {
            unlink($folder.$old);
        }
        $dest = 'logo'.rand(0,1000).".".$ext;

        if (move_uploaded_file($temp, $folder.$dest)) {

            $stmtLogo = $pdo->prepare("UPDATE pengaturan SET logo=:logo WHERE id_aplikasi=1");
            $stmtLogo->execute(['logo' => $dest]);

            echo "Upload berhasil!";
        } else {
            echo "Upload gagal!";
        }
    } else {
        echo "Format file tidak didukung!";
    }

} else {
    echo "Data berhasil disimpan tanpa logo.";
}

?>
