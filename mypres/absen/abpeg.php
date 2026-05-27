<?php
defined('APK') or exit('No Access');
?> 
<style>
.table-wrapper {
    overflow: auto;
}

.text-center {
    text-align: center;
}

.table-siswa, .table-date {
    border-collapse: collapse;
    width: 100%;
    margin: 0;
    padding: 0;
}

.table-siswa td {
    border: 1px solid silver;
    position: relative;
    padding: 5px;
}

/* Kotak radio custom */
.label-checkbox {
    position: relative;
    display: block;
    width: 100%;
    height: 30px;
    background: #cecece;
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
}

.label-checkbox input {
    display: none; /* sembunyikan radio asli */
}

.label-checkbox:hover {
    background: #bff8ff;
}

.label-checkbox input:checked + .checkmark {
    background-color: #2196F3;
    color: #fff;
}

.checkmark {
    position: absolute;
    top: 0; left: 0;
    right: 0; bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: transparent;
    border-radius: 4px;
}

.label-checkbox input:checked + .checkmark::before {
    content: "✔";
    color: #fff;
    font-size: 16px;
}
</style>               
<div class="row">
  <div class="col-xl-8">
     <div class="card">
       <div class="card card-header">
         <h5 class="card-title bold">INPUT MANUAL</h5>
     </div>
	<div class="card-body">
	  <form id="formabsen">
		<div class="table-wrapper">
		   <table class="table-siswa">
				<thead>
				<tr>
				<td width="10%" class="text-center bold">NO</td>
				<td class="text-center bold">N I P</td>
				<td class="text-center bold">NAMA LENGKAP</td>
				<td class="text-center bold">JABATAN</td>
				<td width="6%" class="text-center bold">S</td>  
				<td width="6%" class="text-center bold">I</td>  
				<td width="6%" class="text-center bold">A</td>  
				</tr>
				</thead>
				<tbody>
				<?php
				$no = 0;
				$tanggal = date('Y-m-d'); 
				$jabatan = $_GET['jabatan'] ?? '';

				$sql = "SELECT * FROM guru g
						WHERE g.jabatan = :jabatan
						AND NOT EXISTS (
							SELECT 1 FROM absensi a
							WHERE a.idpeg = g.id_guru
							AND a.tanggal = :tanggal
						)";
				$stmt = $db->prepare($sql);
				$stmt->execute([
					':jabatan' => $jabatan,
					':tanggal' => $tanggal
				]);

				while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
					$no++;
				?>
				<tr>
					<input type="hidden" name="tanggal[]" value="<?= htmlspecialchars($tanggal) ?>">												
					<input type="hidden" name="level[]" value="pegawai">
					<input type="hidden" name="bulan[]" value="<?= date('m') ?>">
					<input type="hidden" name="tahun[]" value="<?= date('Y') ?>">
					
					<td><?= $no ?> <input type="checkbox" name="idguru[]" value="<?= $data['id_guru'] ?>"></td>                                  
					<td><?= htmlspecialchars($data['nip']) ?></td>
					<td><?= htmlspecialchars($data['nama']) ?></td>
					<td><?= htmlspecialchars($data['jabatan']) ?></td>							
					<td>
						<label class="label-checkbox">
							<input type="radio" name="ket[<?= $data['id_guru'] ?>]" value="S">
							<span class="checkmark"></span>
						</label>
					</td>
					<td>
						<label class="label-checkbox">
							<input type="radio" name="ket[<?= $data['id_guru'] ?>]" value="I">
							<span class="checkmark"></span>
						</label>
					</td>
					<td>
						<label class="label-checkbox">
							<input type="radio" name="ket[<?= $data['id_guru'] ?>]" value="A">
							<span class="checkmark"></span>
						</label>
					</td>
				</tr>
				<?php endwhile; ?>
			  </tbody>
			</table>
			<div class="mb-3"></div>
			<?php if($jabatan<>''): ?>
			<div class="d-flex justify-content-end align-items-center">
			<button type="submit" class="btn btn-primary">SIMPAN</button>
			</div>
			<?php endif; ?>
			</div>
		</form>
	</div>
  </div>
</div>
<div class="col-md-4">
  <div class="card">
  <div class="card-body">
	<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-0">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	     <div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div>
           <div class="widget-payment-request-info m-t-md"> 	
			<div class="col-md-12 mb-4">  
			<label class="bold">JABATAN</label>                               
			  <select class="form-select jabatan" name="jabatan">
					<option value=''>Pilih Jabatan</option>
					<?php
					$stmt = $db->prepare("SELECT DISTINCT jabatan FROM guru WHERE jabatan != '' ORDER BY jabatan ASC");
					$stmt->execute();
					$jabatanTerpilih = $jabatan ?? ''; 
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$selected = ($jabatanTerpilih == $row['jabatan']) ? 'selected' : '';
					?>
						<option value="<?= htmlspecialchars($row['jabatan']) ?>" <?= $selected ?>>
							<?= strtoupper(htmlspecialchars($row['jabatan'])) ?>
						</option>
					<?php endwhile; ?>
				</select>									                                               
					</div>                                               
			   <div class="d-grid gap-2 mb-4">																								
			  <button id="pilih"  class="btn btn-primary kanan">PILIH</button>
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
		</div>
<script type="text/javascript">
$('#pilih').click(function() {
var jabatan = $('.jabatan').val();
location.replace("?pg=<?= enkripsi('abpeg') ?>&jabatan=" + jabatan);
}); 
</script>
<script>
$('#formabsen').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'absen/inputpeg.php',
	data: data,
	cache: false,
	contentType: false,
	processData: false,
	beforeSend: function() {
	$('#progressbox').html('<div><img src="<?= $baseurl ?>/images/animasi.gif" style="width:50px;"></div>');
	
	},
						
	success: function(data){   		
	setTimeout(function()
		{
		window.location.replace('?pg=<?=enkripsi("prespeg") ?>');
				}, 2000);
							  
				}
			});
		return false;
	});
</script>	

<script>
$(document).ready(function(){

  var tableDate = "";
  var tableContent =  "";
  var $td =  "";
  for(var i=1; i<=3; i++){
		tableDate += "<td class='td-date text-center'><b class='date'>"+ i +"</b></td>";
	}
	
  $( tableDate ).prependTo( ".table-row-head" );
	
  for(var i=1; i<=3; i++){
		tableContent += "<td class='text-center' data-date='"+ i +"'>"+ $label +"</td>";
  }
 
  $( tableContent ).appendTo( ".table-body-content tr" );
	
  for(var td=1; td<=2; td++){
		$td += "<td class='text-center' data-info='"+ td +"'</td>";
  }
  
  $( document ).on( "change", ".label-checkbox", function(){
	$( this ).toggleClass( "active" );
	checkData();
  });
	
	
});

function checkData(){
  $( ".label-checkbox" ).each(function(){
	var $parents  = $( this ).parents( "tr" );
	var $checked      = $parents.find( "input:checked" ).length;
	var $no_checked   = $parents.find( "input" ).length;
	var $true = $checked;
	var $false = [ $no_checked - $checked];
  
	$parents.find( "[data-info='1']" ).html( $true );
	$parents.find( "[data-info='2']" ).html( $false );   
  });
}

$( document ).ready(function(){
  checkData();
});

</script>