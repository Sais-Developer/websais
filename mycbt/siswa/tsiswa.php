<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';

if ($pg == 'hapus') {
    $idu = $_POST['id'] ?? '';
    if ($idu != '') {
        $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$idu'");
        $data  = mysqli_fetch_array($query, MYSQLI_ASSOC);

        if (!empty($data['foto']) && is_file("../../images/fotosiswa/" . $data['foto'])) {
            unlink("../../images/fotosiswa/" . $data['foto']);
        }

        $exec = delete($koneksi, 'siswa', ['id_siswa' => $idu]);

        if ($exec) {
            
            $hasil = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY id_siswa");
            $no = 1;
            while ($row = mysqli_fetch_array($hasil, MYSQLI_ASSOC)) {
                $id = $row['id_siswa'];
                mysqli_query($koneksi, "UPDATE siswa SET id_siswa = $no WHERE id_siswa = '$id'");
                $no++;
            }
            mysqli_query($koneksi, "ALTER TABLE siswa AUTO_INCREMENT = $no");
        }
    }
}

if ($pg == 'edit') {
    $ids = $_POST['id'] ?? '';
    if ($ids != '') {
        $data = [
            'nopes'      => $_POST['nopes'] ?? '',
            'username'     => $_POST['username'] ?? '',
            'password'     => $_POST['password'] ?? '',
            'ruang'       => $_POST['ruang'] ?? '',
            'sesi'    => $_POST['sesi'] ?? '',
			'blok'    => $_POST['blok'] ?? '',
            'nama'     => $_POST['nama'] ?? ''
        ];
        update($koneksi, 'siswa', $data, ['id_siswa' => $ids]);
	}
}        


