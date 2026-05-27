<?php
defined('APK') or exit('No Access');
?>
<?php if ($ac == '') : ?>

<div class='row'>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">DATA NILAI KATROL</h5>
            </div>
            <div class="card-body">
                <div id="tablenilai" class='table-responsive'>
                    <table id="datatable1" class='table table-bordered table-analisis edis2'>
                        <thead>
                            <tr>
                                <th width='10%'>#</th>
                                <th>MATA PELAJARAN</th>
                                <th width='15%'>SESI</th>
                                <th width='15%'>TINGKAT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $stmt = $pdo->prepare("
                                SELECT u.*, b.id_bank, b.kode, b.tingkat, m.nama_mapel
                                FROM ujian u
                                LEFT JOIN banksoal b ON b.id_bank = u.idbank
                                LEFT JOIN mapel m ON m.id = b.idmapel
                            ");
                            $stmt->execute();
                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $no++;
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= htmlspecialchars($data['nama_mapel']) ?></td>
                                    <td><h5><span class="badge badge-success"><?= htmlspecialchars($data['sesi']) ?></span></h5></td>
                                    <td>
                                        <h5>
                                            <span class="badge badge-dark"><?= htmlspecialchars($data['tingkat']) ?></span>
                                            <span class="badge badge-dark"><?= htmlspecialchars($data['pk']) ?></span>
                                        </h5>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    $kelas = $_GET['kelas'] ?? '';
    $idbank = $_GET['idb'] ?? '';
    ?>
   <div class="col-md-4">
  <div class="card">
  <div class="card-body">
	<div class="d-flex align-items-center flex-column mb-4">
      <div class="sw-13 position-relative mb-3">
		<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
			<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
			</div>
                    <div class="widget-payment-request-info m-t-md">
                        <label class="bold">MATA PELAJARAN</label>
                        <div class="input-group mb-1">
                            <select class="form-select" id="idbank">
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php
                                $stmtUjian = $pdo->prepare("
                                    SELECT b.id_bank, b.kode 
                                    FROM banksoal b
                                    JOIN nilai n ON n.id_bank = b.id_bank
                                    GROUP BY b.id_bank
                                ");
                                $stmtUjian->execute();
                                while ($uj = $stmtUjian->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($idbank == $uj['id_bank']) ? 'selected' : '';
                                ?>
                                    <option value="<?= htmlspecialchars($uj['id_bank']) ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($uj['kode']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <label class="bold">KELAS</label>
                        <div class="input-group mb-1">
                            <select class="form-select" id="kelas">
                                <option value=''> Pilih Rombel</option>
                                <?php
                                $stmtLevel = $pdo->prepare("SELECT kelas FROM m_kelas");
                                $stmtLevel->execute();
                                while ($kls = $stmtLevel->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($kelas == $kls['kelas']) ? 'selected' : '';
                                ?>
                                    <option value="<?= htmlspecialchars($kls['kelas']) ?>" <?= $selected ?>><?= htmlspecialchars($kls['kelas']) ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="widget-payment-request-actions m-t-md d-flex mb-4">
                            <?php if ($idbank != '') : ?>
                                <a href="nilai/nilaikatrol.php?idb=<?= $idbank ?>&kls=<?= $kelas ?>" target="_blank" class="btn btn-success flex-grow-1 m-l-xxs"> CETAK NILAI</a>
                            <?php endif; ?>
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
	</div>		
</div>

<script type="text/javascript">
    $('#kelas').change(function() {
        var kelas = $('#kelas').val();
        var idb = $('#idbank').val();
        location.replace("?pg=<?= enkripsi('ckatrol') ?>&kelas=" + kelas + "&idb=" + idb);
    });
</script>

<?php endif; ?>
