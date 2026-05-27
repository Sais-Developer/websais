<?php
defined('APK') or exit('No Access');

$id_kelas = $_GET['kelas'] ?? '';
$id_bank  = $_GET['id'] ?? '';

$sqlkelas = $id_kelas ? " AND a.kelas = :kelas" : "";

$stmtMapel = $pdo->prepare("SELECT * FROM banksoal WHERE id_bank = :id_bank");
$stmtMapel->execute(['id_bank' => $id_bank]);
$mapel = $stmtMapel->fetch(PDO::FETCH_ASSOC);

$stmtJumlah = $pdo->prepare("SELECT COUNT(*) FROM arsip_jawaban WHERE id_bank = :id_bank");
$stmtJumlah->execute(['id_bank' => $id_bank]);
$jumlah = (int) $stmtJumlah->fetchColumn();

$jumlah_siswa = 0;
if ($id_kelas) {
    $stmtSiswa = $pdo->prepare("SELECT COUNT(*) FROM siswa WHERE kelas = :kelas");
    $stmtSiswa->execute(['kelas' => $id_kelas]);
    $jumlah_siswa = (int) $stmtSiswa->fetchColumn();
}

$stmtSoal = $pdo->prepare("SELECT COUNT(*) FROM soal WHERE id_bank = :id_bank");
$stmtSoal->execute(['id_bank' => $id_bank]);
$jumlah_soal = (int) $stmtSoal->fetchColumn();

function analisis_soal(int $jumlah_siswa, int $benar, int $salah): array
{
    $p = $jumlah_siswa > 0 ? $benar / $jumlah_siswa : 0;

    if ($p < 0.30) {
        $status = "Soal Sukar";
    } elseif ($p <= 0.70) {
        $status = "Soal Sedang";
    } else {
        $status = "Soal Mudah";
    }

    if ($p < 0.25) {
        $dp = "Jelek (perlu revisi)";
    } elseif ($p < 0.50) {
        $dp = "Cukup";
    } elseif ($p < 0.75) {
        $dp = "Baik";
    } else {
        $dp = "Sangat Baik";
    }

    if ($benar > $salah) {
        $kecoh = "Efektif";
    } elseif ($benar < $salah) {
        $kecoh = "Menyesatkan";
    } else {
        $kecoh = "Tidak efektif";
    }

    return [$status, $dp, $kecoh];
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">ANALISIS BUTIR SOAL</h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select kelas">
                           <?php
								$stmt = $pdo->prepare("
									SELECT s.kelas 
									FROM siswa s
									JOIN nilai n ON n.id_siswa = s.id_siswa
									GROUP BY s.kelas
									ORDER BY s.kelas ASC
								");
								$stmt->execute();
								$kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
								?>
									<option value=''>Pilih Kelas</option>
									<?php foreach ($kelasList as $kls): ?>
										<option value="<?= htmlspecialchars($kls['kelas']) ?>" <?= ($id_kelas === $kls['kelas']) ? 'selected' : '' ?>>
											<?= htmlspecialchars($kls['kelas']) ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

                    <div class="col-md-3">
                        <select class="form-select ujian">
                            <option value="">Pilih Mata Pelajaran</option>
                           <?php
							$stmt = $pdo->prepare("
								SELECT b.id_bank, b.kode 
								FROM banksoal b
								JOIN nilai n ON n.id_bank = b.id_bank
								GROUP BY b.id_bank
								ORDER BY b.kode ASC
							");
							$stmt->execute();
							$ujianList = $stmt->fetchAll(PDO::FETCH_ASSOC);
							?>
								<?php foreach ($ujianList as $uj): ?>
									<option value="<?= htmlspecialchars($uj['id_bank']) ?>" <?= ($id_bank == $uj['id_bank']) ? 'selected' : '' ?>>
										<?= htmlspecialchars($uj['kode']) ?>
									</option>
								<?php endforeach; ?>
							</select>
                    </div>
                    <div class="col-md-3">
                        <button id="cari_nilai" class="btn btn-success">
                            <i class="material-icons">search</i> Cari Analisis
                        </button>
                    </div>
                </div>

                <script>
                    document.getElementById('cari_nilai').addEventListener('click', () => {
                        const kelas = document.querySelector('.kelas').value;
                        const ujian = document.querySelector('.ujian').value;
                        location.replace(`?pg=<?= enkripsi('anbuso') ?>&kelas=${kelas}&id=${ujian}`);
                    });
                </script>
                <br>
                <table class="table">
                    <tr>
                        <th>Kelas/Rombel</th><td>:</td><td><?= htmlspecialchars($id_kelas) ?></td><td></td>
                        <th>Jumlah Siswa</th><td></td><td><b><?= $jumlah_siswa ?></b></td>
                    </tr>
                    <tr>
                        <th>Mata Pelajaran</th><td>:</td><td><?= htmlspecialchars($mapel['kode'] ?? '-') ?></td><td></td>
                        <th>Kelompok Soal</th><td></td><td><?= htmlspecialchars($mapel['model'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Soal</th><td>:</td><td><?= $jumlah_soal ?></td><td colspan="4"></td>
                    </tr>
                </table>

                <br>

                <h5>Soal Pilihan Ganda</h5>
                <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                        <tr>
                            <th>No Soal</th><th>Kunci</th>
                            <th>A</th><th>B</th><th>C</th><th>D</th><th>E</th>
                            <th>Benar</th><th>Salah</th><th>Tidak Jawab</th>
                            <th>Daya Pembeda</th><th>Efektivitas Option</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$stmtSoal = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = '1'");
						$stmtSoal->execute(['id_bank' => $id_bank]);
						$soalList = $stmtSoal->fetchAll(PDO::FETCH_ASSOC);
						foreach ($soalList as $s):
						$jawab   = $s['jawaban'];
						$id_soal = $s['id_soal'];
						$idb     = $s['id_bank'];
						$stmtBenar = $pdo->prepare("
							SELECT COUNT(*) FROM arsip_jawaban 
							WHERE jawaban = :jawaban AND jenis='1' AND id_bank = :id_bank AND id_soal = :id_soal
						");
						$stmtBenar->execute([
							'jawaban' => $jawab,
							'id_bank' => $idb,
							'id_soal' => $id_soal
						]);
						$benar = (int) $stmtBenar->fetchColumn();
						$stmtSalah = $pdo->prepare("
							SELECT COUNT(*) FROM arsip_jawaban 
							WHERE jawaban <> :jawaban AND jenis='1' AND id_bank = :id_bank AND id_soal = :id_soal
						");
						$stmtSalah->execute([
							'jawaban' => $jawab,
							'id_bank' => $idb,
							'id_soal' => $id_soal
						]);
						$salah = (int) $stmtSalah->fetchColumn();
						$tidak = $jumlah_siswa - ($benar + $salah);
						[$status, $dp, $kecoh] = analisis_soal($jumlah_siswa, $benar, $salah);
					?>
					<tr>
						<td><?= htmlspecialchars($s['nomor']) ?></td>
						<td><?= htmlspecialchars($jawab) ?></td>
						<?php foreach (['A','B','C','D','E'] as $opt):
							$stmtOpt = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban 
								WHERE jawaban = :opt AND jenis='1' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtOpt->execute([
								'opt'     => $opt,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$countOpt = (int) $stmtOpt->fetchColumn();
						?>
							<td><?= $countOpt ?></td>
						<?php endforeach; ?>
						<td><?= $benar ?></td>
						<td><?= $salah ?></td>
						<td><?= $tidak ?></td>
						<td><?= $dp ?></td>
						<td><?= $kecoh ?></td>
						<td><?= $status ?></td>
					</tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
                <br>

                <h5>Soal PG Komplek (Multi Choice)</h5>
                <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                        <tr>
                            <th>No Soal</th><th>Kunci</th><th>Benar</th><th>Salah</th><th>Tidak Jawab</th>
                            <th>Daya Pembeda</th><th>Efektivitas</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
						$stmtSoal = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = '2'");
						$stmtSoal->execute(['id_bank' => $id_bank]);
						$soalList = $stmtSoal->fetchAll(PDO::FETCH_ASSOC);

						foreach ($soalList as $s):
							$jawab   = $s['jawaban'];
							$id_soal = $s['id_soal'];
							$idb     = $s['id_bank'];
							$stmtBenar = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban
								WHERE jawaban = :jawaban AND jenis = '2' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtBenar->execute([
								'jawaban' => $jawab,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$benar = (int) $stmtBenar->fetchColumn();
							$stmtSalah = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban
								WHERE jawaban <> :jawaban AND jenis = '2' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtSalah->execute([
								'jawaban' => $jawab,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$salah = (int) $stmtSalah->fetchColumn();

							$tidak = $jumlah_siswa - ($benar + $salah);
							[$status, $dp, $kecoh] = analisis_soal($jumlah_siswa, $benar, $salah);
						?>
						<tr>
							<td><?= htmlspecialchars($s['nomor']) ?></td>
							<td><?= htmlspecialchars($jawab) ?></td>
							<td><?= $benar ?></td>
							<td><?= $salah ?></td>
							<td><?= $tidak ?></td>
							<td><?= $dp ?></td>
							<td><?= $kecoh ?></td>
							<td><?= $status ?></td>
						</tr>
						<?php endforeach; ?>
                    </tbody>
                </table>

                <br>

                <h5>Soal PG Komplek (Benar Salah)</h5>
                <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                        <tr>
                            <th>No Soal</th><th>Kunci</th><th>Benar</th><th>Salah</th><th>Tidak Jawab</th>
                            <th>Daya Pembeda</th><th>Efektivitas</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
						$stmtSoal = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = '3'");
						$stmtSoal->execute(['id_bank' => $id_bank]);
						$soalList = $stmtSoal->fetchAll(PDO::FETCH_ASSOC);

						foreach ($soalList as $s):
							$jawab   = $s['jawaban'];
							$id_soal = $s['id_soal'];
							$idb     = $s['id_bank'];
							$stmtBenar = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban
								WHERE jawaban = :jawaban AND jenis = '3' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtBenar->execute([
								'jawaban' => $jawab,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$benar = (int) $stmtBenar->fetchColumn();
							$stmtSalah = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban
								WHERE jawaban <> :jawaban AND jenis = '3' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtSalah->execute([
								'jawaban' => $jawab,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$salah = (int) $stmtSalah->fetchColumn();
							$tidak = $jumlah_siswa - ($benar + $salah);
							[$status, $dp, $kecoh] = analisis_soal($jumlah_siswa, $benar, $salah);
						?>
						<tr>
							<td><?= htmlspecialchars($s['nomor']) ?></td>
							<td><?= htmlspecialchars($jawab) ?></td>
							<td><?= $benar ?></td>
							<td><?= $salah ?></td>
							<td><?= $tidak ?></td>
							<td><?= $dp ?></td>
							<td><?= $kecoh ?></td>
							<td><?= $status ?></td>
						</tr>
						<?php endforeach; ?>
                    </tbody>
                </table>

                <br>

                <h5>Soal Menjodohkan</h5>
                <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                        <tr>
                            <th>No Soal</th><th>Kunci</th><th>Benar</th><th>Salah</th><th>Tidak Jawab</th>
                            <th>Daya Pembeda</th><th>Efektivitas</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$stmtSoal = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = '4'");
						$stmtSoal->execute(['id_bank' => $id_bank]);
						$soalList = $stmtSoal->fetchAll(PDO::FETCH_ASSOC);
						foreach ($soalList as $s):
							$jawab   = $s['jawaban'];
							$id_soal = $s['id_soal'];
							$idb     = $s['id_bank'];
							$stmtBenar = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban
								WHERE jawaban = :jawaban AND jenis = '4' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtBenar->execute([
								'jawaban' => $jawab,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$benar = (int) $stmtBenar->fetchColumn();
							$stmtSalah = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban
								WHERE jawaban <> :jawaban AND jenis = '4' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtSalah->execute([
								'jawaban' => $jawab,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$salah = (int) $stmtSalah->fetchColumn();
							$tidak = $jumlah_siswa - ($benar + $salah);
							[$status, $dp, $kecoh] = analisis_soal($jumlah_siswa, $benar, $salah);
						?>
						<tr>
							<td><?= htmlspecialchars($s['nomor']) ?></td>
							<td><?= htmlspecialchars($jawab) ?></td>
							<td><?= $benar ?></td>
							<td><?= $salah ?></td>
							<td><?= $tidak ?></td>
							<td><?= $dp ?></td>
							<td><?= $kecoh ?></td>
							<td><?= $status ?></td>
						</tr>
						<?php endforeach; ?>
                    </tbody>
                </table>

                <br>

                <h5>Soal Uraian Singkat</h5>
                <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                        <tr>
                            <th>No Soal</th><th>Kunci</th><th>Benar</th><th>Salah</th><th>Tidak Jawab</th>
                            <th>Daya Pembeda</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
						$stmtSoal = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = '5'");
						$stmtSoal->execute(['id_bank' => $id_bank]);
						$soalList = $stmtSoal->fetchAll(PDO::FETCH_ASSOC);
						foreach ($soalList as $s):
							$jawab   = $s['jawaban'];
							$id_soal = $s['id_soal'];
							$idb     = $s['id_bank'];
							$stmtBenar = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban
								WHERE jawaban = :jawaban AND jenis = '5' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtBenar->execute([
								'jawaban' => $jawab,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$benar = (int) $stmtBenar->fetchColumn();
							$stmtSalah = $pdo->prepare("
								SELECT COUNT(*) FROM arsip_jawaban
								WHERE jawaban <> :jawaban AND jenis = '5' AND id_bank = :id_bank AND id_soal = :id_soal
							");
							$stmtSalah->execute([
								'jawaban' => $jawab,
								'id_bank' => $idb,
								'id_soal' => $id_soal
							]);
							$salah = (int) $stmtSalah->fetchColumn();
							$tidak = $jumlah_siswa - ($benar + $salah);
							[$status, $dp] = analisis_soal($jumlah_siswa, $benar, $salah);
						?>
						<tr>
							<td><?= htmlspecialchars($s['nomor']) ?></td>
							<td><?= htmlspecialchars($jawab) ?></td>
							<td><?= $benar ?></td>
							<td><?= $salah ?></td>
							<td><?= $tidak ?></td>
							<td><?= $dp ?></td>
							<td><?= $status ?></td>
						</tr>
						<?php endforeach; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
