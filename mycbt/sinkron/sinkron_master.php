<?php
ini_set('max_execution_time', 600); 
require "../../konek/koneksi.php";
require "../../konek/function.php";
require "../../konek/crud.php";
   $waktusinkron = date('D, d-m-Y H:i:s');
   $token = $_POST['tokenapi'];

if (!empty($_POST['data'])) {
    foreach ($_POST['data'] as $data) {
        if ($data == 'bank') {
            $syncdata = http_request($setting['server'] . "/sinkron/sincbt.php?token=" . $token);
            $sync = json_decode($syncdata, TRUE);
            if ($sync !== null) {
                $pdo->exec("TRUNCATE TABLE banksoal");
                $masuk = 0;
                foreach ($sync['bank'] as $b) {
                    $stmt = $pdo->prepare("
                        INSERT INTO banksoal (id_bank, kode, idmapel, tingkat, jurusan, model, soal_agama, idguru, status)
                        VALUES (:id_bank, :kode, :idmapel, :tingkat, :jurusan, :model, :soal_agama, :idguru, :status)
                    ");
                    $stmt->execute([
                        ':id_bank' => $b['id_bank'],
                        ':kode' => $b['kode'],
                        ':idmapel' => $b['idmapel'],
						':tingkat' => $b['tingkat'],
						':jurusan' => $b['jurusan'],
						':model' => $b['model'],
						':soal_agama' => $b['soal_agama'],
						':idguru' => $b['idguru'],
						':status' => $b['status']
                    ]);
                    $masuk++;
                }
                $upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'BANK'");
                $upd->execute([$masuk, $waktusinkron]);
            }
        }

        if ($data == 'soal') {
			$syncdata = http_request($setting['server'] . "/sinkron/sincbt.php?token=" . $token);
			$sync = json_decode($syncdata, TRUE);

			if ($sync !== null) {
				$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
				$pdo->exec("TRUNCATE TABLE soal");
				$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
				$masuk2 = 0;
				foreach ($sync['soal'] as $sis) {
					$stmt = $pdo->prepare("
						INSERT INTO soal (id_soal, id_bank, nomor, soal, jenis, pilA, pilB, pilC, pilD, pilE, perA, perB, perC, perD, perE, jawaban, fileSoal, fileA, fileB, fileC, fileD, fileE, warna, max_skor)
						VALUES (:id_soal, :id_bank, :nomor, :soal, :jenis, :pilA, :pilB, :pilC, :pilD, :pilE, :perA, :perB, :perC, :perD, :perE, :jawaban, :fileSoal, :fileA, :fileB, :fileC, :fileD, :fileE, :warna, :max_skor)
					");

					$stmt->execute([
						':id_soal' => $sis['id_soal'],
						':id_bank' => $sis['id_bank'],
						':nomor' => $sis['nomor'],
						':soal' => $sis['soal'],
						':jenis' => $sis['jenis'],
						':pilA' => $sis['pilA'],
						':pilB' => $sis['pilB'],
						':pilC' => $sis['pilC'],
						':pilD' => $sis['pilD'],
						':pilE' => $sis['pilE'],
						':perA' => $sis['perA'],
						':perB' => $sis['perB'],
						':perC' => $sis['perC'],
						':perD' => $sis['perD'],
						':perE' => $sis['perE'],
						':jawaban' => $sis['jawaban'],
						':fileSoal' => $sis['fileSoal'],
						':fileA' => $sis['fileA'],
						':fileB' => $sis['fileB'],
						':fileC' => $sis['fileC'],
						':fileD' => $sis['fileD'],
						':fileE' => $sis['fileE'],
						':warna' => $sis['warna'],
						':max_skor' => $sis['max_skor']
					]);

					$masuk2++;
				}

				$upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'SOAL'");
				$upd->execute([$masuk2, $waktusinkron]);
			}
		}
         
		 if ($data == 'filesoal') {
				   $zipInfoURL = http_request($setting['server'] . "/sinkron/filesoal.php?token=" . $token);
				   $response = http_request($zipInfoURL);
					$data = json_decode($response, true);
                    $remote_file_url = $setting['server'].'/files.zip';
					$local_file = '../../files/files.zip';
					if (!is_dir('../../files')) mkdir('../../files', 0777, true);
					if (copy($remote_file_url, $local_file)) {
						$zip = new ZipArchive;
						if ($zip->open($local_file) === TRUE) {
							$zip->extractTo('../../files');
							$zip->close();
							unlink($local_file);
						} else {
							error_log("Gagal membuka ZIP: $local_file");
						}
					} else {
						error_log("Gagal menyalin file dari server: $remote_file_url");
					}
			  }
		 
		if ($data == 'jenis') {
            $syncdata = http_request($setting['server'] . "/sinkron/sincbt.php?token=" . $token);
            $sync = json_decode($syncdata, TRUE);
            if ($sync !== null) {
                
                $masuk3 = 0;
                foreach ($sync['jenis'] as $j) {
                    $stmt = $pdo->prepare("
                        UPDATE pengaturan SET 
                       kode_ujian = :kode_ujian, jenis_ujian = :jenis_ujian, kode_server = :kode_server
                    ");
                    $stmt->execute([
                        ':kode_ujian' => $j['kode_ujian'],
                        ':jenis_ujian' => $j['jenis_ujian'],
                        ':kode_server' => $j['kode_server']
                    ]);
                    $masuk3++;
                }
                $upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'JENIS'");
                $upd->execute([$masuk3, $waktusinkron]);
            }
        }
		
		    if ($data == 'jadwal') {
				$syncdata = http_request($setting['server'] . "/sinkron/sincbt.php?token=" . $token);
				$sync = json_decode($syncdata, TRUE);
            if ($sync !== null) {
                $pdo->exec("TRUNCATE TABLE ujian");
                $masuk4 = 0;
                foreach ($sync['jadwal'] as $k) {
                    $stmt = $pdo->prepare("
                        INSERT INTO ujian (id_jadwal, tingkat, jurusan, idbank, soal_agama, tgl_ujian, tgl_selesai, lama_ujian, sesi, kkm, pelanggaran, status, reset, token)
                        VALUES (:id_jadwal, :tingkat, :jurusan, :idbank, :soal_agama, :tgl_ujian, :tgl_selesai, :lama_ujian, :sesi, :kkm, :pelanggaran, :status, :reset, :token)
                    ");
                    $stmt->execute([
                        ':id_jadwal' => $k['id_jadwal'],
                        ':tingkat' => $k['tingkat'],
						':jurusan' => $k['jurusan'],
						':idbank' => $k['idbank'],
						':soal_agama' => $k['soal_agama'],
						':tgl_ujian' => $k['tgl_ujian'],
						':tgl_selesai' => $k['tgl_selesai'],
						':lama_ujian' => $k['lama_ujian'],
						':sesi' => $k['sesi'],
						':kkm' => $k['kkm'],
						':pelanggaran' => $k['pelanggaran'],
						':status' => $k['status'],
						':reset' => $k['reset'],
						':token' => $k['token']
                    ]);
                    $masuk4++;
                }
                $upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'JADWAL'");
                $upd->execute([$masuk4, $waktusinkron]);
            }
        }
		
		
		
        }

    }
?>
