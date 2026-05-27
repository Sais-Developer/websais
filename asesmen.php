<style>
  #modalPopup {
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5);
  z-index: 9999;

  display: flex;
  align-items: center;   
  justify-content: center; 
}

#modalPopup > div {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 320px;
  height: 320px;
background-size: 260px;
  background-image: url('images/tutwuri2.png');
  background-repeat: no-repeat;
  background-position: top right;
  display: flex;          
  flex-direction: column; 
  align-items: center;    
  justify-content: center; 
  text-align: center;
  font-family: Arial, sans-serif;
}

#modalPopup button {
  padding: 8px 16px;
  background-color: #005bbb;
  border: none;
  color: white;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px; 
}

</style>
<style>
.tampil-mobile {
    display: block;
}

@media (min-width: 769px) {
    .tampil-mobile {
        display: none;
    }
}
.tampil-desktop {
    display: none;
}
@media (min-width: 769px) {
    .tampil-desktop {
        display: block;
    }
}
</style>
<?php
$ac = dekripsi($_GET['idu'] ?? '');
$id = dekripsi($_GET['ids'] ?? '');
if (!$ac || !$id) {
    jump($baseurl);
    exit;
}
$stmt_cek = $pdo->prepare("SELECT * FROM nilai WHERE id_ujian = :id_ujian AND id_siswa = :id_siswa");
$stmt_cek->execute([':id_ujian' => $ac, ':id_siswa' => $id]);
$query = $stmt_cek->fetch(PDO::FETCH_ASSOC);

if (!$query) {
    jump($baseurl);
    exit;
}
$idmapel = $query['id_bank'];
$id_bank = $idmapel;
$id_siswa = $id;
$no_soal = 0;
$no_prev = $no_soal - 1;
$no_next = $no_soal + 1;

$waktumu = date('Y-m-d H:i:s');
$stmt_upd = $pdo->prepare("UPDATE nilai SET ujian_berlangsung = :waktumu WHERE id_ujian = :id_ujian AND id_siswa = :id_siswa");
$stmt_upd->execute([
    ':waktumu'  => $waktumu,
    ':id_ujian' => $ac,
    ':id_siswa' => $id_siswa
]);
$stmt_mapel = $pdo->prepare("SELECT * FROM ujian WHERE id_jadwal = :id_jadwal");
$stmt_mapel->execute([':id_jadwal' => $ac]);
$mapel = $stmt_mapel->fetch(PDO::FETCH_ASSOC);
$lama_ujian = isset($mapel['lama_ujian']) ? (int)$mapel['lama_ujian'] : 0;

$stmt_nilai = $pdo->prepare("SELECT * FROM nilai WHERE id_ujian = :id_ujian AND id_siswa = :id_siswa");
$stmt_nilai->execute([':id_ujian' => $ac, ':id_siswa' => $id_siswa]);
$nilai = $stmt_nilai->fetch(PDO::FETCH_ASSOC);

$ujian_mulai = $nilai['ujian_mulai'] ?? date('Y-m-d H:i:s');
$ujian_berlangsung = $nilai['ujian_berlangsung'] ?? date('Y-m-d H:i:s');

$habis = strtotime($ujian_berlangsung) - strtotime($ujian_mulai);
$detik = ($lama_ujian * 60) - $habis;
$dtk = max(0, $detik % 60);
$mnt = max(0, floor(($detik % 3600) / 60));
$jam = max(0, floor(($detik % 86400) / 3600));

$stmt_soal = $pdo->prepare("SELECT id_bank FROM soal WHERE id_bank = :id_bank");
$stmt_soal->execute([':id_bank' => $id_bank]);
$jumsoal = $stmt_soal->rowCount();
?>
<div class='row'>
<?php if ($setting['webcam'] == 1): ?>
	<div id="modalPopup">
	  <div>
		<p>Kamera Harus diaktifkan, Jika tidak aktif maka tidak dapat mengisi Soal</p>
		<button id="retryBtn">OK</button>
	  </div>
	</div>
   <?php endif; ?>
   
	<div class='card'>
		<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title mb-0">
            <span class="tampil-desktop">NOMOR </span>
            <span class="btn  btn-dark btn-rounded" id="displaynum"><b><?= $no_next ?></b></span>
        </h5>
    </div>
    <div>
        <span class="tampil-desktop" style="font-size:20px; margin-right:5px;">Sisa Waktu</span>
        <span style="font-size:20px" id="countdown">
            <span id="htmljam"><?= $jam ?></span>:
            <span id="htmlmnt"><?= $mnt ?></span>:
            <span id="htmldtk"><?= $dtk ?></span>
        </span>
    </div>
</div>
<div class='btn-group'>
	<form action='' method='post'>
		<input type='submit' name='done' id='done-submit' style='display:none;' />
	</form>
</div>
<div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background-color: #e3f2fd; border-radius: 5px;">
    <div class="btn-group">
        <button type="button" id="smaller_font" class="btn  btn-primary me-2">-</button>
        <button type="button" id="bigger_font" class="btn  btn-primary">+</button>
    </div>
    <div>
        <button type="button" class="btn  btn-primary" data-bs-toggle="modal" data-bs-target="#modalnosoal">
            Daftar Soal 
        </button>
    </div>
</div>

<div class="modal fade" id="modalnosoal" tabindex="-1" aria-labelledby="modalnosoalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalnosoalLabel">Daftar Soal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <div id="loadnosoal"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div id='loadsoal' ></div>
    </div>
</div>
<?php if ($setting['webcam'] == 1): ?>
<video id="video" autoplay style="display:none;"></video>
 <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
<script>
const peserta = "<?php echo $siswa['nama']; ?>";

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const modal = document.getElementById('modalPopup');
const retryBtn = document.getElementById('retryBtn');


function ambilFoto(type="interval") {
  if (!video.srcObject) return; // jika kamera belum aktif, skip

  const ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  const dataURL = canvas.toDataURL('image/jpeg', 0.6);

  fetch('simpan_foto.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ image: dataURL, peserta: peserta, type: type })
  })
  .then(res => res.text())
  .then(data => console.log(data))
  .catch(err => console.error(err));
}

function aksesWebcam() {
  navigator.mediaDevices.getUserMedia({ video: true })
  .then(stream => {
    modal.style.display = 'none';
    video.srcObject = stream;

    video.addEventListener('canplay', () => {
      console.log("Video siap, ambil foto pertama");
      ambilFoto("first");

      setInterval(() => ambilFoto("interval"), 60000);
    }, { once: true }); 
  })
  .catch(err => {
    console.error("Error webcam:", err);
    modal.style.display = 'flex';
  });
}

retryBtn.addEventListener('click', () => {
  aksesWebcam();
});

loadSoal();    
aksesWebcam(); 
</script>
<?php endif; ?>
