<?php
ini_set('max_execution_time', 600); 
require "../../konek/koneksi.php";
require "../../konek/function.php";
require "../../konek/crud.php";
   $waktusinkron = date('D, d-m-Y H:i:s');
   $token = $_POST['tokenapi'];

if (!empty($_POST['data'])) {
    foreach ($_POST['data'] as $data) {
        if ($data == 'mapel') {
            $syncdata = http_request($setting['server'] . "/sinkron/sinmaster.php?token=" . $token);
            $sync = json_decode($syncdata, TRUE);
            if ($sync !== null) {
                $pdo->exec("TRUNCATE TABLE mapel");
                $masuk = 0;
                foreach ($sync['mapel'] as $pel) {
                    $stmt = $pdo->prepare("
                        INSERT INTO mapel (id, kode, nama_mapel)
                        VALUES (:id, :kode, :nama_mapel)
                    ");
                    $stmt->execute([
                        ':id' => $pel['id'],
                        ':kode' => $pel['kode'],
                        ':nama_mapel' => $pel['nama_mapel']
                    ]);
                    $masuk++;
                }
                $upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'MAPEL'");
                $upd->execute([$masuk, $waktusinkron]);
            }
        }

        if ($data == 'siswa') {
			$syncdata = http_request($setting['server'] . "/sinkron/sinmaster.php?token=" . $token);
			$sync = json_decode($syncdata, TRUE);

			if ($sync !== null) {
				$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
				$pdo->exec("TRUNCATE TABLE siswa");
				$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

				$masuk2 = 0;
				foreach ($sync['siswa'] as $sis) {
					$stmt = $pdo->prepare("
						INSERT INTO siswa (id_siswa, nis, nisn, nama, level, fase, kelas, jurusan, jk, agama, nowa, foto, username, password, sts, nopes, ruang, sesi)
						VALUES (:id_siswa, :nis, :nisn, :nama, :level, :fase, :kelas, :jurusan, :jk, :agama, :nowa, :foto, :username, :password, :sts, :nopes, :ruang, :sesi)
					");

					$stmt->execute([
						':id_siswa' => $sis['id_siswa'],
						':nis' => $sis['nis'],
						':nisn' => $sis['nisn'],
						':nama' => $sis['nama'],
						':level' => $sis['level'],
						':fase' => $sis['fase'],
						':kelas' => $sis['kelas'],
						':jurusan' => $sis['jurusan'],
						':jk' => $sis['jk'],
						':agama' => $sis['agama'],
						':nowa' => $sis['nowa'],
						':foto' => $sis['foto'],
						':username' => $sis['username'],
						':password' => $sis['password'],
						':sts' => $sis['sts'],
						':nopes' => $sis['nopes'],
						':ruang' => $sis['ruang'],
						':sesi' => $sis['sesi']
					]);

					$masuk2++;
				}

				$upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'SISWA'");
				$upd->execute([$masuk2, $waktusinkron]);
			}
		}
         
		 if ($data == 'fotosiswa') {
				   $zipInfoURL = http_request($setting['server'] . "/sinkron/fotosiswa.php?token=" . $token);
				   $response = http_request($zipInfoURL);
					$data = json_decode($response, true);
                    $remote_file_url = $setting['server'].'/images/fotosiswa.zip';
					$local_file = '../../images/fotosiswa/fotosiswa.zip';
					if (!is_dir('../../images/fotosiswa')) mkdir('../../images/fotosiswa', 0777, true);
					if (copy($remote_file_url, $local_file)) {
						$zip = new ZipArchive;
						if ($zip->open($local_file) === TRUE) {
							$zip->extractTo('../../images/fotosiswa');
							$zip->close();
							unlink($local_file);
						} else {
							error_log("Gagal membuka ZIP: $local_file");
						}
					} else {
						error_log("Gagal menyalin file dari server: $remote_file_url");
					}
			  }
		 
		if ($data == 'guru') {
            $syncdata = http_request($setting['server'] . "/sinkron/sinmaster.php?token=" . $token);
            $sync = json_decode($syncdata, TRUE);
            if ($sync !== null) {
                $pdo->exec("TRUNCATE TABLE guru");
                $masuk3 = 0;
                foreach ($sync['guru'] as $g) {
                    $stmt = $pdo->prepare("
                        INSERT INTO guru (id_guru, nokartu, nip, nama, username, password, jabatan, level, walas, sts, nowa, foto)
                        VALUES (:id_guru, :nokartu, :nip, :nama, :username,  :password, :jabatan, :level, :walas, :sts, :nowa, :foto)
                    ");
                    $stmt->execute([
                        ':id_guru' => $g['id_guru'],
                        ':nokartu' => $g['nokartu'],
                        ':nip' => $g['nip'],
						':nama' => $g['nama'],
						':username' => $g['username'],
						':password' => $g['password'],
						':jabatan' => $g['jabatan'],
						':level' => $g['level'],
						':walas' => $g['walas'],
						':sts' => $g['sts'],
						':nowa' => $g['nowa'],
						':foto' => $g['foto']
                    ]);
                    $masuk3++;
                }
                $upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'PEGAWAI'");
                $upd->execute([$masuk3, $waktusinkron]);
            }
        }
		
		if ($data == 'fotoguru') {
				   $zipInfoURL = http_request($setting['server'] . "/sinkron/fotoguru.php?token=" . $token);
				   $response = http_request($zipInfoURL);
					$data = json_decode($response, true);
                    $remote_file_url = $setting['server'].'/images/fotoguru.zip';
					$local_file = '../../images/fotoguru/fotoguru.zip';
					if (!is_dir('../../images/fotoguru')) mkdir('../../images/fotoguru', 0777, true);
					if (copy($remote_file_url, $local_file)) {
						$zip = new ZipArchive;
						if ($zip->open($local_file) === TRUE) {
							$zip->extractTo('../../images/fotoguru');
							$zip->close();
							unlink($local_file);
						} else {
							error_log("Gagal membuka ZIP: $local_file");
						}
					} else {
						error_log("Gagal menyalin file dari server: $remote_file_url");
					}
			  }
		
		
		    if ($data == 'kelas') {
				$syncdata = http_request($setting['server'] . "/sinkron/sinmaster.php?token=" . $token);
				$sync = json_decode($syncdata, TRUE);
            if ($sync !== null) {
                $pdo->exec("TRUNCATE TABLE m_kelas");
                $masuk4 = 0;
                foreach ($sync['kelas'] as $k) {
                    $stmt = $pdo->prepare("
                        INSERT INTO m_kelas (level, kelas, jurusan, fase, bk, pk, kk)
                        VALUES (:level, :kelas, :jurusan, :fase, :bk, :pk, :kk)
                    ");
                    $stmt->execute([
                        ':level' => $k['level'],
                        ':kelas' => $k['kelas'],
						':jurusan' => $k['jurusan'],
						':fase' => $k['fase'],
						':bk' => $k['bk'],
						':pk' => $k['pk'],
						':kk' => $k['kk']
                    ]);
                    $masuk4++;
                }
                $upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'KELAS'");
                $upd->execute([$masuk4, $waktusinkron]);
            }
        }
		
		
		
        }

    }
?>
