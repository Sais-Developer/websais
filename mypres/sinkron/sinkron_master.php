<?php
ini_set('max_execution_time', 600); 
require "../../konek/koneksi.php";
require "../../konek/function.php";
require "../../konek/crud.php";
   $waktusinkron = date('D, d-m-Y H:i:s');
   $token = $_POST['tokenapi'];

if (!empty($_POST['data'])) {
    foreach ($_POST['data'] as $data) {
        if ($data == 'reg') {
            $syncdata = http_request($setting['server'] . "/sinkron/sinpres.php?token=" . $token);
            $sync = json_decode($syncdata, TRUE);
            if ($sync !== null) {
                $pdo->exec("TRUNCATE TABLE datareg");
                $masuk = 0;
                foreach ($sync['reg'] as $b) {
                    $stmt = $pdo->prepare("
                        INSERT INTO datareg (id, nokartu, idsiswa, kelas, idpeg, level, nama, nowa, nada, folder, idjari)
                        VALUES (:id, :nokartu, :idsiswa, :kelas, :idpeg, :level, :nama, :nowa, :nada, :folder, :idjari)
                    ");
                    $stmt->execute([
                        ':id' => $b['id'],
                        ':nokartu' => $b['nokartu'],
                        ':idsiswa' => $b['idsiswa'],
						':kelas' => $b['kelas'],
						':idpeg' => $b['idpeg'],
						':level' => $b['level'],
						':nama' => $b['nama'],
						':nowa' => $b['nowa'],
						':nada' => $b['nada'],
						':folder' => $b['folder'],
						':idjari' => $b['idjari']
                    ]);
                    $masuk++;
                }
                $upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'REG'");
                $upd->execute([$masuk, $waktusinkron]);
            }
        }

        if ($data == 'absensi') {
			$syncdata = http_request($setting['server'] . "/sinkron/sinpres.php?token=" . $token);
			$sync = json_decode($syncdata, TRUE);
			if ($sync !== null) {
				$masuk2 = 0;
				foreach ($sync['absensi'] as $sis) {
					$cek = $pdo->prepare("SELECT COUNT(*) FROM absensi WHERE id = :id");
					$cek->execute([':id' => $sis['id']]);
					if ($cek->fetchColumn() == 0) {
						$stmt = $pdo->prepare("
							INSERT INTO absensi (id, nokartu, tanggal, idsiswa, kelas, idpeg, level, masuk, pulang, ket, bulan, tahun, keterangan)
							VALUES (:id, :nokartu, :tanggal, :idsiswa, :kelas, :idpeg, :level, :masuk, :pulang, :ket, :bulan, :tahun, :keterangan)
						");

						$stmt->execute([
							':id' => $sis['id'],
							':nokartu' => $sis['nokartu'],
							':tanggal' => $sis['tanggal'],
							':idsiswa' => $sis['idsiswa'],
							':kelas' => $sis['kelas'],
							':idpeg' => $sis['idpeg'],
							':level' => $sis['level'],
							':masuk' => $sis['masuk'],
							':pulang' => $sis['pulang'],
							':ket' => $sis['ket'],
							':bulan' => $sis['bulan'],
							':tahun' => $sis['tahun'],
							':keterangan' => $sis['keterangan']
						]);

						$masuk2++;
					}
				}

				$upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'KBM'");
				$upd->execute([$masuk2, $waktusinkron]);
			}
		}
         
		if ($data == 'eskul') {
			$syncdata = http_request($setting['server'] . "/sinkron/sinpres.php?token=" . $token);
			$sync = json_decode($syncdata, TRUE);
			if ($sync !== null) {
				$masuk3 = 0;
				foreach ($sync['eskul'] as $les) {
					$cek = $pdo->prepare("SELECT COUNT(*) FROM absensi_les WHERE id = :id");
					$cek->execute([':id' => $les['id']]);
					if ($cek->fetchColumn() == 0) {
						$stmt = $pdo->prepare("
							INSERT INTO absensi_les (id, nokartu, tanggal, idsiswa, kelas, idpeg, level, masuk, pulang, ket, bulan, tahun, keterangan)
							VALUES (:id, :nokartu, :tanggal, :idsiswa, :kelas, :idpeg, :level, :masuk, :pulang, :ket, :bulan, :tahun, :keterangan)
						");

						$stmt->execute([
							':id' => $les['id'],
							':nokartu' => $les['nokartu'],
							':tanggal' => $les['tanggal'],
							':idsiswa' => $les['idsiswa'],
							':kelas' => $les['kelas'],
							':idpeg' => $les['idpeg'],
							':level' => $les['level'],
							':masuk' => $les['masuk'],
							':pulang' => $les['pulang'],
							':ket' => $les['ket'],
							':bulan' => $les['bulan'],
							':tahun' => $les['tahun'],
							':keterangan' => $les['keterangan']
						]);

						$masuk3++;
					}
				}

				$upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'ESKUL'");
				$upd->execute([$masuk3, $waktusinkron]);
			}
		}
		 
		if ($data == 'jjm') {
			$syncdata = http_request($setting['server'] . "/sinkron/sinpres.php?token=" . $token);
			$sync = json_decode($syncdata, TRUE);
			if ($sync !== null) {
				$masuk4 = 0;
				foreach ($sync['jjm'] as $j) {
					$cek = $pdo->prepare("SELECT COUNT(*) FROM absen_jjm WHERE id = :id");
					$cek->execute([':id' => $j['id']]);
					if ($cek->fetchColumn() == 0) {
						$stmt = $pdo->prepare("
							INSERT INTO absen_jjm (id, tanggal, idpeg, masuk, ket, jjm, bulan, tahun, jadwal)
							VALUES (:id, :tanggal, :idpeg, :masuk, :ket, :jjm, :bulan, :tahun, :jadwal)
						");

						$stmt->execute([
							':id' => $j['id'],
							':tanggal' => $j['tanggal'],
							':idpeg' => $j['idpeg'],
							':masuk' => $j['masuk'],
							':ket' => $j['ket'],
							':jjm' => $j['jjm'],
							':bulan' => $j['bulan'],
							':tahun' => $j['tahun'],
							':jadwal' => $j['jadwal']
						]);

						$masuk4++;
					}
				}

				$upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'JJM'");
				$upd->execute([$masuk4, $waktusinkron]);
			}
		}
		
		    if ($data == 'waktu') {
				$syncdata = http_request($setting['server'] . "/sinkron/sinpres.php?token=" . $token);
				$sync = json_decode($syncdata, TRUE);
            if ($sync !== null) {
                $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
				$pdo->exec("TRUNCATE TABLE waktu");
				$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
                $masuk5 = 0;
                foreach ($sync['waktu'] as $w) {
                    $stmt = $pdo->prepare("
                        INSERT INTO waktu (id, hari, masuk, pulang, alpha, masuk_eskul, jam_eskul, pulang_eskul, piket)
                        VALUES (:id, :hari, :masuk, :pulang, :alpha, :masuk_eskul, :jam_eskul, :pulang_eskul, :piket)
                    ");
                    $stmt->execute([
                        ':id' => $w['id'],
						':hari' => $w['hari'],
						':masuk' => $w['masuk'],
						':pulang' => $w['pulang'],
						':alpha' => $w['alpha'],
						':masuk_eskul' => $w['masuk_eskul'],
						':jam_eskul' => $w['jam_eskul'],
						':pulang_eskul' => $w['pulang_eskul'],
						':piket' => $w['piket']       
                    ]);
                    $masuk5++;
                }
                $upd = $pdo->prepare("UPDATE sinkron SET jumlah = ?, tanggal = ? WHERE kode = 'WAKTU'");
                $upd->execute([$masuk5, $waktusinkron]);
            }
        }
		
		
		
        }

    }
?>
