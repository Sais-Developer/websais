<style>
section { width:100%; margin:5px auto; }
video, canvas { border:1px solid #ddd; border-radius:5px; }
img.responsive { max-width: 50%; height: auto; border-radius: 6px; display: block; margin: 10px auto; }
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
$ids = $_GET['ids'];
?>

<section style="display:none;">
  <label for="nama">Nama Siswa:</label>
  <select id="nama">
    <option value="<?= $siswa['id_siswa'] ?>"><?= $siswa['nama'] ?></option>
  </select>
</section>

<section id="kamera-section">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="mb-4">
            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" alt="Logo Sekolah" />
            <div class="h5 text-primary">PRESENSI PULANG</div>
            <div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
          </div>
          <video id="video" width="320" height="240" autoplay></video>
          <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
          <p id="status" class="text-muted">Tunggu 3 detik...</p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const namaSelect = document.getElementById('nama');
const status = document.getElementById('status');

function captureAndSend() {
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    const foto = canvas.toDataURL('image/png');
    const idsiswa = namaSelect.value;
    const tanggal = new Date().toISOString().split('T')[0]; 

    fetch('siswa/updatepresensi.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'idsiswa=' + encodeURIComponent(idsiswa) +
              '&tanggal=' + encodeURIComponent(tanggal)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            status.innerText = data.message;  
			setTimeout(function()
				{
				window.location.replace("?pg=<?= enkripsi('prakerin') ?>");
						}, 500);
        } else {
            status.innerText = data.message;  
        }
        video.style.display = 'none';
    })
    .catch(err => {
        console.error('Terjadi kesalahan:', err);
        status.innerText = 'Terjadi kesalahan, coba lagi!';
    });
}

navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => {
    video.srcObject = stream;
    setTimeout(captureAndSend, 3000);  
})
.catch(err => {
    console.error("Tidak dapat mengakses kamera: ", err);
    status.innerText = "Tidak dapat mengakses kamera: " + err;
});

</script>
