<?php
require("../../konek/koneksi.php");  // Asumsi: $pdo adalah objek PDO

// set error mode supaya exception muncul bila ada error
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = [
    'sekolah'   => $_POST['sekolah']   ?? '',
    'jenjang'   => $_POST['jenjang']   ?? '',
    'npsn'      => $_POST['npsn']      ?? '',
    'kepsek'    => $_POST['kepsek']    ?? '',
    'nip'       => $_POST['nip']       ?? '',
    'nowa'      => $_POST['nowa']      ?? '',
    'alamat'    => $_POST['alamat']    ?? '',
    'desa'      => $_POST['desa']      ?? '',
    'kecamatan' => $_POST['kec']       ?? '',
    'kabupaten' => $_POST['kab']       ?? '',
    'propinsi'  => $_POST['prop']      ?? '',
    'email'     => $_POST['email']     ?? '',
    'waktu'     => $_POST['waktu']     ?? '',
    'semester'  => $_POST['semester']  ?? '',
    'tp'        => $_POST['tp']        ?? '',
    'server'    => $_POST['server']    ?? '',
    'url_api'   => $_POST['apiwa']     ?? '',
    'header'    => $_POST['laporan']   ?? ''
];

try {
    $sql = "
      UPDATE pengaturan SET
        sekolah   = :sekolah,
        jenjang   = :jenjang,
        npsn      = :npsn,
        kepsek    = :kepsek,
        nip       = :nip,
        nowa      = :nowa,
        alamat    = :alamat,
        desa      = :desa,
        kecamatan = :kecamatan,
        kabupaten = :kabupaten,
        propinsi  = :propinsi,
        email     = :email,
        waktu     = :waktu,
        semester  = :semester,
        tp        = :tp,
        server    = :server,
        url_api   = :url_api,
        header    = :header
      WHERE id_aplikasi = 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':sekolah'   => $data['sekolah'],
        ':jenjang'   => $data['jenjang'],
        ':npsn'      => $data['npsn'],
        ':kepsek'    => $data['kepsek'],
        ':nip'       => $data['nip'],
        ':nowa'      => $data['nowa'],
        ':alamat'    => $data['alamat'],
        ':desa'      => $data['desa'],
        ':kecamatan' => $data['kecamatan'],
        ':kabupaten' => $data['kabupaten'],
        ':propinsi'  => $data['propinsi'],
        ':email'     => $data['email'],
        ':waktu'     => $data['waktu'],
        ':semester'  => $data['semester'],
        ':tp'        => $data['tp'],
        ':server'    => $data['server'],
        ':url_api'   => $data['url_api'],
        ':header'    => $data['header']
    ]);

    // jika ada upload file logo (opsional)
    if (!empty($_FILES['logo']['name'])) {
        $allowed_ext = ['jpg','jpeg','png','svg'];
        $logo_name = $_FILES['logo']['name'];
        $tmp_name  = $_FILES['logo']['tmp_name'];
        $ext = strtolower(pathinfo($logo_name, PATHINFO_EXTENSION));
        $folder = '../../images/';

        if (in_array($ext, $allowed_ext)) {
            // ambil nama file lama
            $stmt2 = $pdo->prepare("SELECT logo FROM pengaturan WHERE id_aplikasi = 1");
            $stmt2->execute();
            $old = $stmt2->fetchColumn();
            $stmt2 = null;

            if ($old && file_exists($folder . $old)) {
                unlink($folder . $old);
            }

            $new_logo = 'logo'.time().'.'.$ext;
            if (move_uploaded_file($tmp_name, $folder . $new_logo)) {
                $stmt3 = $pdo->prepare("UPDATE pengaturan SET logo = :logo WHERE id_aplikasi = 1");
                $stmt3->execute([':logo' => $new_logo]);
                echo "Data & logo berhasil diperbarui.";
            } else {
                echo "Data tersimpan, tapi upload logo gagal.";
            }
        } else {
            echo "Data tersimpan, tapi format logo tidak didukung.";
        }
    } else {
        echo "Data berhasil disimpan.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
