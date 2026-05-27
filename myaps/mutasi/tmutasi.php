<?php
require("../../konek/koneksi.php");

(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';

if ($pg == 'tamat') {
    $tahun = date('Y');
    $tanggal = date('Y-m-d');
    $ids = $_POST['idsiswa'];
    $ket = $_POST['alasan'];

    $count = count($ids);

    for ($i = 0; $i < $count; $i++) {
        $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :id");
        $stmt->execute(['id' => $ids[$i]]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $nama = $user['nama'];

            $insert = $pdo->prepare("
                INSERT INTO alumni (nis, nisn, nama, kelas, jurusan, jk, agama, t_lahir, tgl_lahir, alamat, nowa, tgl_mutasi, tahun_lulus, ket)
                VALUES (:nis, :nisn, :nama, :kelas, :jurusan, :jk, :agama, :t_lahir, :tgl_lahir,:alamat, :nowa, :tgl_mutasi, :tahun_lulus, :ket)
            ");
            $insert->execute([
                'nis' => $user['nis'],
                'nisn' => $user['nisn'],
                'nama' => $nama,
                'kelas' => $user['kelas'],
				'jurusan' => $user['jurusan'],
                'jk' => $user['jk'],
				'agama' => $user['agama'],
				't_lahir' => $user['t_lahir'],
				'tgl_lahir' => $user['tgl_lahir'],
				'alamat' =>$user['alamat'],
				'nowa' =>$user['nowa'],
                'tgl_mutasi' => $tanggal,
                'tahun_lulus' => $tahun,
                'ket' => $ket
            ]);

            if ($insert->rowCount() > 0) {
                $deleteSiswa = $pdo->prepare("DELETE FROM siswa WHERE id_siswa = :id");
                $deleteSiswa->execute(['id' => $ids[$i]]);

                $deleteReg = $pdo->prepare("DELETE FROM datareg WHERE idsiswa = :id");
                $deleteReg->execute(['id' => $ids[$i]]);
            }
        }
    }
}

if ($pg == 'naik') {
    $ids = $_POST['idsiswa'];
    $kelas = $_POST['kelas'];
    $count = count($ids);

    $update = $pdo->prepare("UPDATE siswa SET kelas = :kelas WHERE id_siswa = :id");

    for ($i = 0; $i < $count; $i++) {
        $update->execute([
            'kelas' => $kelas,
            'id' => $ids[$i]
        ]);
    }
}
?>
