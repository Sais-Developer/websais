<?php
defined('APK') or exit('No Access');
?>
<?php if ($ac == '') : ?>
<div class='row'>
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">BERITA ACARA</h5>
        <a href="?pg=<?= enkripsi('berita') ?>&ac=<?= enkripsi('buatberita') ?>" class="btn btn-primary">
          <i class="material-icons">add</i> BA
        </a>
      </div>
      <div class="card-body">
        <div id='tableberita' class='table-responsive'>
          <table id="datatable1" class='table table-hover table-bordered edis2'>
            <thead>
              <tr>
                <th width='5px'>#</th>
                <th>Mata Pelajaran</th>
                <th>Tingkat</th>
                <th>Sesi</th>
                <th>Ruang</th>
                <th>Hadir</th>
                <th>Tidak Hadir</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
             <?php
				$stmt = $pdo->query("
					SELECT t.*, b.*, m.nama_mapel
					FROM berita t
					LEFT JOIN banksoal b ON b.id_bank = t.id_bank
					LEFT JOIN mapel m ON m.id = b.idmapel
				");

				$no = 0;
				while ($berita = $stmt->fetch(PDO::FETCH_ASSOC)) :
					$no++;
				?>
				<tr>
					<td><?= $no ?></td>
					<td><?= htmlspecialchars($berita['nama_mapel']) ?></td>
					<td style="text-align:center"><?= htmlspecialchars($berita['tingkat']) ?></td>
					<td style="text-align:center"><b><?= htmlspecialchars($berita['sesi']) ?></b></td>
					<td style="text-align:center"><?= htmlspecialchars($berita['ruang']) ?></td>
					<td style="text-align:center"><?= htmlspecialchars($berita['ikut']) ?></td>
					<td style="text-align:center"><?= htmlspecialchars($berita['susulan']) ?></td>
					<td style="text-align:center"><?= htmlspecialchars($berita['mulai']) ?></td>
					<td style="text-align:center"><?= htmlspecialchars($berita['selesai']) ?></td>
					<td style="text-align:center">
						
							<button onclick="frames['frameresult<?= $berita['id_berita'] ?>'].print()" class='btn btn-sm btn-primary'>
								<i class='material-icons'>print</i>
							</button>
							<button data-id='<?= $berita['id_berita'] ?>' class="hapus btn btn-danger btn-sm">
								<i class="material-icons">delete</i>
							</button>
							<iframe name='frameresult<?= $berita['id_berita'] ?>' src='cetak/print_berita.php?id=<?= $berita['id_berita'] ?>' style='display:none'></iframe>
						
					</td>
				</tr>
				<?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    $('#tableberita').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        Swal.fire({
			   
				  title: 'Are you sure?',
				  text: "You won't be able to revert this!",
				  icon: 'warning',
				  width : '320px',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, delete it!'	
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'cetak/tberita.php?pg=hapus',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                    $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
                        setTimeout(function() {
                            window.location.reload();
                        }, 200);
                    }
                });
            }
            return false;
        })

    });
</script>

<?php elseif ($ac == enkripsi('buatberita')) : ?>
<div class="row">
	<div class="col-md-8">
		 <div class="card">
	<div class="card-header">
		<h5 class="card_title">BERITA ACARA</h5>
						</div>
				   <div class="card-body"> 
				   <form id="formberita" enctype="multipart/form-data" method="post" class="row g-1">
						<div class="col-md-4">
							<label class="bold">Nama Ujian</label>
							<select name="id_ujian" id="id_ujian" class='form-select' style="width: 100%" required>
								<option value=''>Pilih Jadwal Ujian</option>
								<?php
								$stmt_mapel = $pdo->query("
									SELECT u.*, b.*, m.*
									FROM ujian u
									LEFT JOIN banksoal b ON b.id_bank = u.idbank
									LEFT JOIN mapel m ON m.id = b.idmapel
								");
								while ($mapel = $stmt_mapel->fetch(PDO::FETCH_ASSOC)) :
								?>
									<option value="<?= htmlspecialchars($mapel['id_jadwal']) ?>">
										<?= htmlspecialchars($mapel['kode'] . " " . $mapel['tingkat']) ?>
									</option>
								<?php endwhile; ?>
							</select>
						</div>

						<div class="col-md-4">
							<label class="bold">Sesi</label>
							<select class="form-select" id="bcsesi" name="sesi" required>
								<option>Sesi</option>
								<?php
								$stmt_sesi = $pdo->query("SELECT DISTINCT sesi FROM siswa ORDER BY sesi ASC");
								while ($ses = $stmt_sesi->fetch(PDO::FETCH_ASSOC)) :
								?>
									<option value="<?= htmlspecialchars($ses['sesi']) ?>"><?= htmlspecialchars($ses['sesi']) ?></option>
								<?php endwhile; ?>
							</select>
						</div>

						<div class="col-md-4">
							<label class="bold">Ruang</label>
							<select class="form-select" id="bcruang" name="ruang" required>
								<option>Ruang</option>
								<?php
								$stmt_ruang = $pdo->query("SELECT DISTINCT ruang FROM siswa ORDER BY ruang ASC");
								while ($ruang = $stmt_ruang->fetch(PDO::FETCH_ASSOC)) :
								?>
									<option value="<?= htmlspecialchars($ruang['ruang']) ?>"><?= htmlspecialchars($ruang['ruang']) ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					<div class="col-md-4">
						<label class="bold">Tanggal Ujian</label>
						 <input name='tgl_ujian' class='datepicker form-control' autocomplete=off />
					</div>
									
					<div class="col-md-2">
						<label class="bold">Mulai</label>
						<input id='waktumulai' type='text' name='mulai' class='timer form-control' autocomplete=off />
					</div>
										
					<div class="col-md-2">
						<label class="bold">Selesai</label>
						<input id='waktumulai' type='text' name='selesai' class='timer form-control' autocomplete=off />
					</div>
										
					<div class='col-md-2'>
						<label class="bold">Hadir</label>
						  <input type='number' name='hadir' class='form-control' required='true' />
					  </div>
					  
					<div class='col-md-2'>
					   <label class="bold">Absen</label>
						 <input type='number' name='tidakhadir' class='form-control' required='true' />
					   </div>
					 
					<div class="col-md-12">
						<label class="bold">Siswa Tidak Hadir</label>
							<select name='nosusulan[]' id="bcsiswaabsen" class='form-control select2' multiple='multiple' style='width:100%'>
						</select>
					</div>
												
					<div class='col-md-6'>
						<label class="bold">Nama Proktor</label>
						   <input type='text' name='nama_proktor' value="<?= $setting['proktor'] ?>" class='form-control' required='true' />
					  </div>
					  
					<div class='col-md-6'>
					   <label class="bold">NIP Proktor</label>
						  <input type='text' name='nip_proktor' value="<?= $setting['nipproktor'] ?>" class='form-control' required='true' />
					</div>
						
					<div class='col-md-6'>
					   <label class="bold">Nama Pengawas</label>
						  <input type='text' name='nama_pengawas' class='form-control' required='true' />
					 </div>
					  
					<div class='col-md-6'>
					   <label class="bold">NIP Pengawas</label>
						  <input type='text' name='nip_pengawas' class='form-control' required='true' />
					 </div>
					  
					<div class='col-md-12'>
					   <label class="bold">Catatan</label>
						  <textarea type='text' name='catatan' class='form-control' required='true'></textarea>
					</div>
					
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
   </div>
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
					   
	<script>
$('#formberita').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'cetak/tberita.php?pg=tambah',
        data: $(this).serialize(),
        beforeSend: function() {
            $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
        },
        success: function(data) {
            if (data == 'OK') {
                setTimeout(function() {
                    window.location.replace("?pg=<?= enkripsi('berita') ?>");
                }, 200);
            } else {
                Swal.fire({
                    icon: 'error',
					width : '320px',
                    title: 'GAGAL!',
                    text: 'Data Gagal disimpan',
                    background: 'rgba(0, 0, 0, 0.5)',
                    color: '#fff',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    position: 'top-end'
                });

                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        }
    });
    return false;
});
</script>
<script>
$("#bcruang").change(function() {
	var sesi = $('#bcsesi').val();
	var ruang = $(this).val();
	var iduji = $('#id_ujian').val();
	console.log(ruang + sesi + iduji);
	$.ajax({
		type: "POST", 
		url: 'cetak/tberita.php?pg=list_siswa',
		data: "ruang=" + ruang + '&sesi=' + sesi + '&iduji=' + iduji, 
		success: function(response) { 
			$("#bcsiswaabsen").html(response);
			console.log(response);
		},
		error: function(xhr, status, error) {
			console.log(error);
		}
	});
});
</script>
<?php endif; ?>