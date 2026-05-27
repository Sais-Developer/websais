<?php
require("../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

$dirFoto = "../images/fotosiswa/";
if (!is_dir($dirFoto)) {
    mkdir($dirFoto, 0777, true);
}

if ($pg == 'edit') {

    $ids = $_POST['ids'] ?? '';

    if ($ids != '') {

        $password = $_POST['password'] ?? '';
        $nama     = $_POST['nama'] ?? '';
        $nowa     = $_POST['nowa'] ?? '';
        $tlahir   = $_POST['tlahir'] ?? '';
        $tgl      = $_POST['tgl_lahir'] ?? '';
        $alamat   = $_POST['alamat'] ?? '';
        $desa     = $_POST['desa'] ?? '';
        $kec      = $_POST['kec'] ?? '';
        $kab      = $_POST['kab'] ?? '';
        $ayah     = $_POST['ayah'] ?? '';
        $ibu      = $_POST['ibu'] ?? '';
        $pekayah  = $_POST['pek_ayah'] ?? '';
        $pekibu   = $_POST['pek_ibu'] ?? '';

        $sql = "
            UPDATE siswa SET 
                nama=:nama, 
                password=:password, 
                nowa=:nowa, 
                t_lahir=:tlahir, 
                tgl_lahir=:tgl, 
                alamat=:alamat, 
                desa=:desa, 
                kec=:kec, 
                kab=:kab, 
                ayah=:ayah,
                ibu=:ibu, 
                pek_ayah=:pekayah, 
                pek_ibu=:pekibu
            WHERE id_siswa=:ids
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nama'     => $nama,
            ':password' => $password,
            ':nowa'     => $nowa,
            ':tlahir'   => $tlahir,
            ':tgl'      => $tgl,
            ':alamat'   => $alamat,
            ':desa'     => $desa,
            ':kec'      => $kec,
            ':kab'      => $kab,
            ':ayah'     => $ayah,
            ':ibu'      => $ibu,
            ':pekayah'  => $pekayah,
            ':pekibu'   => $pekibu,
            ':ids'      => $ids
        ]);

        if (!empty($_FILES['foto']['name'])) {

            $ektensi = ['jpg','jpeg','png'];
            $file    = basename($_FILES['foto']['name']);
            $temp    = $_FILES['foto']['tmp_name'];
            $ext     = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (in_array($ext, $ektensi)) {

                $stmt = $pdo->prepare("SELECT foto FROM siswa WHERE id_siswa=?");
                $stmt->execute([$ids]);
                $old = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($old['foto']) && file_exists($dirFoto . $old['foto'])) {
                    unlink($dirFoto . $old['foto']);
                }

                $newname = uniqid("siswa_") . "." . $ext;
                $path    = $dirFoto . $newname;

                if (move_uploaded_file($temp, $path)) {
                    $stmt = $pdo->prepare("UPDATE siswa SET foto=? WHERE id_siswa=?");
                    $stmt->execute([$newname, $ids]);
                }
            }
        }
    }
}
?>
