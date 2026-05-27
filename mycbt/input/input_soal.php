<?php
if (!isset($_GET['id'], $_GET['jenis'])) {
    die('No Access');
}

$id_bank = $_GET['id'];
$nomor   = (int) ($_GET['no'] ?? 0);
$jenis   = $_GET['jenis'];

$stmtNom = $pdo->prepare("SELECT MAX(nomor) AS nomer FROM soal WHERE id_bank = :id_bank");
$stmtNom->execute([':id_bank' => $id_bank]);
$nom = $stmtNom->fetch(PDO::FETCH_ASSOC);

$nomor = ($nom['nomer'] ?? 0) + 1;

$stmtMapel = $pdo->prepare("
    SELECT * 
    FROM banksoal b 
    JOIN mapel m ON m.id = b.idmapel 
    WHERE b.id_bank = :id_bank
");
$stmtMapel->execute([':id_bank' => $id_bank]);
$mapel = $stmtMapel->fetch(PDO::FETCH_ASSOC);

$stmtJum = $pdo->prepare("
    SELECT COUNT(*) AS total 
    FROM soal 
    WHERE id_bank = :id_bank AND nomor = :nomor AND jenis = :jenis
");
$stmtJum->execute([
    ':id_bank' => $id_bank,
    ':nomor'   => $nomor,
    ':jenis'   => $jenis
]);
$rowJum = $stmtJum->fetch(PDO::FETCH_ASSOC);
$jumsoal = $rowJum['total'] ?? 0;
?>

<?php include"bank/radio.php"; ?>
 <div class="row"> 
     <form id='formsoal' action='' method='post' enctype='multipart/form-data'>
	    <input type='hidden' name='mapel' value='<?= $id_bank ?>'>
		<input type='hidden' name='jenis' value='<?= $jenis ?>'>
		<input type='hidden' name='nomor' value='<?= $nomor ?>'>
        <div class="col-md-12">
           
              <div class="card-header d-flex justify-content-between align-items-center mb-3">
				<div class="d-flex align-items-center gap-1">
					<label class='btn btn-sm btn-primary'><?= $mapel['kode'] ?> </label>
					<label class='btn btn-sm btn-success'>No Soal :<b class="sandik"> <?= $nomor ?></b></label>					
					</div>
                <div class="d-flex align-items-center gap-2">					
                    <button type='submit' name='simpansoal' onclick="tinyMCE.triggerSave(true,true);" class='btn btn-sm btn-primary'> Simpan</button>
					<a href='?pg=<?= enkripsi('banksoal') ?>&ac=lihat&id=<?= $id_bank ?>' class='btn btn-sm btn-danger'> Kembali</a>
					
				</div>
			</div>
		</div>										
 <div class='row'>
	<div class="col-md-6">
		<div class="card">
		<div class="card-header">
			<h5 class="card-title">
            SOAL <?php if($jenis=='1'){ ?>PG<?php } ?>
			<?php if($jenis=='2'){ ?>URAIAN SINGKAT<?php } ?>
			</h5>
        </div>
    <div class="card-body">
		<textarea id='editor2' name='isi_soal' class='editor1' rows='10' cols='90' style='width:100%;' required></textarea>
		 <div class='col-md-12'>						
			 <div class='form-group'>									
			    <label>Gambar / Audio</label>
				<input type='file' class='form-control' name='file' type='file'>										
				</div>
			</div>						
		</div>	
	</div>	
</div>	
<?php if ($jenis == '5') : ?>
<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">KUNCI JAWABAN DAN SKOR</h5>
				</div>
			<div class="card-body">
					<div class="row mb-1">
						<label  class="col-md-8 col-form-label">Skor Maximal</label>
					<div class="col-md-4">
						<input type='number' name='skor' value="5" class='form-control' required="true" />
						</div>
					</div>				  
				<div class='form-group'>
				    <textarea id='jawabesai' name='pilA' rows='10' cols='80' class='form-control' required ><?= $soal['pilA'] ?></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
     <?php endif; ?> 
		<?php if ($jenis == '1') : ?>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">OPSI DAN KUNCI JAWABAN </h5>
						</div>
					<div class="card-body">
						<div class="row mb-1">
							<label  class="col-md-8 col-form-label">Skor Maximal</label>
						<div class="col-md-4">
							<input type='number' name='skor' value="1" class='form-control' required="true" />
						</div>
					</div>	
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="pills-A-tab" data-bs-toggle="pill" data-bs-target="#pills-A" type="button" role="tab" aria-controls="pills-A" aria-selected="true">A</button>
							</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="pills-B-tab" data-bs-toggle="pill" data-bs-target="#pills-B" type="button" role="tab" aria-controls="pills-B" aria-selected="false">B</button>
							 </li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="pills-C-tab" data-bs-toggle="pill" data-bs-target="#pills-C" type="button" role="tab" aria-controls="pills-C" aria-selected="false">C</button>
							 </li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="pills-D-tab" data-bs-toggle="pill" data-bs-target="#pills-D" type="button" role="tab" aria-controls="pills-D" aria-selected="false">D</button>
							</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="pills-E-tab" data-bs-toggle="pill" data-bs-target="#pills-E" type="button" role="tab" aria-controls="pills-E" aria-selected="false">E</button>
							</li> 
					</ul>
					<div class="tab-content" id="pills-tabContent">
						 <div class="tab-pane fade active show" id="pills-A" role="tabpanel" aria-labelledby="pills-A-tab">
						  <div class="d-flex justify-content-between align-items-center mb-2">
							<a class="btn btn-sm btn-outline-secondary">JAWABAN A</a>                                           
							  <label class="radio  d-flex align-items-center" style="margin-top:-25px">
							  <input type='radio' name='jawaban' value='A' required='true' >
									<span class="check"></span></label> 
								</div>
							<div class='form-group'>
								<textarea name='pilA'  class='editor1 pilihan form-control'></textarea>
							</div>
							<div class='form-group'>
								<label>Gambar / Audio Pil A</label>
								<input type='file' name='fileA' class='form-control' />
							</div>  
					  </div>

				   <div class="tab-pane fade" id="pills-B" role="tabpanel" aria-labelledby="pills-B-tab">
					   <div class="d-flex justify-content-between align-items-center mb-2">
						  <a class="btn btn-sm btn-outline-secondary">JAWABAN B</a>                                           
							<label class="radio  d-flex align-items-center" style="margin-top:-25px">
							   <input type='radio' name='jawaban' value='B' required='true'> 
									 <span class="check"></span></label>
								</div>
						<div class='form-group'>
							<textarea name='pilB' class='editor1 pilihan form-control'></textarea>
								</div>
						<div class='form-group'>												
							<label>Gambar / Audio Pil B</label>
								<input type='file' name='fileB' class='form-control' />														
							</div>
						</div> 
								
					<div class="tab-pane fade" id="pills-C" role="tabpanel" aria-labelledby="pills-C-tab">
					   <div class="d-flex justify-content-between align-items-center mb-2">
							<a class="btn btn-sm btn-outline-secondary">JAWABAN C</a>                                           
								<label class="radio  d-flex align-items-center" style="margin-top:-25px">
								 <input type='radio' name='jawaban' value='C' required='true' >
							  <span class="check"></span></label>
							</div>
						<div class='form-group'>
							 <textarea name='pilC' class='editor1 pilihan form-control'></textarea>
								</div>
						<div class='form-group'>
							<label>Gambar / Audio Pil C</label>
								<input type='file' name='fileC' class='form-control' />
							</div>    	
						</div>
						
					<div class="tab-pane fade" id="pills-D" role="tabpanel" aria-labelledby="pills-D-tab">
					  <div class="d-flex justify-content-between align-items-center mb-2">
					   <a class="btn btn-sm btn-outline-secondary">JAWABAN D</a>                                           
							<label class="radio  d-flex align-items-center" style="margin-top:-25px">
							  <input type='radio' name='jawaban' value='D' required='true'> 
							  <span class="check"></span></label>
							</div>
						<div class='form-group'>
							<textarea name='pilD' class='editor1 pilihan form-control'></textarea>
							</div>
						<div class='form-group'>
							<label>Gambar / Audio Pil D</label>
								<input type='file' name='fileD' class='form-control' />
							</div>
						</div>
								   
					<div class="tab-pane fade" id="pills-E" role="tabpanel" aria-labelledby="pills-E-tab">
						<div class="d-flex justify-content-between align-items-center mb-2">  
						  <a class="btn btn-sm btn-outline-secondary">JAWABAN E</a>                                           
							 <label class="radio  d-flex align-items-center" style="margin-top:-25px">
								<input type='radio' name='jawaban' value='E' required='true' > 
								 <span class="check"></span></label>
							 </div>
						<div class='form-group'>
							<textarea name='pilE' class='editor1 pilihan form-control'></textarea>
						   </div>
						<div class='form-group'>												
							<label>Gambar / Audio Pil E</label>
							   <input type='file' name='fileE' class='form-control' />
							</div>
						</div>
					</div>
					<?php endif; ?>						               
				</div>
			</div>
		</div>
	</form>
</div>				
<script>
	tinymce.init({
		selector: '.editor1',
		
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
		],

		toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
		fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
		paste_data_images: true,

		images_upload_handler: function(blobInfo, success, failure) {
			success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
		},
		image_class_list: [{
			title: 'Responsive',
			value: 'img-responsive'
		}],
	});
</script>

