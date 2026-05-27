<div class='row'>
    <div id="boxtampil" class='col-md-12'>
        <div id='formjadwalujian'>
		<div class='row'>
            <?php
            $no = 0;
            $adaUjian = false;

            $stmt = $pdo->prepare("
                SELECT u.*, b.*, m.* 
                FROM ujian u
                LEFT JOIN banksoal b ON b.id_bank = u.idbank
                LEFT JOIN mapel m ON m.id = b.idmapel
                WHERE u.tingkat = :tingkat
                  AND u.sesi = :sesi
                  AND u.status = '1'
                ORDER BY u.tgl_ujian
            ");
            $stmt->execute([
                ':tingkat' => $tingkat,
                ':sesi' => $sesi
            ]);

            $ujianList = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($ujianList as $jadwal) {
                $tglMulai = strtotime($jadwal['tgl_ujian']);
                $tglSelesai = strtotime($jadwal['tgl_selesai']);
                $tglSekarang = time();

                if (date('Y-m-d', $tglSelesai) >= date('Y-m-d') && date('Y-m-d', $tglMulai) <= date('Y-m-d')) {

                    $datalevel = $jadwal['tingkat'];
                    $datajurusan = $jadwal['jurusan'];

                    if ($tingkat === $datalevel && ($datajurusan === $siswa['jurusan'] || $datajurusan === 'semua')) {
                        $adaUjian = true;
                        $no++;
                        $stmtNilai = $pdo->prepare("SELECT * FROM nilai WHERE id_bank = :id_bank AND id_siswa = :id_siswa LIMIT 1");
                        $stmtNilai->execute([
                            ':id_bank' => $jadwal['idbank'],
                            ':id_siswa' => $id_siswa
                        ]);
                        $nilai = $stmtNilai->fetch(PDO::FETCH_ASSOC);
                        $ceknilai = $stmtNilai->rowCount();
                        if ($ceknilai == 0) {
                            if ($tglMulai <= $tglSekarang && $tglSekarang <= $tglSelesai) {
                                $status = '<label class="label label-success">Tersedia </label>';
                                $btntest = "<button data-id='{$jadwal['id_jadwal']}' data-ids='$id_siswa' class='btnmulaitest btn  btn-primary flex-grow-1 m-l-xxs'><i class='fa fa-edit'></i> MULAI</button>";
                            } elseif ($tglMulai > $tglSekarang && $tglSekarang <= $tglSelesai) {
                                $status = '<label class="label label-danger">Belum Waktunya</label>';
                                $btntest = "<button class='btn  btn-danger flex-grow-1 m-l-xxs' disabled> BELUM UJIAN</button>";
                            } else {
                                $status = '<label class="label label-danger">Telat Ujian</label>';
                                $btntest = "<button class='btn  btn-danger flex-grow-1 m-l-xxs' disabled> Telat Ujian</button>";
                            }
                        } else {
                            if (!empty($nilai['ujian_mulai']) && !empty($nilai['ujian_berlangsung']) && empty($nilai['ujian_selesai'])) {
                                if ($nilai['hapus'] == 2 && $nilai['online'] == 0) {
                                    $status = '<label class="label label-warning">Berlangsung</label>';
                                    $btntest = "<button data-id='{$jadwal['idbank']}' data-ids='$id_siswa' class='btn-lanjut btn  btn-dark flex-grow-1 m-l-xxs'><i class='material-icons'>edit</i> PELANGGARAN</button>";
                                } elseif ($nilai['hapus'] == 1 && $nilai['online'] == 1) {
                                    $status = '<label class="label label-warning">Siswa sedang aktif</label>';
                                    $btntest = "<button class='btn btn-danger flex-grow-1 m-l-xxs'><i class='material-icons'>edit</i> Minta Reset</button>";
                                } else {
                                    $status = '<label class="label label-warning">Berlangsung</label>';
                                    $btntest = "<button data-id='{$jadwal['idbank']}' data-ids='$id_siswa' class='btn-lanjut btn  btn-dark flex-grow-1 m-l-xxs'><i class='material-icons'>edit</i> PELANGGARAN</button>";
                                }
                            } elseif (!empty($nilai['ujian_mulai']) && !empty($nilai['ujian_berlangsung']) && !empty($nilai['ujian_selesai'])) {
                                if ($nilai['hapus'] == 1) {
                                    $status = '<label class="label label-danger">Minta Reset</label>';
                                    $btntest = "<button class='btn btn-danger  flex-grow-1 m-l-xxs' disabled> Minta Reset Hubungi Proktor</button>";
                                } elseif ($jadwal['kkm'] == 0) {
                                    $status = '<label class="label label-primary">Selesai</label>';
                                    $btntest = "<button class='btn btn-success  flex-grow-1 m-l-xxs' disabled> Sudah Ujian</button>";
                                } else {
                                    if ($nilai['nilai'] >= $jadwal['kkm']) {
                                        $btntest = "<button class='btn btn-success  flex-grow-1 m-l-xxs'>Kamu Lulus - Skor : ".round($nilai['nilai'])."</button>";
                                    } else {
                                        $btntest = "<button data-id='".$nilai['id_nilai']."' class='btn btn-ulang btn-warning  flex-grow-1 m-l-xxs'>Belum Lulus - Skor : ".round($nilai['nilai'])."</button>";
                                    }
                                }
                            } else {
                                $btntest = "<button class='btn btn-block btn-danger  flex-grow-1 m-l-xxs' disabled> Error</button>";
                            }
                        }
                        ?>
			<?php if (!empty($jadwal['soal_agama'])) : ?>
            <?php if ($jadwal['soal_agama'] == $siswa['agama']) : ?>
			<div class="col-xl-4">
				<div class="card widget widget-payment-request">
					<div class="card-header">
						<h5 class="card-title"><?= $setting['jenis_ujian'] ?></h5>
						</div>
						<div class="card-body">
				   <div class="widget-payment-request-container">
						<div class="widget-payment-request-author">
							<div class="avatar m-r-sm">
								<img src="images/ujian.png" alt="">
							</div>
							<div class="widget-payment-request-author-info">
								<span class="widget-payment-request-author-name"><?= ucwords(strtolower($jadwal['nama_mapel'])) ?></span>
								<span class="widget-payment-request-author-about">Kelas <?= $siswa['kelas'] ?></span>
							</div>
						</div>
						<div class="widget-payment-request-info m-t-md">
							<div style="display: flex; flex-direction: column; gap: 10px;">
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Agama</span>
								<span class="text-muted"><?= $jadwal['soal_agama'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Tingkat</span>
								<span class="text-muted"><?= $siswa['level'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Jurusan</span>
								<span class="text-muted"><?= $jadwal['jurusan'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Kelas</span>
								<span class="text-muted"><?= $siswa['kelas'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Sesi</span>
								<span class="text-muted"><?= $jadwal['sesi'] ?></span>
							</div>							
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Lama Ujian</span>
								<span class="text-muted"><?= $jadwal['lama_ujian'] ?> Menit</span>
							</div>							
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Status</span>
								<span class="text-muted"><?= $status ?> </span>
							</div>
						</div>
						</div>
						<div class="widget-payment-request-actions m-t-lg d-flex">
						<?= $btntest ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	    <?php endif; ?>															  
		<?php else: ?>
				<div class="col-xl-4">
				<div class="card widget widget-payment-request">
					<div class="card-header">
						<h5 class="card-title"><?= $setting['jenis_ujian'] ?></h5>
						</div>
						<div class="card-body">
				   <div class="widget-payment-request-container">
						<div class="widget-payment-request-author">
							<div class="avatar m-r-sm">
								<img src="images/ujian.png" alt="">
							</div>
							<div class="widget-payment-request-author-info">
								<span class="widget-payment-request-author-name"><?= ucwords(strtolower($jadwal['nama_mapel'])) ?></span>
								<span class="widget-payment-request-author-about">Kelas <?= $siswa['kelas'] ?></span>
							</div>
						</div>
						<div class="widget-payment-request-info m-t-md edis2">
							<div style="display: flex; flex-direction: column; gap: 10px;">
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Tingkat</span>
								<span class="text-muted"><?= $siswa['level'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Jurusan</span>
								<span class="text-muted"><?= $jadwal['jurusan'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Kelas</span>
								<span class="text-muted"><?= $siswa['kelas'] ?></span>
							</div>
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Sesi</span>
								<span class="text-muted"><?= $jadwal['sesi'] ?></span>
							</div>							
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Lama Ujian</span>
								<span class="text-muted"><?= $jadwal['lama_ujian'] ?> Menit</span>
							</div>							
							<div style="display: flex; gap: 10px;">
								<span class="widget-payment-request-info-title" style="width: 100px;">Status</span>
								<span class="text-muted"><?= $status ?> </span>
							</div>
						</div>
						</div>
						<div class="widget-payment-request-actions m-t-lg d-flex">
						<?= $btntest ?>
						</div>
					</div>
				</div>
			</div>
		</div>		
						
		 <?php endif; ?>				
	   <?php
                    } 
                } 
            } 
            ?>

            <?php if (!$adaUjian) : ?>
                <div class="alert alert-warning">
                    <strong>Belum ada ujian</strong> untuk tingkat <b><?= $tingkat ?></b> saat ini.
                </div>
            <?php endif; ?>
        </div>
    </div>
   </div>
   </div> 


<script>
$(document).on('click', '.btnmulaitest', function() {
    var idm = $(this).data('id');
    var ids = $(this).data('ids');

    $.ajax({
        type: 'POST',
        url: '<?= $baseurl ?>/konfirmasi.php',
        data: { idm: idm, ids: ids },
        success: function(response) {
            $('#formjadwalujian').hide();
            $('#boxtampil').html(response).slideDown();
        }
    });
});
$(document).on('click', '.btn-lanjut', function() {
    var idb = $(this).data('id');   // id ujian
    var ids = $(this).data('ids');  // id siswa

    Swal.fire({
        title: 'Lanjut Ujian ?',
        html: 'Anda telah keluar dari Aplikasi. Jawaban akan dihapus semua oleh sistem!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: 'POST',
                url: 'status.php?pg=ulangujian',
                data: {
                    idb: idb,
                    ids: ids
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Berhasil!', 'Jawaban dan Nilai berhasil dihapus.', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
                }
            });

        }
    });
});

</script>
