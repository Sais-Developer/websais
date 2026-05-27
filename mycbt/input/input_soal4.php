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
    SELECT b.*, m.*
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
$jumsoal = (int)($rowJum['total'] ?? 0);
?>
<?php include"bank/radio.php"; ?>
<style>
  .form-container {
      display: none; /* All forms hidden by default */
    }
.kanane{
    float: right;
    display: block;
	margin-top:0px;
	
	  }
</style> 
 <div class="row"> 
    <form id='formsoal' action='' method='post' enctype='multipart/form-data'>
	 <input type='hidden' name='mapel' id="idbank" value='<?= $id_bank ?>'>
		<input type='hidden' name='jenis' value='<?= $jenis ?>'>
		<input type='hidden' name='nomor' id="nomor" value='<?= $nomor ?>'>
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
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
					<h5 class="card-title">SOAL MENJODOHKAN</h5>
				<div class="d-flex justify-content-between align-items-center mb-1">
					<label class="fw-bold mb-0">Skor Jawaban Benar</label>
					<input type="number" name="skor" value="1" class="form-control" style="width: 150px;" required>
				</div>
				<div class='form-group'>
					<textarea id='editor2' name='isi_soal' class='editor1'  style='width:100%;' required><?= $soal['soal'] ?></textarea>
					</div>		
					<div class='col-md-12'>						
						<div class='form-group'>
							<label>Gambar / Audio</label>
								<input type='file' class='form-control' name='file' type='file'>
									
								</div>
							</div>						
						</div>	
					</div>	
				</div>
			</div>	
			<div class='row'>
				<div class="col-md-6">
					<div class="card">
						 <div class="card-header" id="row1-5-1">
						<div class="form-group d-flex justify-content-between align-items-center"
							onclick="pilih1('5','1','#00BCD4','1')">
						<span>PERNYATAAN 1</span>
						<label class="checkbox d-flex align-items-center mb-0">
								<input type="radio" name="rp1" id="P51" value="#00BCD4" onclick="PR51()" required>
								<span class="check ms-1"></span> 
								<span class="ms-1">1</span>
							</label>
						</div>
					</div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilA' rows="3" class='editor1 pilihan form-control'></textarea>                                   
					</div>
					<div class='form-group'>
							<label>Gambar / Audio Pil A</label>
							<input type='file' name='fileA' class='form-control' />
						</div>   
				    </div>	
		        </div>
	        </div>
    <div class="col-md-6">
		<div class="card">
			<div class="card-header" id="row2-5-1">
				<div class='form-group mb-0' onCLick="pilih2('5','1',2,'1','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj1" value="A" id="J51" onclick="JW51()"> 
						<span class="check"></span> A</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
					</div>
                   <div class="card-body"> 
						<div class='form-group mb-4'>
							<textarea name='perA' rows="5" class='editor1 pilihan form-control'></textarea>
						</div> 
                      <div class="form-group d-flex justify-content-end">
					<button id="A" type="button" class="btn btn-sm btn-icon btn-success me-2" 
					data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Form">
						<i class="material-icons">add</i>
					</button>
					<button type="button" onclick="haper()" class="btn btn-sm btn-icon btn-danger" 
					data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Jawaban">
						<i class="material-icons">delete</i> Reset
					</button>
				</div>
			 </div>						
			</div>
		</div>						
	</div>	
		
		<div class="form-container" id="formB">				
			<div class='row'>
				<div class="col-md-6">
					<div class="card">
						 <div class="card-header" id="row1-5-2">
						 <div class='form-group'   onClick="pilih1('5','2','#F44336','2')">PERNYATAAN 2
						<label class="checkbox kanane"><input type="radio" name="rp2" value="#F44336" id="P52"  onclick="PR52()">
						<span class="check"></span> 2</label>
							</div>
						  </div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilB' class='editor1 pilihan form-control' style="height:100px"></textarea>                                   
					</div>
					<div class='form-group'>
							<label>Gambar / Audio Pil B</label>
							<input type='file' name='fileB' class='form-control' />
						</div>  
				</div>
			</div>
		</div>
                <div class="col-md-6">
					<div class="card">
						<div class="card-header" id="row2-5-2">
						  <div class='form-group' onCLick="pilih2('5','2',2,'2','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj2" value="B" id="J52" onclick="JW52()"> 
						<span class="check"></span> B</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 
						<div class='form-group mb-4'>
							<textarea name='perB' class='editor1 pilihan form-control' style="height:140px"></textarea>
						</div>
						 <div class="form-group d-flex justify-content-end">
						<button id="B" type="button" class="btn btn-sm btn-icon btn-success me-2"
						data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Form">
						<i class="material-icons">add</i>
						</button>										
						<button id="Btutup" type="button" class="btn btn-sm btn-icon btn-danger" >
						<i class="material-icons">close</i>
						</button>							
					</div>                     
					</div>
				</div>						
			</div>	
		</div>
	</div>


	<div class="form-container" id="formC">				
			<div class='row'>
				<div class="col-md-6">
					<div class="card">
						 <div class="card-header" id="row1-5-3">
						 <div class='form-group mb-2' onClick="pilih1('5','3','#4CAF50','3')">PERNYATAAN 3
						<label class="checkbox kanane"><input type="radio" name="rp3" value="#4CAF50" id="P53"  onclick="PR53()">
						<span class="check"></span> 3</label>
							</div>
						  </div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilC' class='editor1 pilihan form-control' style="height:100px"></textarea>                                   
					</div>
					<div class='form-group mb-0'>
							<label>Gambar / Audio Pil C</label>
							<input type='file' name='fileC' class='form-control' />
						</div>  
					</div>
				</div>
			</div>
                <div class="col-md-6">
					<div class="card">
						<div class="card-header" id="row2-5-3">
						  <div class='form-group' onCLick="pilih2('5','3',2,'3','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj3" value="C" id="J53" onclick="JW53()"> 
						<span class="check"></span> C</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 
						<div class='form-group mb-4'>
							<textarea name='perC' class='editor1 pilihan form-control' style="height:140px"></textarea>
						</div>
						<div class="form-group d-flex justify-content-end">
						<button id="C" type="button" class="btn btn-sm btn-icon btn-success me-2"
						data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Form">
						<i class="material-icons">add</i>
						</button>										
						<button id="Ctutup" type="button" class="btn btn-sm btn-icon btn-danger" >
						<i class="material-icons">close</i> 
						</button>							
					</div>                         
					</div>
				</div>						
			</div>	
		</div>
	</div>

	<div class="form-container" id="formD">				
			<div class='row'>
				<div class="col-md-6">
					<div class="card">
						 <div class="card-header" id="row1-5-4">
						 <div class='form-group mb-2' onClick="pilih1('5','4','#FF9800','4')">PERNYATAAN 4
						<label class="checkbox kanane"><input type="radio" name="rp4" value="#FF9800" id="P54"  onclick="PR54()">
						<span class="check"></span> 4</label>
							</div>
						  </div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilD'  class='editor1 pilihan form-control' style="height:100px"></textarea>                                   
					</div>
					<div class='form-group mb-0'>
							<label>Gambar / Audio Pil D</label>
							<input type='file' name='fileD' class='form-control' />
						</div>  
					
				</div>
			</div>
		</div>
                <div class="col-md-6">
					<div class="card">
						<div class="card-header" id="row2-5-4">
						  <div class='form-group mb-0' onCLick="pilih2('5','4',2,'4','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj4" value="D" id="J54" onclick="JW54()"> 
						<span class="check"></span> D</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 
						<div class='form-group mb-4'>
							<textarea name='perD' class='editor1 pilihan form-control' style="height:140px"></textarea>
						</div>
						 <div class="form-group d-flex justify-content-end">
						<button id="D" type="button" class="btn btn-sm btn-icon btn-success me-2"
						data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Form">
						<i class="material-icons">add</i></button>										
						<button id="Dtutup" type="button" class="btn btn-sm btn-icon btn-danger" >
						<i class="material-icons">close</i> </button>							
					</div>                        
					</div>
				</div>						
			</div>	
		</div>
	</div>

	<div class="form-container" id="formE">				
			<div class='row'>
				<div class="col-md-6">
					<div class="card">
						 <div class="card-header" id="row1-5-5">
						 <div class='form-group' onClick="pilih1('5','5','#0277BD','5')">PERNYATAAN 5
						<label class="checkbox kanane"><input type="radio" name="rp5" value="#0277BD" id="P55"  onclick="PR55()">
						<span class="check"></span> 5</label>
							</div>
						  </div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilE'  class='editor1 pilihan form-control' style="height:100px"></textarea>                                   
					</div>
					<div class='form-group mb-0'>
							<label>Gambar / Audio Pil E</label>
							<input type='file' name='fileE' class='form-control' />
						</div>    
					
				</div>
			</div>
		</div>
                <div class="col-md-6">
					<div class="card">
						<div class="card-header" id="row2-5-5">
						  <div class='form-group mb-0' onCLick="pilih2('5','5',2,'4','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj5" value="E" id="J55" onclick="JW55()"> 
						<span class="check"></span> E</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 					
						<div class='form-group mb-4'>
							<textarea name='perE' class='editor1 pilihan form-control' style="height:140px"></textarea>
						</div>
						 <div class="form-group d-flex justify-content-end">
						<button  class="btn btn-sm btn-icon btn-light me-2" disabled><i class="material-icons">add</i></button>										
						<button id="Etutup" type="button" class="btn btn-sm btn-icon btn-danger" ><i class="material-icons">close</i> </button>							
					</div>                      
					</div>
				</div>						
			</div>	
		</div>
</form>			
</div>
<script>
	function PR51() {

	var warna = $('#P51').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=JDH1',
	data: 'warna=' + warna + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>
<script>
	function JW51() {

	var jawab = $('#J51').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=UPJDH1',
	data: 'jawab=' + jawab + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>	
<script>
	function PR52() {

	var warna = $('#P52').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=JDH2',
	data: 'warna=' + warna + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>

<script>
	function JW52() {
		
	var jawab = $('#J52').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=UPJDH1',
	data: 'jawab=' + jawab + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>
<script>
	function PR53() {

	var warna = $('#P53').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=JDH3',
	data: 'warna=' + warna + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>	
<script>
	function JW53() {
		
	var jawab = $('#J53').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=UPJDH1',
	data: 'jawab=' + jawab + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>
<script>
	function PR54() {

	var warna = $('#P54').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=JDH4',
	data: 'warna=' + warna + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>

<script>
	function JW54() {
		
	var jawab = $('#J54').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=UPJDH1',
	data: 'jawab=' + jawab + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>	
<script>
	function PR55() {

	var warna = $('#P55').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=JDH5',
	data: 'warna=' + warna + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>

<script>
	function JW55() {
		
	var jawab = $('#J55').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=UPJDH1',
	data: 'jawab=' + jawab + "&idbank=" + idbank + "&nomor=" + nomor,
	success: function(response) {
					 
	}
	});
	}
</script>					
 <script>
$("#A").click(function() {$("#formB").show(); });
$("#Btutup").click(function() {$("#formB").hide();}); 
$("#B").click(function() {$("#formC").show(); });
$("#Ctutup").click(function() {$("#formC").hide();}); 
$("#C").click(function() {$("#formD").show(); });
$("#Dtutup").click(function() {$("#formD").hide();});
$("#D").click(function() {$("#formE").show(); });
$("#Etutup").click(function() {$("#formE").hide();});  
</script>					
<script>
function haper() {
  document.getElementById("P51").checked = false;
  document.getElementById("J51").checked = false; 
  document.getElementById("row1-5-1").style.backgroundColor = 'white';
  document.getElementById("row2-5-1").style.backgroundColor = 'white';
 
  document.getElementById("P52").checked = false;
  document.getElementById("J52").checked = false; 
  document.getElementById("row1-5-2").style.backgroundColor = 'white';
  document.getElementById("row2-5-2").style.backgroundColor = 'white';
  
  document.getElementById("P53").checked = false;
  document.getElementById("J53").checked = false; 
  document.getElementById("row1-5-3").style.backgroundColor = 'white';
  document.getElementById("row2-5-3").style.backgroundColor = 'white';
  
  document.getElementById("P54").checked = false;
  document.getElementById("J54").checked = false; 
  document.getElementById("row1-5-4").style.backgroundColor = 'white';
  document.getElementById("row2-5-4").style.backgroundColor = 'white';
  
  document.getElementById("P55").checked = false;
  document.getElementById("J55").checked = false; 
  document.getElementById("row1-5-5").style.backgroundColor = 'white';
  document.getElementById("row2-5-5").style.backgroundColor = 'white';
var idbank = $('#idbank').val();
var nomor = $('#nomor').val();
$.ajax({
	type: 'POST',
	url: '<?= $baseurl ?>/mycbt/bank/tjodoh.php?pg=RESET',
	data: 'idbank=' + idbank + "&nomor=" + nomor,
	success: function(response) {
						 
	}
	});
}
</script>
		
	  


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
<script>
	
			var left = '';
			eval('var right_5' + '= "";');
			eval('var warna1_5' + '= "";');
			eval('var id1_5' + '= "";');
			eval('var pos1_5' + '= "";');
			eval('var pos11_5' + '= "";');
			eval('var dipilih1_5' + '= [];');
			eval('var dipilih2_5' + '= [];');
			eval('var order1_5' + '= "";');
			eval('var free1_5' + '= true;');
			eval('var free_5' + '= true;');
			
			
	function pilih1(no, id, warna, order) {
		
			if (window['free1_'+no]) {
				window['free1_'+no] = true;
				
				$('#row1-'+no+'-'+id).css('background',warna);
				window['pos1_'+no] = $('#r_left_'+no+'_'+id).offset();
				window['pos11_'+no] = $('#r_left_'+no+'_'+id).position();
				window['warna1_'+no] = warna;
				window['id1_'+no] = id;
				window['order1_'+no] = order;
				window['dipilih1_'+no].push(id);
				
			}	
	}
	
	function pilih2(no, id,tipe,order,s, ps) {
	$('#row2-'+no+'-'+id).css('background',window['warna1_'+no]);
	$('#r_right_'+no+'_'+id).val(window['id1_'+no]+';'+id);
	}
	
</script>
