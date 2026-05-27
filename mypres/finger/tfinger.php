<?php
require("../../konek/koneksi.php");
require("../../konek/crud.php");

(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';

if ($pg == 'pegawai') {
    if ($_POST['id'] <> ''):
        $iduser = $_POST['id'];
        $idjari = $_POST['idjari'];
        $data = [
		    'nokartu' => $_POST['idjari'],
            'idpeg' => $_POST['id'],
            'idjari' => $_POST['idjari'],
            'serial' => $_POST['serial'],
            'nama' => $_POST['nama'],
            'level' => 'pegawai'
        ];
        $exec = insert('datareg', $data);
        echo "OK";

        if ($exec) {
            $stmt = $pdo->prepare("UPDATE guru SET sts = '1' WHERE id_guru = :iduser");
            $stmt->bindParam(':iduser', $iduser, PDO::PARAM_INT);
            $stmt->execute();
        }
    endif;
}

if ($pg == 'hapus') {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("SELECT * FROM datareg 
	WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $reg = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reg) {
        $data = [
            'idjari' => $reg['idjari'],
			'idsiswa' => $reg['idsiswa'],
			'idpeg' => $reg['idpeg'],
            'level' => $reg['level'],
            'nama' => $reg['nama'],
            'serial' => $reg['serial']
        ];

        
        $exec = insert('temp_finger', $data);

        if ($reg['level'] == 'pegawai') {
            $stmt = $pdo->prepare("UPDATE users SET sts = '0' WHERE id_guru = :idpeg");
            $stmt->bindParam(':idgpeg', $reg['idpeg'], PDO::PARAM_STR);
            $stmt->execute();
        } elseif ($reg['level'] == 'siswa') {
            $stmt = $pdo->prepare("UPDATE siswa SET sts = '0' WHERE id_siswa = :idsiswa");
            $stmt->bindParam(':idsiswa', $reg['idsiswa'], PDO::PARAM_STR);
            $stmt->execute();
        }
        delete('datareg', ['id' => $id]);
    }
}

if ($pg == 'siswa') {
    if ($_POST['id'] <> ''):
        $ids = $_POST['id'];
        $idjari = $_POST['idjari'];
        $data = [
		    'nokartu' => $_POST['idjari'],
            'idsiswa' => $_POST['id'],
			'kelas' => $_POST['kelas'],
            'idjari' => $_POST['idjari'],
            'serial' => $_POST['serial'],
            'nama' => $_POST['nama'],
			 'nowa' => $_POST['nowa'],
            'level' => 'siswa'
        ];
        $exec = insert('datareg', $data);
        echo "OK";

        if ($exec) {
            $stmt = $pdo->prepare("UPDATE siswa SET sts = '1' WHERE id_siswa = :ids");
            $stmt->bindParam(':ids', $ids, PDO::PARAM_INT);
            $stmt->execute();
        }
    endif;
}
