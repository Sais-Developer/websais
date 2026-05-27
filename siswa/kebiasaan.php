 <style>
  fieldset {
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 10px;
   
	width:100%; 
    padding: 12px;
    box-sizing: border-box;
  }
  legend {
	font-size: 16px;
    font-weight: bold;
    padding: 0 8px;
  }
   .sig-wrap {
    border: 1px dashed #888;
    border-radius: 10px;
    padding: 8px
  }
   canvas {
    width: 100%;
    height: 180px;
    border: 1px solid #999;
    border-radius: 8px;
    touch-action: none
  }
  
  .note {
    font-size: 12px;
    color: #666;
  }
  .bold {
    font-size: 14px;
	font-weight: bold;
    color: #666;
  }
</style>
<?php
$tanggal_sekarang = date('Y-m-d');
$query = "SELECT COUNT(*) AS total FROM kebiasaan_harian WHERE tanggal = :tanggal AND id_siswa = :id_siswa";
$stmt = $pdo->prepare($query);
$stmt->execute([
    ':tanggal' => $tanggal_sekarang,
    ':id_siswa' => $id_siswa
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_baris = $row['total'];
?>

<?php if($total_baris==0): ?>

<link href="<?= $baseurl ?>/assets/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link rel='stylesheet' href='<?= $baseurl ?>/assets/datetimepicker/jquery.datetimepicker.css' />
<div class="row">
  <div class="col-xl-12" >
       <div class="card" >
	   <div class="card card-header" >
         <h5 class="card-title">Input Kebiasaan Harian</h5>
				</div>			
		<div class="card-body">
	

  <form id="formtambah" onsubmit="return beforeSubmit();">
  <input type="hidden" name="ids" value="<?= $id_siswa; ?>" >
  <input type="hidden" name="kelas" value="<?= $siswa['kelas']; ?>" >
    <fieldset>
      <legend>Tanggal & Waktu</legend>
      <div class="row">
        <div class="col-md-6">
			<label class="bold">Tanggal</label>
          <input type="text" name="tanggal" class="datepicker form-control" required value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="col-md-6">
          <label class="bold">Bangun Pagi (Pukul)</label>
          <input type="text" name="bangun_pagi" class="timer form-control" autocomplete="off" required="true">
        </div>
      </div>
    </fieldset>

  <fieldset>
  <legend>Ibadah</legend>
  <div class="row">

    <div>
      <label>
        <input type="checkbox" name="subuh" onclick="toggleDropdown(this, 'subuh_dd')" required="true"> Subuh
      </label>
      <select id="subuh_dd" name="subuh_pilihan" style="display:none;" class="form-select" required="true">
        <option value="">--Pilih--</option>
        <option value="Berjamaah di masjid">Berjamaah di masjid</option>
        <option value="Berjamaah di rumah">Berjamaah di rumah</option>
        <option value="Shalat sendirian di rumah">Shalat sendirian di rumah</option>
		<option value="Haid">Haid ( untuk akhat)</option>
      </select>
    </div>

    <div>
      <label>
        <input type="checkbox" name="dzuhur" onclick="toggleDropdown(this, 'dzuhur_dd')"required="true"> Dzuhur
      </label>
      <select id="dzuhur_dd" name="dzuhur_pilihan" style="display:none;" class="form-select" required="true">
	   <option value="">--Pilih--</option>
        <option value="Berjamaah di masjid">Berjamaah di masjid</option>
        <option value="Berjamaah di rumah">Berjamaah di rumah</option>
        <option value="Shalat sendirian di rumah">Shalat sendirian di rumah</option>
		<option value="Haid">Haid ( untuk akhat)</option>
      </select>
    </div>

    <div>
      <label>
        <input type="checkbox" name="ashar" onclick="toggleDropdown(this, 'ashar_dd')" required="true"> Ashar
      </label>
      <select id="ashar_dd" name="ashar_pilihan" style="display:none;" class="form-select" required="true">
        <option value="">--Pilih--</option>
        <option value="Berjamaah di masjid">Berjamaah di masjid</option>
        <option value="Berjamaah di rumah">Berjamaah di rumah</option>
        <option value="Shalat sendirian di rumah">Shalat sendirian di rumah</option>
		<option value="Haid">Haid ( untuk akhat)</option>
      </select>
    </div>

    <div>
      <label>
        <input type="checkbox" name="maghrib" onclick="toggleDropdown(this, 'maghrib_dd')" required="true"> Maghrib
      </label>
      <select id="maghrib_dd" name="maghrib_pilihan" class="form-select" style="display:none;">
        <option value="">--Pilih--</option>
         <option value="Berjamaah di masjid">Berjamaah di masjid</option>
        <option value="Berjamaah di rumah">Berjamaah di rumah</option>
        <option value="Shalat sendirian di rumah">Shalat sendirian di rumah</option>
		<option value="Haid">Haid ( untuk akhat)</option>
      </select>
    </div>

    <div>
      <label>
        <input type="checkbox" name="isya" onclick="toggleDropdown(this, 'isya_dd')" required="true"> Isya
      </label>
      <select id="isya_dd" name="isya_pilihan" style="display:none;" class="form-select" required="true">
        <option value="">--Pilih--</option>
         <option value="Berjamaah di masjid">Berjamaah di masjid</option>
        <option value="Berjamaah di rumah">Berjamaah di rumah</option>
        <option value="Shalat sendirian di rumah">Shalat sendirian di rumah</option>
		<option value="Haid">Haid ( untuk akhat)</option>
      </select>
    </div>

    <div>
      <label>
        <input type="checkbox" name="dhuha" onclick="toggleDropdown(this, 'dhuha_dd')" required="true"> Duha
      </label>
      <select id="dhuha_dd" name="dhuha_pilihan" style="display:none;" class="form-select" required="true">
        <option value="">--Pilih--</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      
      </select>
    </div>

    <div>
      <br>
      <label class="bold">Ibadah Lainnya</label>
      <input type="text" name="ibadah_lainnya" class="form-control" placeholder="contoh: sholat tahajud">
    </div>

  </div>
</fieldset>

<script>
function toggleDropdown(checkbox, dropdownId) {
  const dropdown = document.getElementById(dropdownId);
  dropdown.style.display = checkbox.checked ? 'inline-block' : 'none';
  if (!checkbox.checked) {
    dropdown.value = ""; // reset pilihan kalau uncheck
  }
}

function toggleTextbox(checkbox, textboxId) {
  const textbox = document.getElementById(textboxId);
  textbox.style.display = checkbox.checked ? 'inline-block' : 'none';
  if (!checkbox.checked) {
    textbox.value = ""; 
  }
}
</script>

	
	<fieldset>
      <legend>Olahraga & Belajar</legend>
      <div class="row">
		<div class="col-md-6">
          <label class="bold">Olahraga (Jenis)</label>
          <input type="text" name="olahraga_jenis" class="form-control" placeholder="Lari, Badminton, dll" required="true">
        </div>
        <div class="col-md-6">
          <label class="bold">Durasi</label>
          <input type="text" name="olahraga_durasi" class="form-control" placeholder="30 menit" required="true">
        </div>
      <div class="col-md-12">
      <label class="bold">Gemar Belajar (Berikan Judul dan resume singkatnya)</label>
    <textarea name="mapel" class="form-control" rows="5" required="true"></textarea>
	  </div>
	  </div>
    </fieldset>
    <fieldset>
      <legend>Makan & Bermasyarakat</legend>
	  <div class="row">
	  <div class="col-md-6">
      <label class="bold">Menu Makan Sehat dan Bergizi</label>
      <textarea name="menu_makan" rows="3" class="form-control" required="true" placeholder="Contoh: nasi + sayur + lauk"></textarea>
	  </div>
	  <div class="col-md-6">
      <label class="bold">Membantu Orang Tua</label>
	  <select  name="kegiatan_masyarakat" class="form-select" required="true">
        <option value="">--Pilih--</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>      
      </select>      
    </div>
	 </div>
	</fieldset>

    <fieldset>
      <legend>Istirahat</legend>
	  <div class="col-md-12">
      <label class="bold">Istirahat Cukup (Pukul)</label>
      <input type="text" name="istirahat" class="timer form-control" autocomplete="off" required="true">
	  </div>
    </fieldset>
    <fieldset>
      <legend>Tanda Tangan Digital</legend>
      <div class="row">
	    <div class="col-md-6">
        <div class="sig-wrap mb-2">
          <strong>Paraf Orang Tua</strong>
          <canvas id="padOrtu" class="form-control" ></canvas>
		  </div>
          <div class="text-end mb-2">
            <button type="button" class="btn btn-danger" onclick="clearPad('padOrtu')">Hapus Ttd</button>
          </div>
          <div class="note">Tanda tangani di area kotak.</div>
        
        </div>
		
      
      <input type="hidden" name="signature_ortu" id="signature_ortu">
	  <div class="col-md-6 mb-4">
	  <label class="bold">Nama Orang Tua</label>
      <input type="text" name="ortu" class="form-control" required="true">
	  </div>
	  </div>
    </fieldset>
    <div class="text-end">
      <button class="btn btn-primary" type="submit">Simpan</button>
     
    </div>
  </form>
  <script src="<?= $baseurl ?>/siswa/signature_pad.umd.min.js"></script>
  <script src='<?= $baseurl ?>/assets/datetimepicker/build/jquery.datetimepicker.full.min.js'></script>
  <script>
    const canvases = {
      padOrtu: new SignaturePad(document.getElementById('padOrtu'), {backgroundColor: 'rgba(255,255,255,0)', penColor: 'black'}),
    
    };
    function resizeCanvas(cnv, pad) {
      const ratio = Math.max(window.devicePixelRatio || 1, 1);
      cnv.width  = cnv.offsetWidth * ratio;
      cnv.height = cnv.offsetHeight * ratio;
      cnv.getContext("2d").scale(ratio, ratio);
      pad.clear();
    }
    Object.keys(canvases).forEach(id => resizeCanvas(document.getElementById(id), canvases[id]));
    window.addEventListener('resize', () => {
      Object.keys(canvases).forEach(id => resizeCanvas(document.getElementById(id), canvases[id]));
    });

    function clearPad(id){ canvases[id].clear(); }
    function resetAll(){
      Object.values(canvases).forEach(p => p.clear());
      document.getElementById('signature_ortu').value = '';
     
    }

    function beforeSubmit(){
     
      if (!canvases.padOrtu.isEmpty()) {
        document.getElementById('signature_ortu').value = canvases.padOrtu.toDataURL('image/png');
      }
      
      return true;
    }
  </script>
<script>
    $('#formtambah').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'siswa/simpan.php',
            data: data,
			cache: false,
			contentType: false,
			processData: false,				
			success: function(data){   		
			setTimeout(function()
				{
				window.location.replace(".");
						}, 200);
									  
						}
					});
				return false;
			});
		</script>
		<script>
			$('.datepicker').datetimepicker({
				timepicker: false,
				format: 'Y-m-d'
				});
			$('.tgl').datetimepicker();
			$('.timer').datetimepicker({
				datepicker: false,
				format: 'H:i'
				});	

			</script>
			<?php else : ?>
<div class="alert alert-warning">
<strong>Saat ini <?= $siswa['nama'] ?></strong> Sudah mengisi <b> Jurnal Kebiasaan</b>.
	</div>
<?php endif; ?>