<?php 
defined('APK') or exit('No Access');
$id_skl = 1;

$sql = "SELECT * FROM skl WHERE id_skl = :id_skl";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_skl' => $id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);

$kuri = $skl['kuri'] ?? null;
$waktumu = date('Y-m-d H:i:s');
?>

<?php if($siswa['level']==$skl['tingkat']): ?>
<style>
#clockdiv{
  font-family: sans-serif;
  color: #fff;
  display: inline-block;
  font-weight: 20;
  text-align: center;
  font-size: 20px;
}

#clockdiv > div{
  padding: 10px;
  border-radius: 3px;
  background: #00BF96;
  display: inline-block;
}

#clockdiv div > span{
  padding: 15px;
  border-radius: 3px;
  background: #00816A;
  display: inline-block;
}

.smalltext{
  padding-top: 5px;
  font-size: 16px;
}

  .form-container {
      display: none; /* All forms hidden by default */
    }
.h3 {
transform:rotate(-20deg);
-ms-transform:rotate(-20deg); /* IE 9 */
-webkit-transform:rotate(-20deg); /* Safari and Chrome */
}

/* Mengatur tampilan kontainer */
.download-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin: 20px;
}

/* Mengatur setiap item download */
.download-item {
  display: flex;
  justify-content: space-between; /* Mengatur jarak antara ikon, label, dan tombol */
  align-items: center;
  background-color: #f9f9f9;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Ikon di sebelah kiri */
.download-item .icon {
  font-size: 24px;
  margin-right: 15px;
}

/* Label download */
.download-item .label {
  font-size: 16px;
  font-weight: bold;
  flex-grow: 1; /* Membuat label mengisi ruang yang tersedia */
}

/* Tautan download */
.download-item .download-link {
  color: #007bff;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
}

.download-item .download-link:hover {
  text-decoration: underline;
}

</style>
<div class="row">
<div class="col-md-6 mb-3">
	<div class="card">
	<div class="card-body text-center"> 
	<div class="d-flex align-items-center flex-column">
		<div class="sw-13 position-relative mb-3">
		<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" style="width:180px">
					</div>
				<div class="text-muted">E KELULUSAN</div>
				<div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
				<div class="text-muted">HIGH SCHOOL</div>
					</div>
				<br>
				<div class="h5 mb-0 text-center">
				<?php if($waktumu <= $skl['dibuka']): ?>
				PENGUMUMAN DIBUKA DALAM
				<?php endif; ?>
				<?php if($waktumu >= $skl['dibuka'] AND $waktumu <= $skl['ditutup']): ?>
				PENGUMUMAN SUDAH DIBUKA
				<?php endif; ?>
				<?php if($waktumu >= $skl['ditutup']): ?>
				PENGUMUMAN DITUTUP
				<?php endif; ?>
				</div>
				<?php if($waktumu < $skl['dibuka']): ?>
				<div id="clockdiv">
					<div>
					<span class="days"></span>
					<div class="smalltext">Hari</div>
					</div>
					 <div>
					<span class="hours"></span>
					<div class="smalltext">Jam</div>
					</div>
					<div>
					<span class="minutes"></span>
					<div class="smalltext">Menit</div>
					</div>
					<div>
					<span class="seconds"></span>
					<div class="smalltext">Detik</div>
					</div>
					</div> 
                    <?php endif; ?>					
						</div>					
				 </div>
				  </div>
			 
				  <div class="col-md-6 mb-3">                  
				<div class="card">
				<div class="card-body">			 
				<div class="d-flex align-items-center flex-column">
					<div class="sw-13 position-relative">
					<?php if($siswa['foto']<>''): ?>
						<img src="<?= $baseurl ?>/images/fotosiswa/<?= $siswa['foto'] ?>" style="width:200px">								
					<?php else : ?>		
					<img src="<?= $baseurl ?>/images/siswa.png" style="width:200px">	
						<?php endif; ?>		
								</div>
							<div class="text-muted">E KELULUSAN</div>
							
							<div class="text-muted"><?= $siswa['kelas'] ?> <?= $siswa['jurusan'] ?></div>
						</div>
						<?php if($waktumu < $skl['dibuka']): ?>
							<div class="d-flex align-items-center flex-column">
							<br>
							<img src="<?= $baseurl ?>/images/animasi.gif" class="responsive-img" alt="thumb" />	
							<br>
							<div class="text-muted">MENUNGGU KELULUSAN</div>
						<div class="h5 mb-0"><?= $siswa['nama'] ?></div>
						<div class="text-muted">Semoga Lulus</div>
							</div>
							<?php endif; ?>	
							<?php if($waktumu >= $skl['dibuka'] AND $waktumu <= $skl['ditutup']): ?>
							<div class="h5 mb-2 text-center"><?= $siswa['nama'] ?></div>
							<br>
							<div class="d-flex align-items-center flex-column">
							<input type="image" name="submit" src="<?= $baseurl ?>/images/amplop.png"  width="200px"  id="A" >
							</div>
							<div class="form-container" id="formB">
							<div class="d-flex align-items-center flex-column" style="height:200px">
							<img src="<?= $baseurl ?>/images/buka.png" width="300px" >
							
							<?php if($siswa['ket']=='0'): ?>
							<h3 style="margin-top:-130px;text-align:center;font-weight:bold;color:red" class="h3">TIDAK LULUS</h3>
							
							<?php endif; ?>
							<?php if($siswa['ket']=='1'): ?>
							
							<h3 style="margin-top:-130px;text-align:center;font-weight:bold;color:green" class="h3">LULUS</h3>
							
							<?php endif; ?>
							<?php if($siswa['ket']=='2'): ?>
							<div class="h4 mb-2 text-center">
			
							<h3 style="margin-top:-130px;text-align:center;font-weight:bold;color:blue" class="h3">LULUS BERSYARAT</h3>
							</div>
							<?php endif; ?>
							</div>
							  <?php if($siswa['ket']<>0): ?>
				            
							   <div class="download-container">
								  <div class="download-item">
									<span class="icon">&#9993;</span> 
									<span class="label">DOWNLOAD KELULUSAN</span>
									<a href="siswa/print_skl.php?ids=<?= $siswa['id_siswa'] ?>" target="_blank" class="download-link">Download</a>
								  </div>
								  <div class="download-item">
									<span class="icon">&#9853;</span> 
									<span class="label">DOWNLOAD SKKB</span>
									<a href="siswa/cetakskkb.php?ids=<?= $siswa['id_siswa'] ?>" target="_blank" class="download-link">Download</a>
								  </div>
								  <div class="download-item">
									<span class="icon">&#128248;</span> 
									<span class="label">DOWNLOAD TRANSKRIP</span>
									<a href="siswa/transkipnilai.php?ids=<?= $siswa['id_siswa'] ?>" target="_blank" class="download-link">Download</a>
								  </div>
								</div>

				           <?php endif; ?>
						     <?php endif; ?>
							</div>
						  </div>
						</div>
				     </div>
                     </div>
		<script>
		$("#A").click(function() {
			$("#formB").show(); 
			$("#A").hide();
			});
		</script>
	<script>

function getTimeRemaining(endtime) {
  const total = endtime - new Date().getTime();
  const seconds = Math.floor((total / 1000) % 60);
  const minutes = Math.floor((total / 1000 / 60) % 60);
  const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
  const days = Math.floor(total / (1000 * 60 * 60 * 24));
  return { total, days, hours, minutes, seconds };
}
function initializeClock(id, endtime) {
  const clock = document.getElementById(id);
  if (!clock) return;

  const daysSpan = clock.querySelector('.days');
  const hoursSpan = clock.querySelector('.hours');
  const minutesSpan = clock.querySelector('.minutes');
  const secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    const t = getTimeRemaining(endtime);

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
      clearInterval(timeinterval);
      daysSpan.innerHTML = 0;
      hoursSpan.innerHTML = "00";
      minutesSpan.innerHTML = "00";
      secondsSpan.innerHTML = "00";
     
    }
  }
  updateClock();
  const timeinterval = setInterval(updateClock, 1000);
}
const deadlineString = "<?= date('Y-m-d\TH:i:s', strtotime($skl['dibuka'])) ?>";
console.log("Countdown target:", deadlineString); // debug di console
const deadline = new Date(deadlineString).getTime();
initializeClock('clockdiv', deadline);
</script>
<?php else: ?>
<div class="alert alert-warning">
	<strong>Belum ada Kelulusan</strong> untuk kelas <b><?= $siswa['kelas'] ?></b> saat ini.
	</div>
<?php endif; ?>