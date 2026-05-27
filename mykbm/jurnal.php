<?php
defined('APK') or exit('No Access');
?>           
<?php
if ($user['level'] == 'admin') {
    $sql = "SELECT j.*, g.nama, m.kode
            FROM jurnal j
            LEFT JOIN guru g ON g.id_guru = j.guru
            LEFT JOIN mapel m ON m.id = j.mapel
            ORDER BY j.tanggal DESC";
    $stmt = $pdo->query($sql); 
} else {
    $sql = "SELECT j.*, g.nama, m.kode
            FROM jurnal j
            LEFT JOIN guru g ON g.id_guru = j.guru
            LEFT JOIN mapel m ON m.id = j.mapel
            WHERE j.guru = :id_guru
            ORDER BY j.tanggal DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_guru' => $user['id_guru']]);
}

$jurnal = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="row">
	 <div class="col-md-8">
		<div class="card">
			 <div class="card-header">
				<h5 class="card-title">JURNAL GURU BULAN <?= strtoupper(bulan_indo($tanggal)) ?></h5>
			</div>
			<div class="card-body">
			<div class="card-box table-responsive">
		<table id="datatable1" class="table table-bordered table-hover" style="width:100%;font-size:12px">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Mapel</th>
							<th>Materi</th>
							<th>Ketercapaian</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$no = 1;
						foreach($jurnal as $row): 
							$warna = "black";
							if($row['ketercapaian'] == "Tercapai") $warna = "green";
							elseif($row['ketercapaian'] == "Belum Tercapai") $warna = "red";
							elseif($row['ketercapaian'] == "Perlu Pengayaan") $warna = "orange";
							elseif($row['ketercapaian'] == "Perlu Remedial") $warna = "purple";
						?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= $row['tanggal']; ?></td>
							<td><span class="badge badge-primary"><?= htmlspecialchars($row['kelas']); ?></span>
							<span class="badge badge-dark"><?= htmlspecialchars($row['kode']); ?></span><p>
							<span class="badge badge-danger"><?= htmlspecialchars($row['nama']); ?></span></td>
							<td><?= htmlspecialchars($row['materi']); ?></td>
							<td style="color:<?= $warna ?>; font-weight:bold;"><?= $row['ketercapaian']; ?></td>
							<td>
							<a href="?pg=<?= enkripsi('jurnal') ?>&ac=<?= enkripsi('edit') ?>&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary" 
							data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="material-icons">edit</i> </a>
							<button data-id="<?= $row['id'] ?>"  class="hapus btn btn-sm btn-danger" 
							data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="material-icons">delete</i> </button>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			 </div>
		</div>
	</div>
</div>
<script>
$('#datatable1').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'tjurnal.php?pg=hapus',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>		
<?php if ($ac == '') : ?>
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
		          <form id='formjurnal' class="row g-1">	
                    <div class="col-md-12 mb-1">
		               <label class="bold">Tanggal</label>
			            <input type="text" name="tanggal" class="datepicker form-control" value="<?= $tanggal; ?>" required="true" autocomplete="off">
		            </div>
				    <div class="col-md-12 mb-1">
		           <label class="bold">Guru</label>
				    <select name="guru" id="guru" class='form-select' style='width:100%' required="true" >                                         
						<option value="">Pilih Guru</option>
							<?php
							if ($user['level'] == 'admin') {
								$stmt = $pdo->prepare("SELECT * FROM guru");
								$stmt->execute();
							} elseif ($user['level'] == 'guru') {
								$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
								$stmt->execute([$id_user]);
							}

							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
								<option value="<?= $data['id_guru'] ?>"><?= htmlspecialchars($data['nama']) ?></option>
							<?php } ?>                                   
					</select>
			    </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Kelas</label>
						<select name="kelas" id="kelas" class='form-select' style='width:100%' required="true" >                                         													                                           
						</select>
                    </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Mapel</label>
						<select name="mapel" id="mapel" class='form-select' style='width:100%' required="true" >                                         													                                           
							</select>
                    </div>
                <div class="col-md-12 mb-1">
					<label class="bold">Materi</label>
						<textarea name="materi" class='form-control'></textarea>
                    </div>
                 <div class="col-md-12 mb-1">
					<label class="bold">Aktifitas</label>
					  <select name="aktivitas" class='form-select' required>
					  <option value="">Pilih</option>
							<option value="Diskusi Kelompok">Diskusi Kelompok</option>
							<option value="Latihan Soal">Latihan Soal</option>
							<option value="Presentasi Siswa">Presentasi Siswa</option>
							<option value="Demonstrasi">Demonstrasi</option>
							<option value="Tanya Jawab">Tanya Jawab</option>
						</select>	
                    </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Metode</label>
					  <select name="metode" class='form-select' required>
					  <option value="">Pilih</option>
							<option value="Diskusi">Diskusi</option>
							<option value="Demonstrasi">Demonstrasi</option>
							<option value="Proyek">Proyek</option>
							<option value="Ceramah">Ceramah</option>
							<option value="Penemuan">Penemuan</option>
						</select>	
                    </div>
                <div class="col-md-12 mb-1">
					<label class="bold">Media</label>
					  <select name="media" class='form-select' required>
							<option value="Buku">Buku</option>
							<option value="LCD">LCD</option>
							<option value="Papan Tulis">Papan Tulis</option>
							<option value="Alat Peraga">Alat Peraga</option>
							<option value="Lembar Kerja">Lembar Kerja</option>
						</select>	
                    </div>
				<div class="col-md-12 mb-1">
					<label class="bold"> Kendala</label>
					<select name="kendala" class='form-select' required>
					<option value="">Pilih</option>
						<option value="Tidak Ada Kendala" <?= $jurnal['kendala']=='Tidak Ada Kendala'?'selected':'' ?>>Tidak Ada Kendala</option>
						<option value="Siswa Kurang Fokus" <?= $jurnal['kendala']=='Siswa Kurang Fokus'?'selected':'' ?>>Siswa Kurang Fokus</option>
						<option value="Siswa Belum Memahami Materi" <?= $jurnal['kendala']=='Siswa Belum Memahami Materi'?'selected':'' ?>>Siswa Belum Memahami Materi</option>
						<option value="Waktu Kurang" <?= $jurnal['kendala']=='Waktu Kurang'?'selected':'' ?>>Waktu Kurang</option>
						<option value="Media Tidak Tersedia" <?= $jurnal['kendala']=='Media Tidak Tersedia'?'selected':'' ?>>Media Tidak Tersedia</option>
						<option value="Sarana/Prasarana Kurang Mendukung" <?= $jurnal['kendala']=='Sarana/Prasarana Kurang Mendukung'?'selected':'' ?>>Sarana/Prasarana Kurang Mendukung</option>
						<option value="Perbedaan Kemampuan Siswa" <?= $jurnal['kendala']=='Perbedaan Kemampuan Siswa'?'selected':'' ?>>Perbedaan Kemampuan Siswa</option>
						<option value="Gangguan Jaringan" <?= $jurnal['kendala']=='Gangguan Jaringan'?'selected':'' ?>>Gangguan Jaringan</option>
						<option value="Cuaca / Lingkungan Tidak Mendukung" <?= $jurnal['kendala']=='Cuaca / Lingkungan Tidak Mendukung'?'selected':'' ?>>Cuaca / Lingkungan Tidak Mendukung</option>
					</select>
					</div>
                <div class="col-md-12 mb-1">
					<label class="bold"> Rencana Lanjutan</label>
					  <select name="rencana_lanjutan" class='form-select' required>
					  <option value="">Pilih</option>
						<option value="Latihan Pengayaan">Latihan Pengayaan</option>
						<option value="Remedial">Remedial</option>
						<option value="Praktik Lanjutan">Praktik Lanjutan</option>
						<option value="Diskusi Lebih Lanjut">Diskusi Lebih Lanjut</option>
						<option value="Pembelajaran Mandiri">Pembelajaran Mandiri</option>
					</select>
                    </div>
                <div class="col-md-12 mb-1">
					<label class="bold"> Ketercapaian</label>
					  <select name="ketercapaian" class='form-select'>
					  <option value="">Pilih</option>
						<option value="Tercapai">Tercapai</option>
						<option value="Belum Tercapai">Belum Tercapai</option>
						<option value="Perlu Pengayaan">Perlu Pengayaan</option>
						<option value="Perlu Remedial">Perlu Remedial</option>
					</select>
                    </div>
                <div class="col-md-12 mb-1">
					<label class="bold">Catatan</label>
						<textarea name="catatan" class='form-control'></textarea>
                    </div>
                <div class="widget-payment-request-actions m-t-lg d-flex">
			 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
				</div>
			</form>
		 </div>
	   </div>
	</div>
	<script>
		$("#guru").change(function() {
		var guru = $(this).val();						
		console.log(guru);
		$.ajax({
		type: "POST",
			url: "adm/ambildata.php?pg=kelas", 
			data: "guru=" + guru, 
			success: function(response) { 
			$("#kelas").html(response);
			console.log(response);
					}
				});
			});
		</script>
		<script>
		$("#kelas").change(function() {
			var kelas = $(this).val();
			var guru = $("#guru").val();							
			console.log(kelas + guru);
				$.ajax({
				type: "POST",
				url: "adm/ambildata.php?pg=mapel", 
				data: "guru=" + guru + "&kelas=" + kelas, 
				success: function(response) { 
				$("#mapel").html(response);
				console.log(response);
					}
				});
			});
		</script>
<script>
$('#formjurnal').submit(function(e) {
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		 url: 'tjurnal.php?pg=tambah',
		enctype: 'multipart/form-data',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		
		},
		success: function(data) {
		   
			setTimeout(function() {
				window.location.reload();
			}, 200);
		}
	})
	return false;
});
</script>
	<?php elseif ($ac == enkripsi('edit')): ?>
<?php 
$id = $_GET['id'];
$sql = "SELECT * FROM jurnal WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$jurnal = $stmt->fetch();

if (!$jurnal) {
    die("Data jurnal tidak ditemukan!");
}
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
		          <form id='formedit' class="row g-1">	
				  <input type="hidden" name="id" value="<?= $id; ?>" >
                    <div class="col-md-12 mb-1">
		               <label class="bold">Tanggal</label>
			            <input type="text" name="tanggal" class="datepicker form-control" value="<?= $jurnal['tanggal']; ?>" required="true" autocomplete="off">
		            </div>
                <div class="col-md-12 mb-1">
					<label class="bold">Materi</label>
						<textarea name="materi" class='form-control'><?= $jurnal['materi'] ?></textarea>
                    </div>
                 <div class="col-md-12 mb-1">
					<label class="bold">Aktifitas</label>
					  <select name="aktivitas" class='form-select' required>
					   <option value="<?= $jurnal['aktivitas'] ?>"><?= $jurnal['aktivitas'] ?></option>
						<option value="">Pilih</option>
							<option value="Diskusi Kelompok">Diskusi Kelompok</option>
							<option value="Latihan Soal">Latihan Soal</option>
							<option value="Presentasi Siswa">Presentasi Siswa</option>
							<option value="Demonstrasi">Demonstrasi</option>
							<option value="Tanya Jawab">Tanya Jawab</option>
						</select>	
                    </div>
				<div class="col-md-12 mb-1">
					<label class="bold">Metode</label>
					  <select name="metode" class='form-select' required>
					   <option value="<?= $jurnal['metode'] ?>"><?= $jurnal['metode'] ?></option>
						<option value="">Pilih</option>
							<option value="Diskusi">Diskusi</option>
							<option value="Demonstrasi">Demonstrasi</option>
							<option value="Proyek">Proyek</option>
							<option value="Ceramah">Ceramah</option>
							<option value="Penemuan">Penemuan</option>
						</select>	
                    </div>
                <div class="col-md-12 mb-1">
					<label class="bold">Media</label>
					  <select name="media" class='form-select' required>
					         <option value="<?= $jurnal['media'] ?>"><?= $jurnal['media'] ?></option>
						<option value="">Pilih</option>
							<option value="Buku">Buku</option>
							<option value="LCD">LCD</option>
							<option value="Papan Tulis">Papan Tulis</option>
							<option value="Alat Peraga">Alat Peraga</option>
							<option value="Lembar Kerja">Lembar Kerja</option>
						</select>	
                    </div>
					<div class="col-md-12 mb-1">
					<label class="bold"> Kendala</label>
					<select name="kendala" class='form-select' required>
						<option value="Tidak Ada Kendala" <?= $jurnal['kendala']=='Tidak Ada Kendala'?'selected':'' ?>>Tidak Ada Kendala</option>
						<option value="Siswa Kurang Fokus" <?= $jurnal['kendala']=='Siswa Kurang Fokus'?'selected':'' ?>>Siswa Kurang Fokus</option>
						<option value="Siswa Belum Memahami Materi" <?= $jurnal['kendala']=='Siswa Belum Memahami Materi'?'selected':'' ?>>Siswa Belum Memahami Materi</option>
						<option value="Waktu Kurang" <?= $jurnal['kendala']=='Waktu Kurang'?'selected':'' ?>>Waktu Kurang</option>
						<option value="Media Tidak Tersedia" <?= $jurnal['kendala']=='Media Tidak Tersedia'?'selected':'' ?>>Media Tidak Tersedia</option>
						<option value="Sarana/Prasarana Kurang Mendukung" <?= $jurnal['kendala']=='Sarana/Prasarana Kurang Mendukung'?'selected':'' ?>>Sarana/Prasarana Kurang Mendukung</option>
						<option value="Perbedaan Kemampuan Siswa" <?= $jurnal['kendala']=='Perbedaan Kemampuan Siswa'?'selected':'' ?>>Perbedaan Kemampuan Siswa</option>
						<option value="Gangguan Jaringan" <?= $jurnal['kendala']=='Gangguan Jaringan'?'selected':'' ?>>Gangguan Jaringan</option>
						<option value="Cuaca / Lingkungan Tidak Mendukung" <?= $jurnal['kendala']=='Cuaca / Lingkungan Tidak Mendukung'?'selected':'' ?>>Cuaca / Lingkungan Tidak Mendukung</option>
					</select>
					</div>
                <div class="col-md-12 mb-1">
					<label class="bold"> Rencana Lanjutan</label>
					  <select name="rencana_lanjutan" class='form-select' required>
					  <option value="<?= $jurnal['rencana_lanjutan'] ?>"><?= $jurnal['rencana_lanjutan'] ?></option>
						<option value="">Pilih</option>
						<option value="Latihan Pengayaan">Latihan Pengayaan</option>
						<option value="Remedial">Remedial</option>
						<option value="Praktik Lanjutan">Praktik Lanjutan</option>
						<option value="Diskusi Lebih Lanjut">Diskusi Lebih Lanjut</option>
						<option value="Pembelajaran Mandiri">Pembelajaran Mandiri</option>
					</select>
                    </div>
                <div class="col-md-12 mb-1">
					<label class="bold"> Ketercapaian</label>
					  <select name="ketercapaian" class='form-select' required>
					    <option value="<?= $jurnal['ketercapaian'] ?>"><?= $jurnal['ketercapaian'] ?></option>
						<option value="">Pilih</option>
						<option value="Tercapai">Tercapai</option>
						<option value="Belum Tercapai">Belum Tercapai</option>
						<option value="Perlu Pengayaan">Perlu Pengayaan</option>
						<option value="Perlu Remedial">Perlu Remedial</option>
					</select>
                    </div>
                <div class="col-md-12 mb-1">
					<label class="bold">Catatan</label>
						<textarea name="catatan" class='form-control'><?= $jurnal['catatan'] ?></textarea>
                    </div>
                <div class="widget-payment-request-actions m-t-lg d-flex">
			 <button type="submit" class="btn btn-primary flex-grow-1 m-l-xxs">Simpan</button>
				</div>
			</form>
		 </div>
	   </div>
	</div>               	
	<script>
$('#formedit').submit(function(e) {
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		 url: 'tjurnal.php?pg=edit',
		enctype: 'multipart/form-data',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		
		},
		success: function(data) {
		   
			setTimeout(function() {
				window.location.replace("?pg=<?= enkripsi('jurnal') ?>");
			}, 200);
		}
	})
	return false;
});
</script>
	<?php endif ?>
	</div>				  
					  
					  
					  	  
					  
					  
					