<?php
defined('APK') or exit('No Access');
?>      
<?php if ($ac == '') : ?>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">DATA NILAI TUGAS</h5>                
            </div>  
            <div class="card-body">
                <table class="table table-bordered table-analisis edis2" style="width:100%;font-size:12px">
                    <thead>
                        <tr style="vertical-align:middle">
                            <th>No</th>
                            <th>Mapel</th>
                            <th>Tgl dikerjakan</th>
                            <th>Status</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $stmt = $pdo->prepare("
                            SELECT j.*, m.nama_mapel 
                            FROM jawaban_tugas j
                            LEFT JOIN mapel m ON m.id = j.mapel
                            WHERE j.id_siswa = :idsiswa
                            ORDER BY j.id_jawaban DESC
                        ");
                        $stmt->execute([':idsiswa' => $id_siswa]);
                        $jawabanList = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($jawabanList as $nilai) :
                            $no++;
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= htmlspecialchars($nilai['nama_mapel']) ?></td>
                            <td><?= htmlspecialchars($nilai['tgl_dikerjakan']) ?></td>
                            <td><label class="label label-primary">Selesai</label></td>
                            <td><?= number_format($nilai['nilai'], 2, '.', '') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>
 <div class="col-xl-4 mb-4">
	<div class="card">
	<div class="card-body">
		<div class="d-flex align-items-center flex-column mb-4">
			<div class="d-flex align-items-center flex-column">
			 <div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" style="max-width:70px" alt="thumb" />
				</div>
			<div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
				  <div class="text-muted">HIGH SCHOOL</div>
				</div>
			  </div>
			<div class="d-flex justify-content-between mb-2">
				<div class="text-center">
				  <p class="text-small text-muted mb-1">NPSN</p>
				  <p><?= $setting['npsn'] ?></p>
				</div>
				<div class="text-center">
				  <p class="text-small text-muted mb-1">SMT</p>
				  <p><?= $setting['semester'] ?></p>
				</div>
				<div class="text-center">
				  <p class="text-small text-muted mb-1">TP</p>
				  <p><?= $setting['tp'] ?></p>
				</div>                    
			  </div>
			  <div class="mb-4">
				<p class="text-small text-muted mb-2">ALAMAT</p>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
					  <i class="material-icons text-info" style="font-size:18px">home</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['alamat'] ?></div>
				</div>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
						<i class="material-icons text-info" style="font-size:18px">star</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['desa'] ?></div>
				</div>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
					   <i class="material-icons text-info" style="font-size:18px">sync</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
				</div>
			  </div>
			  <div class="mb-4">
				<p class="text-small text-muted mb-2">CONTACT</p>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
						<i class="material-icons text-info" style="font-size:18px">phone</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['nowa'] ?></div>
				</div>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
					   <i class="material-icons text-info" style="font-size:18px">inbox</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['email'] ?></div>
				</div>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
					  <i class="material-icons text-info" style="font-size:18px">language</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['server'] ?></div>
				</div>
			  </div>
			  <div class="mb-4">
				<p class="text-small text-muted mb-2">KEPALA SEKOLAH</p>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
					 <i class="material-icons text-info" style="font-size:18px">person</i>
					</div>
				  </div>
				  <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
				</div>
				<div class="row g-0 mb-2">
				  <div class="col-auto">
					<div class="sw-3 me-1">
					  <i class="material-icons text-info" style="font-size:18px">payment</i>
					</div>
				  </div>
				  <div class="col text-alternate"><?= $setting['nip'] ?></div>
				</div>
			  </div>
			</div>
		  </div>             
		</div>					
	</div>
	<?php endif; ?>		 