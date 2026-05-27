<style>
section { width:100%; margin:5px auto; }
video, canvas { border:1px solid #ddd; border-radius:5px; }
img.responsive { max-width: 40%; height: auto; border-radius: 6px; display: block; margin: 10px auto; }
@media (max-width: 768px) {
  img.responsive { width: 70%; max-height: 300px; object-fit: cover; }
}
@media (max-width: 480px) {
  img.responsive { max-height: 220px; border-radius: 4px; }
}
.text-muted { color: #6c757d !important; }
.card-body { text-align: center; }
</style>
<?php
$stmt = $pdo->prepare("SELECT * FROM pkl_siswa WHERE idsiswa = :id_siswa LIMIT 1");
$stmt->execute([':id_siswa' => $id_siswa]);
$mpl = $stmt->fetch(PDO::FETCH_ASSOC);
$dudi = $mpl['dudi'] ?? null; 
?>

<section style="display:none;">
<label for="nama">Nama Siswa:</label>
<select id="nama">
  <option value="<?= $siswa['id_siswa'] ?>"><?= $siswa['nama'] ?></option>
</select>
</section>

<section id="kamera-section">
<div class="row">
    <div class="col-md-3"></div>
      <div class="col-md-6">
       <div class="card">	   
		 <div class="card-body text-center">
		 <div class="d-flex align-items-center flex-column mb-4">
            <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" >
                  </div>
			<div class="h5" style="color:blue;">PRESENSI MASUK</div>
             <div class="h5 mb-0 text-muted"><?= $setting['sekolah'] ?></div>
                 </div>
          <video id="video" width="320" height="240" autoplay></video>
            <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
              <p id="status">Tunggu 3 detik .....</p>
           </div>
          </div>             
        </div>
 
	</div>
</section>

<section id="kegiatan-jurnal" style="display:none;">
  <div class="row">
    <div class="col-md-3"></div>
      <div class="col-md-6">
       <div class="card">	   
		 <div class="card-body">
	     <div class="d-flex align-items-center flex-column mb-4">
            <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" >
                  </div>
			<div class="h5" style="color:blue;">JURNAL PRAKERIN HARI INI</div>
             <div class="h5 mb-0 text-muted"><?= $setting['sekolah'] ?></div>
                 </div>
                 <form id="formjurnal" class="row g-2" >	
                   <input type="hidden" name="ids" value="<?= $id_siswa; ?>" >
                   <input type="hidden" name="kelas" value="<?= $siswa['kelas']; ?>" >
                   <input type="hidden" name="dudi" value="<?= $dudi; ?>" >				   
						<div class="col-md-12">
						<label class="form-label bold">ASPEK KOMPETENSI</label>
						<select class="form-select" name="idk" required style="width: 100%">
						  <option value="">Pilih Kompetensi</option>
						  <?php
							$stmt = $pdo->prepare("SELECT id_kompetensi, kompeten FROM pkl_kompetensi WHERE jurusan = :jurusan");
							$stmt->execute([':jurusan' => $siswa['jurusan']]);

							while ($des = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . htmlspecialchars($des['id_kompetensi'], ENT_QUOTES, 'UTF-8') . "'>" .
									 htmlspecialchars($des['kompeten'], ENT_QUOTES, 'UTF-8') .
									 "</option>";
							}
							?>
					</select>
				</div>	
			<div class="col-md-12">
			<label class="form-label bold">PROSES PELAKSANAAN</label>
				<textarea name='proses' rows="8" class='form-control' required="true" ></textarea>
				 </div>	
			<div class="col-md-12 text-end">
			<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
      </div>
     </div>             
   </div>
  </div>
   <script>
    $('#formjurnal').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'siswa/tjurnal.php',
            data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="images/animasi.gif" style="width:50px;"></div>');
			},			
			success: function(data){  			
			setTimeout(function()
				{
				window.location.replace("?pg=<?= enkripsi('prakerin') ?>");
						}, 500);
									  
						}
					});
				return false;
			});
		</script>	
		
</section>


<section id="upload-foto" style="display:none;">
<div class="row">
   <div class="col-md-3"></div>
      <div class="col-md-6">
       <div class="card">	   
		 <div class="card-body">
	     <div class="d-flex align-items-center flex-column mb-4">
            <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" >
                  </div>
			<div class="h5" style="color:blue;">UPLOAD FOTO KEGIATAN</div>
                 </div>
                 <form id="formfoto" class="row g-2" >	
                   <input type="hidden" name="ids" value="<?= $id_siswa; ?>" >			   
						<div class="col-md-12">
						<label class="form-label bold">FOTO KEGIATAN</label>
						<input type="file" name="file" class="form-control" accept="image/*" capture="environment" required />
				</div>	
			<div class="col-md-12 text-end">
			<button type="submit" class="btn btn-primary">Upload</button>
			</div>
		</form>	
      </div>
     </div>             
   </div>
  </div> 
   <script>
    $('#formfoto').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'siswa/tkegiatan.php',
            data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="images/animasi.gif" style="width:50px;"></div>');
			},			
			success: function(data){  			
			setTimeout(function()
				{
				window.location.replace("?pg=<?= enkripsi('prakerin') ?>");
						}, 500);
									  
						}
					});
				return false;
			});
		</script>	
	 
</section>

<section id="ttd-pembimbing" style="display:none;">
<?php
$sql = "SELECT * 
        FROM pkl_jurnal 
        WHERE idsiswa = :idsiswa AND tanggal = :tanggal";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':idsiswa' => $id_siswa,
    ':tanggal' => $tanggal
]);
$data = $stmt->fetch(PDO::FETCH_ASSOC); 
?>

<div class="row">
     <div class="col-md-3"></div>
      <div class="col-md-6">
       <div class="card">	   
		 <div class="card-body text-center">
	     <div class="d-flex align-items-center flex-column mb-4">
            <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" >
                  </div>
			<div class="h5" style="color:blue;">UPLOAD TTD INSTRUKTUR</div>
             <div class="h5 mb-0 text-muted"><?= $setting['sekolah'] ?></div>
                 </div>
                 <?php if($data['status']==0): ?>
             <div class="h6 mb-4" style="color:red">MENUNGGU APROVE GURU PEMBIMBING</div>
			 <?php else: ?>
			 <p>Catatan Guru Pembimbing<br><?= $data['catatan'] ?></p>
			<div class="col-md-12">
			<a href="?pg=<?= enkripsi('ttd') ?>&ids=<?= $id_siswa; ?>" class="btn btn-primary">Upload TTD</a>
			</div>
			<?php endif; ?>
      </div>
     </div>             
   </div>
</div>	 
</section>

<section id="absen-pulang" style="display:none;">
<div class="row">
     <div class="col-md-3"></div>
      <div class="col-md-6">
       <div class="card">	   
		 <div class="card-body text-center">
	     <div class="d-flex align-items-center flex-column mb-4">
            <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" >
                  </div>
			<div class="h5" style="color:blue;">PRESENSI PULANG</div>
             <div class="h5 mb-0 text-muted"><?= $setting['sekolah'] ?></div>
                 </div>
                 
			<div class="col-md-12">
			<a href="?pg=<?= enkripsi('pulang') ?>&ids=<?= $id_siswa; ?>" class="btn btn-primary">Absen Pulang</a>
			</div>
      </div>
     </div>             
   </div>
</div>	 
</section>

<section id="tampil-data" style="display:none;">
<div class="row">
     <div class="col-md-1"></div>
      <div class="col-md-10">
       <div class="card">	   
		 <div class="card-body">
	     <div class="d-flex align-items-center flex-column mb-4">
            <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" >
                  </div>
			<div class="h5" style="color:blue;">DATA PRAKERIN</div>
             <div class="h5 mb-0 text-muted"><?= $setting['sekolah'] ?></div>
                 </div>
              <table id="datatable" class="table table-bordered" style="width:100%;font-size:12px">
                        <thead>
                            <tr>
                                <th width="5%">NO</th>                                               
                                <th width="30%">TANGGAL</th>
                                <th>JURNAL KEGIATAN</th>	
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							$sql = "
								SELECT tanggal, jurnal 
								FROM pkl_jurnal
								WHERE idsiswa = :idsiswa
								ORDER BY id DESC
							";

							$stmt = $pdo->prepare($sql);
							$stmt->execute([':idsiswa' => $id_siswa]);

							$no = 0;
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
								$no++;
							?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><?= date('d-m-Y',strtotime($data['tanggal'])) ?></td>
								<td style="text-align:left"><?= $data['jurnal'] ?></td>
                                
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>    
				</div>
			</div>             
		</div>
	</div>	 
</section>
<script>
const namaSiswa = document.getElementById('nama').value;
const tanggal = new Date().toISOString().slice(0,10);
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const status = document.getElementById('status');
const kameraSection = document.getElementById('kamera-section');
const kegiatanSection = document.getElementById('kegiatan-jurnal');
const uploadSection = document.getElementById('upload-foto');
const ttdSection = document.getElementById('ttd-pembimbing');
const pulangSection = document.getElementById('absen-pulang');
const datakuSection = document.getElementById('tampil-data');

async function getStatus() {
  const res = await fetch('siswa/checkstatus.php?nama=' + namaSiswa + '&tanggal=' + tanggal);
  const data = await res.json();

  kameraSection.style.display = 'none';
  kegiatanSection.style.display = 'none';
  uploadSection.style.display = 'none';
  ttdSection.style.display = 'none';
  pulangSection.style.display = 'none';
  datakuSection.style.display = 'none';

  if (!data.absenMasuk) {
    kameraSection.style.display = 'block';
    startCamera();
  } else if (!data.jurnal) {
    kegiatanSection.style.display = 'block';
  } else if (!data.upload) {
    uploadSection.style.display = 'block';
  } else if (!data.ttd) {
    ttdSection.style.display = 'block';
  } else if (!data.absenPulang) {
    pulangSection.style.display = 'block';
  } else {
   datakuSection.style.display = 'block';
    console.log("Semua tahap selesai hari ini.");
  }
}

// --- Kamera otomatis
function captureAndSend() {
  const ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  const foto = canvas.toDataURL('image/png');

  fetch('siswa/simpanabsen.php', {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: 'nama=' + encodeURIComponent(namaSiswa) +
          '&foto=' + encodeURIComponent(foto) +
          '&tanggal=' + encodeURIComponent(tanggal)
  })
  .then(r=>r.text())
  .then(t=>{
    try {
      const d = JSON.parse(t);
      if (d.status === 'success') {
        status.innerText = "Presensi berhasil!";
        video.srcObject?.getTracks().forEach(track=>track.stop());
        getStatus(); // lanjut ke langkah berikutnya
      } else {
        status.innerText = "Gagal: "+d.message;
      }
    } catch(e) { console.error(e,t); status.innerText="Respon tidak valid"; }
  })
  .catch(err=>status.innerText="Error: "+err);
}

function startCamera() {
  navigator.mediaDevices.getUserMedia({video:true})
    .then(stream=>{
      video.srcObject = stream;
      setTimeout(captureAndSend, 3000);
    })
    .catch(err=>{
      status.innerText="Tidak bisa akses kamera: "+err;
    });
}

// --- Jalankan
getStatus();
</script>
