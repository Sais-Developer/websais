 <?php 
defined('APK') or exit('No Access');
$bulan = date('m');
$blQ = fetch('bulan',['bln'=>$bulan]);
?>
<div class="row">
	  <div class="col-xl-8">
			<div class="card">
			   <div class="card-header">
			<h5 class="card-title">DATA PRESENSI</h5>
					</div>
				<div class="card-body">
					 <div class="card-box table-responsive">
					<table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
						<thead>
							<tr>
							<th width="9%">NO</th>
							<th>BULAN</th>
							<th width="15%">SISWA</th>
							<th width="15%">PEGAWAI</th>
							<th width="15%">TOTAL</th>												
							</tr>
						</thead>
						<tbody>
						<?php
						$no = 0;
						$stmt = $pdo->prepare("SELECT * FROM bulan");
						$stmt->execute();
						$bulanList = $stmt->fetchAll(PDO::FETCH_ASSOC);
						foreach ($bulanList as $data):
							$no++;
							$absis = rows('absensi', ['bulan' => $data['bln'], 'level' => 'siswa']);
							$abpeg = rows('absensi', ['bulan' => $data['bln'], 'level' => 'pegawai']);
						?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= htmlspecialchars($data['ket']); ?></td>
							<td><?= $absis ?: ''; ?></td>
							<td><?= $abpeg ?: ''; ?></td>
							<td class="bold"><?= ($absis + $abpeg) ?: ''; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			</div>                                                                                  
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
				 <form id="formabsen">
				 <p>Jika data terasa berat, Sebelum menghapus pastikan data telah dicetak</p>
				 <div class="col-md-12 mb-4">
				   <label>BULAN</label>
					<select name="bulan"  class="form-select" style="width: 100%;" required >
					 <option value=''></option>
						<?php
						$stmt = $db->prepare("SELECT bln, ket FROM bulan ORDER BY bln ASC");
						$stmt->execute();

						while ($mt = $stmt->fetch(PDO::FETCH_ASSOC)):
						?>
							<option value="<?= htmlspecialchars($mt['bln']) ?>">
								<?= htmlspecialchars($mt['ket']) ?> <?= date('Y') ?>
							</option>
						<?php endwhile; ?>
					</select>   
				</div>                                               
				 <div class="d-grid gap-2">
					<button type="submit"  class="btn btn-danger flex-grow-1 m-l-xxs">HAPUS PRESENSI</button>
				   </div>
				  </form>
					
				</div>
			</div>
		</div>
	</div>                            	
</div>


<script>
$('#formabsen').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'hapus.php',
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
		}, 500);
			}
		});
	return false;
	});
</script>	
