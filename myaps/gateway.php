<?php 
defined('APK') or exit('No Access');
?>
<div class="row">	
<div class="col-xl-4">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/blast.png" class="responsive-img" alt="thumb" />
                    </div>
                <div class="text-muted">KIRIM PESAN KELAS</div>
                    </div>
					<form id="formkelas">
                 <div class="col-md-12 mb-2">
						<label class="bold">Untuk Siswa Kelas</label>
						   <select class="form-select" name="kelas" required style="width: 100%">
							<option value="">Pilih Kelas</option>
							  <?php
								$stmt = $pdo->query("SELECT kelas FROM m_kelas");
								while ($kelas = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<option value='" . htmlspecialchars($kelas['kelas']) . "'>" . htmlspecialchars($kelas['kelas']) . "</option>";
								}
								?>
							</select>
						</div>
                   <div class="col-md-12 mb-3">
						<label class="bold">Isi Pesan</label>
					<textarea name="pesan" class="form-control" rows="7" required></textarea>
                  </div>
				  <div class="text-end mb-2">
					<button type="submit" class="btn btn-primary kanan">Kirim</button>
				</div>
			</form>
		</div>
   </div>             
</div>					
<script>
$('#formkelas').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		 url: 'masal/masalsis.php',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(function()
			{
			window.location.reload();
			}, 200);
								  
			}
		});
		return false;
	});
</script>							
	<div class="col-xl-4">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/blast.png" class="responsive-img" alt="thumb" />
                    </div>
                <div class="text-muted">KIRIM PESAN SISWA</div>
                    </div>
					<form id="formsiswa">
                 <div class="col-md-12 mb-2">
						<label class="bold">Kelas</label>
						   <select class="form-select" name="kelas" id="kelas" required style="width: 100%">
							<option value="">Pilih Kelas</option>
							 <?php
								$stmt = $pdo->query("SELECT kelas FROM m_kelas");
								while ($kelas = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<option value='" . htmlspecialchars($kelas['kelas']) . "'>" . htmlspecialchars($kelas['kelas']) . "</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-12 mb-2">
						<label class="bold">Untuk Siswa</label>
						   <select class="form-select" name="nowa" id="nowa" required style="width: 100%">
							
							</select>
						</div>
                   <div class="col-md-12 mb-2">
						<label class="bold">Isi Pesan</label>
					<textarea name="pesan" class="form-control" rows="4" required></textarea>
                  </div>
				  <div class="text-end mb-2">
					<button type="submit" class="btn btn-primary kanan">Kirim</button>
				</div>
			</form>
		</div>
    </div>             
</div>		
 <script>			
  $("#kelas").change(function() {
	var kelas = $(this).val();					
	console.log(kelas);
	$.ajax({
		type: "POST",
		url: "masal/ambildata.php?pg=siswa", 
		data: "kelas=" + kelas, 
		success: function(response) { 
			$("#nowa").html(response);
			console.log(response);
		},
		error: function(xhr, status, error) {
			console.log(error);
		}
	});
});
</script>
<script>
$('#formsiswa').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		 url: 'masal/pesan.php',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(function()
			{
			window.location.reload();
			}, 200);
								  
			}
		});
		return false;
	});
</script>							
	<div class="col-xl-4 mb-4">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/blast.png" class="responsive-img" alt="thumb" />
                    </div>
                <div class="text-muted">KIRIM PESAN PEGAWAI</div>
                    </div>
					<form id="formguru">
                 <div class="col-md-12 mb-2">
						<label class="bold">Untuk Pegawai</label>
						   <select class="form-select" name="nowa" required style="width: 100%">
							<option value="">Pilih Pegawai</option>
							  <?php
								$stmt = $pdo->query("SELECT nowa, nama FROM guru WHERE nowa<>''");
								while ($guru = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<option value='" . htmlspecialchars($guru['nowa']) . "'>" . htmlspecialchars($guru['nama']) . "</option>";
								}
								?>
							</select>
						</div>
                   <div class="col-md-12 mb-3">
						<label class="bold">Isi Pesan</label>
					<textarea name="pesan" class="form-control" rows="7" required></textarea>
                  </div>
				  <div class="text-end mb-2">
					<button type="submit" class="btn btn-primary kanan">Kirim</button>
				</div>
			</form>
		</div>
	  </div>             
	</div>	
</div>				
<script>
$('#formguru').submit(function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax(
	{
		type: 'POST',
		 url: 'masal/pegawai.php',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		},
		success: function(data){   		
		setTimeout(function()
			{
			window.location.reload();
			}, 200);
								  
			}
		});
		return false;
	});
</script>							