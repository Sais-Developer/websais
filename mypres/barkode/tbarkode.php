<?php
require("../../konek/koneksi.php"); 

function formatNumber($number) {
    $number = preg_replace('/[^0-9]/', '', $number); 
    if (substr($number, 0, 1) === "0") {
        return "62" . substr($number, 1);
    } elseif (substr($number, 0, 2) === "62") {
        return $number;
    } else {
        return "62" . $number;
    }
}

function sendWA($number, $message, $url_api, $token) {
    $target = formatNumber($number);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url_api . "/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'target' => $target,
            'message' => $message,
        ],
        CURLOPT_HTTPHEADER => [
            "Authorization: $token"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

$token   = $setting['wa_token'];
$url_api = $setting['url_api'];

$pg = $_GET['pg'] ?? '';

if ($pg === 'tambah') {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        $nokartu = $_POST['nokartu'] ?? '';
        $nama    = $_POST['nama'] ?? '';
        $nowa    = $_POST['nowa'] ?? '';
        
		$pesan = "Terima kasih kepada ". $nama." telah Registrasi Kartu Presensi dengan Chip ".$nokartu."\n\nPesan otomatis dari Server Sekolah, tidak perlu dibalas";
       
	   $stmt = $db->prepare("SELECT COUNT(*) FROM datareg WHERE idpeg = ?");
        $stmt->execute([$id]);
        $cek = $stmt->fetchColumn();

        if ($cek == 0) {
           
            $stmt = $db->prepare("UPDATE guru SET sts = ? WHERE id_guru = ?");
            $stmt->execute(['1', $id]);

            $stmt = $db->prepare("INSERT INTO datareg (idpeg, nokartu, nama, nowa, level) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$id, $nokartu, $nama, $nowa, 'pegawai']);
            $last_id = $db->lastInsertId();

            if (!empty($setting['mesin']) && $setting['mesin'] === '2') {
                $stmt = $db->prepare("UPDATE datareg SET nada = ? WHERE id = ?");
                $stmt->execute([$last_id, $last_id]);
            }

            $db->query("DELETE FROM tmpreg");
			
			sendWA($nowa, $pesan, $url_api, $token);
			
        }
    }
}

if ($pg === 'hapus') {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        
        $stmt = $db->prepare("SELECT * FROM datareg WHERE id = ?");
        $stmt->execute([$id]);
        $reg = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reg) {
            if ($reg['level'] === 'siswa') {
                $stmt = $db->prepare("UPDATE siswa SET sts=? WHERE id_siswa=?");
                $stmt->execute(['0', $reg['idsiswa']]);
                $db->prepare("DELETE FROM absensi WHERE idsiswa=?")->execute([$reg['idsiswa']]);
                $db->prepare("DELETE FROM absensi_les WHERE idsiswa=?")->execute([$reg['idsiswa']]);
            } elseif ($reg['level'] === 'pegawai') {
                $stmt = $db->prepare("UPDATE guru SET sts=? WHERE id_guru=?");
                $stmt->execute(['0', $reg['idpeg']]);
                $db->prepare("DELETE FROM absensi WHERE idpeg=?")->execute([$reg['idpeg']]);
                $db->prepare("DELETE FROM absensi_les WHERE idpeg=?")->execute([$reg['idpeg']]);
            }

            $db->prepare("DELETE FROM datareg WHERE id=?")->execute([$id]);
        }
    }
}

if ($pg === 'siswa') {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        $nokartu = $_POST['nokartu'] ?? '';
        $kelas   = $_POST['kelas'] ?? '';
        $nama    = $_POST['nama'] ?? '';
        $nowa    = $_POST['nowa'] ?? '';
        
		$pesan = "Terima kasih kepada ". $nama." telah Registrasi Kartu Presensi dengan Chip ".$nokartu."\n\nPesan otomatis dari Server Sekolah, tidak perlu dibalas";
		
        $stmt = $db->prepare("SELECT COUNT(*) FROM datareg WHERE nokartu = ?");
        $stmt->execute([$nokartu]);
        $cek = $stmt->fetchColumn();

        if ($cek == 0) {
            
            $stmt = $db->prepare("UPDATE siswa SET sts=? WHERE id_siswa=?");
            $stmt->execute(['1', $id]);
            $stmt = $db->prepare("INSERT INTO datareg (idsiswa, nokartu, kelas, nama, nowa, level) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$id, $nokartu, $kelas, $nama, $nowa, 'siswa']);
            $last_id = $db->lastInsertId();
            if (!empty($setting['mesin']) && $setting['mesin'] === '2') {
                $stmt = $db->prepare("UPDATE datareg SET nada=? WHERE id=?");
                $stmt->execute([$last_id, $last_id]);
            }
            $db->query("DELETE FROM tmpreg");
			sendWA($nowa, $pesan, $url_api, $token);
        }
    }
}
?>
