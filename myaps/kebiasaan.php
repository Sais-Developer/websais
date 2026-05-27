<?php 
defined('APK') or exit('No Access');
$tanggal = date('Y-m-d');

$stmt1 = $pdo->prepare("SELECT COUNT(tanggal) FROM kebiasaan_harian WHERE tanggal = :tanggal");
$stmt1->execute([':tanggal' => $tanggal]);
$jurnal = $stmt1->fetchColumn();

$stmt2 = $pdo->prepare("SELECT COUNT(paraf_guru) 
                        FROM kebiasaan_harian 
                        WHERE tanggal = :tanggal AND paraf_guru IS NULL");
$stmt2->execute([':tanggal' => $tanggal]);
$paraf = $stmt2->fetchColumn();

$stmt3 = $pdo->prepare("SELECT COUNT(catatan_guru) 
                        FROM kebiasaan_harian 
                        WHERE tanggal = :tanggal AND catatan_guru IS NULL");
$stmt3->execute([':tanggal' => $tanggal]);
$catat = $stmt3->fetchColumn();
?>

<style>
.header-toolbar {
    background-color: #f8f9fa; 
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}
.container-fluid {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header-toolbar-menu {
    display: flex;
    list-style: none;
    padding: 10;
    margin: 0;
}
.header-toolbar-menu li {
    margin-right: 20px;
}
.header-toolbar-menu a {
    text-decoration: none;
    color: #fff; 
    font-size: 1rem;
    font-weight: 600;
    transition: color 0.3s ease;
}
.header-toolbar-menu a:hover {
    color: #fff; 
}
.header-toolbar-actions {
    display: flex;
    gap: 15px;
}
.header-toolbar-actions a {
    text-decoration: none;
    font-size: 0.9rem;
    padding: 8px 15px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background-color 0.3s ease;
}
.header-toolbar-actions .btn-primary {
    background-color: #007bff; 
    color: white;
}
.header-toolbar-actions .btn-primary:hover {
    background-color: #0056b3;
}
.header-toolbar-actions .btn-success {
    background-color: #28a745; 
    color: white;
}
.header-toolbar-actions .btn-success:hover {
    background-color: #218838;
}
</style>
<div class="header-toolbar mb-3">
		<div class="container-fluid">
			<ul class="header-toolbar-menu">
			  
			</ul>
			<div class="header-toolbar-actions hidden-on-mobile">
				<a href="?pg=<?= enkripsi('cetakkeb') ?>" class="btn btn-primary"><i class="material-icons-outlined">print</i>Print</a>
				&nbsp;&nbsp;&nbsp;
			</div>
		</div>
	</div>
</div>			
 <?php if ($ac == '') : ?>
<div class="row">
  <div class="col-md-8">
		<div class="card">
			<div class="card card-header">
				<h5 class="card-title">JURNAL KEBIASAAN HARI INI</h5>										
			</div>
			<div class="card-body">									
			<div class="card-box table-responsive">
				<table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
					<thead>
						<tr>
							<th>NO</th>                                               
							<th>NAMA SISWA</th>
							<th>KELAS</th>
							<th>GEMAR BELAJAR</th>
							<th>#</th>   
						</tr>
					</thead>
					<tbody>
					<?php
					$no = 0;
					$sql = "
						SELECT k.*, g.*, s.*
						FROM kebiasaan_harian k
						LEFT JOIN guru g ON g.id_guru = k.id_guru
						LEFT JOIN siswa s ON s.id_siswa = k.id_siswa
						WHERE k.tanggal = :tanggal 
						  AND k.paraf_guru IS NULL
					";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([':tanggal' => $tanggal]);

					$dataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach ($dataList as $data):
						$no++;
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= ucwords(strtolower($data['nama'])) ?></td>
						<td>
							<h5><span class="badge badge-primary"><?= $data['kelas'] ?></span></h5>
						</td>
						<td><?= $data['mapel'] ?></td>
						<td>
							<a href="?pg=<?= enkripsi('kebiasaan') ?>&ac=<?= enkripsi('edit') ?>&ids=<?= enkripsi($data['id']) ?>">
								<button class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Paraf Guru">
									<i class="material-icons">edit</i>
								</button>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			    </table>
			 </div>
		</div>
	</div>
</div>
<div class="col-xl-4">
	<div class="card widget widget-stats mb-3">
		<div class="card-body">
			<div class="widget-stats-container d-flex">
				<div class="widget-stats-icon widget-stats-icon-success">
					<i class="material-icons-outlined">menu</i>
				</div>
				<div class="widget-stats-content flex-fill">
					<span class="widget-stats-title">JURNAL HARI INI</span>
					<span class="widget-stats-amount"><?= $jurnal; ?></span>
					<span class="widget-stats-info"></span>
				</div>
				
			</div>
		</div>
	</div> 
   <div class="card widget widget-stats mb-3">
		<div class="card-body">
			<div class="widget-stats-container d-flex">
				<div class="widget-stats-icon widget-stats-icon-warning">
					<i class="material-icons-outlined">apps</i>
				</div>
				<div class="widget-stats-content flex-fill">
					<span class="widget-stats-title">BELUM DI PARAF GURU</span>
					<span class="widget-stats-amount"><?= $paraf; ?></span>
					<span class="widget-stats-info"></span>
				</div>
				
			</div>
		</div>
	</div>
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-primary">
						<i class="material-icons-outlined">select_all</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">BELUM ADA CATATAN GURU</span>
						<span class="widget-stats-amount"><?= $catat; ?> </span>
						<span class="widget-stats-info"></span>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<?php elseif($ac == enkripsi('edit')): ?>
<?php
$ids = dekripsi($_GET['ids']);
$jurnal = fetch('kebiasaan_harian',['id'=>$ids]);
?>
<div class="row">
	<div class="col-md-8">
	   <div class="card">
			<div class="card card-header">
			<h5 class="card-title">JURNAL KEBIASAAN HARI INI</h5>										
	  </div>
	  <div class="card-body">	
		<table width="100%" border="1">
			<tr style="font-weight:bold;align-vertical:center;">
			<td height="30px" width="40%">&nbsp;Kebiasaan</td>
			<td>Waktu / Aktivitas</td>
			</tr>
			<tr>
			<td>&nbsp;1. Bangun pagi</td>
			<td>Pukul: <?= $jurnal['bangun_pagi'] ?></td>
			</tr>
			<tr>
			<td height="30px" style="vertical-align:middle">&nbsp;2. Beribadah</td>
			<td>
			 <label class="check-label">
			<input type="checkbox" <?php if($jurnal['subuh']!='') echo 'checked'; ?>>
			Subuh <small style="color:blue"><?= $jurnal['subuh_pilihan'] ?></small>
		</label><br>

		<label class="check-label">
			<input type="checkbox" <?php if($jurnal['dzuhur']!='') echo 'checked'; ?>>
			Dzuhur <small style="color:blue"><?= $jurnal['dzuhur_pilihan'] ?></small>
		</label><br>

		<label class="check-label">
			<input type="checkbox" <?php if($jurnal['ashar']!='') echo 'checked'; ?>>
			Ashar <small style="color:blue"><?= $jurnal['ashar_pilihan'] ?></small>
		</label><br>

		<label class="check-label">
			<input type="checkbox" <?php if($jurnal['maghrib']!='') echo 'checked'; ?>>
			Maghrib <small style="color:blue"><?= $jurnal['maghrib_pilihan'] ?></small>
		</label><br>

		<label class="check-label">
			<input type="checkbox" <?php if($jurnal['isya']!='') echo 'checked'; ?>>
			Isya <small style="color:blue"><?= $jurnal['isya_pilihan'] ?></small>
		</label><br>

		<label class="check-label">
			<input type="checkbox" <?php if($jurnal['dhuha']!='') echo 'checked'; ?>>
			Duha <small style="color:blue"><?= $jurnal['duha_pilihan'] ?></small>
		</label><br>

	   
		<label class="check-label">
			
			Ibadah Lainnya <small style="color:blue"><?= $jurnal['ibadah_lainnya'] ?></small>
		</label>
			</td>
			</tr>
			<tr>
			<td>&nbsp;3. Berolahraga</td>
			<td>Jenis: <?= $jurnal['olahraga_jenis'] ?> &nbsp;&nbsp;&nbsp; durasi: <?= $jurnal['olahraga_durasi'] ?></td>
			</tr>
			<tr>
			<td>&nbsp;4. Gemar Membaca</td>
			<td><?= $jurnal['mapel'] ?></td>
			</tr>
			<tr>
			<td>&nbsp;5. Makan Sehat dan Bergizi</td>
			<td>Menu: <?= $jurnal['menu_makan'] ?></td>
			</tr>
			<tr>
			<td>&nbsp;6. Membantu Orang Tua</td>
			<td><?= $jurnal['kegiatan_masyarakat'] ?></td>
			</tr>
			<tr>
			<td>&nbsp;7. Istirahat Cukup</td>
			<td>Pukul: <?= $jurnal['istirahat'] ?></td>
			</tr>
			</table>
			<br>
			<table width="100%" border="1" style="font-size:11px">
			<tr style="text-align:center;">
			<td width="20%" style="vertical-align:top;">
			Paraf Ortu<br>
			<img src="../images/ttd/<?= $jurnal['paraf_ortu'] ?>" width="130px" height="80px">
			<br><?= $jurnal['ortu'] ?>
			</td>
			<td width="20%" style="vertical-align:top;">
			Paraf Guru<br>
			<?php if($jurnal['paraf_guru']==''): ?>
			<br><br>
			<?php else: ?>
			<img src="../images/ttd/<?= $jurnal['paraf_guru'] ?>" width="130px" height="80px">
			<br><?= $user['nama'] ?>
			<?php endif; ?>
			</td>
			<td style="vertical-align:top;">
			Catatan Guru<br>
			<?php if($jurnal['catatan_guru']==''): ?>
			<br><br>
			<?php else: ?>
			<?= $jurnal['catatan_guru'] ?>
			<?php endif; ?>
			</td>
			</tr>
			</table>	
		</div>
	</div>
</div>	
<div class="col-md-4">
    <div class="card">
        <div class="card card-header">
           <h5 class="card-title">JURNAL KEBIASAAN HARI INI</h5>										
          </div>
        <div class="card-body">	
	<form id="formtambah" onsubmit="return beforeSubmit();">
	   <input type="hidden" name="id" value="<?= $ids; ?>" >
	  <input type="hidden" name="idguru" value="<?= $id_user; ?>" >
		<fieldset>
		  <legend></legend>
		  <div class="row">
		  <div class="col-md-12">
		  <strong>Catatan Guru</strong>
		  <textarea name="catatan" class="form-control" rows="3"></textarea>
		  </div>
			<div class="col-md-12">
			<div class="sig-wrap mb-2">
			  <strong>Paraf Guru Kelas/ Walas</strong>
			  <canvas id="padOrtu" class="form-control" ></canvas>
			  </div>
			  <div class="text-end mb-2">
				<button type="button" class="btn btn-danger" onclick="clearPad('padOrtu')">Hapus Ttd</button>
			  </div>
			
		</div>
			<input type="hidden" name="signature_ortu" id="signature_ortu">
	  <div class="col-md-12 mb-4">
		<label>Nama Walas</label>
			<input type="text" name="guru" class="form-control" value="<?= $user['nama'] ?>" required="true">
	  </div>
	 </div>
    </fieldset>
<?php if($user['walas']===$jurnal['kelas']): ?>
    <div class="mb-2">
	<div class="row">
	<div class="col-md-6">
      <a href="." class="btn btn-primary" type="submit">Kembali</a>
	  </div>
	  <div class="col-md-6 text-end">	  
     <button class="btn btn-success" type="submit">Simpan</button>
    </div>
	 </div>
	  </div>
	   <?php else: ?>
	   <br>
	 <p style="color:red">Maaf Anda Bukan Wali Kelas <?= $jurnal['kelas'] ?></p>
	 <?php endif; ?>
  </form>
  <script src="<?= $baseurl ?>/siswa/signature_pad.umd.min.js"></script>
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
	 url: 'simpan.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
	$('.progress-bar').animate({

	}, 500);
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
	 
<?php endif; ?>	
                     
                    