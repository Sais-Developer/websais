<?php
$idb = $_GET['id'] ?? '';

$stmtBank = $pdo->prepare("SELECT * FROM banksoal WHERE id_bank = :id_bank");
$stmtBank->bindValue(':id_bank', $idb, PDO::PARAM_INT);
$stmtBank->execute();
$bank = $stmtBank->fetch(PDO::FETCH_ASSOC);

$stmtMapel = $pdo->prepare("SELECT * FROM mapel WHERE id = :id");
$stmtMapel->bindValue(':id', $bank['idmapel'], PDO::PARAM_INT);
$stmtMapel->execute();
$mapel = $stmtMapel->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">
     <div class="col-md-8">
        <div class="card">
          <div class="card-header">
			 <h5 class="card-title">IMPORT WORD</h5>
			</div>
		 <div class="card-body">
			<form id="form-import" enctype="multipart/form-data">
				<div class="col-md-12 mb-3">
					<label class="bold">Mata Pelajaran</label>
					<input type="text" class="form-control" value="<?= $mapel['nama_mapel'] ?>" readonly style="background-color:#fff">
					</div>
					<div class="row">
					<div class="col-md-6 mb-3">
					  <label class="bold">Kode Bank</label>
					  <input type="text" class="form-control" value="<?= $bank['kode'] ?>" readonly style="background-color:#fff">
					</div>
					
					<div class="col-md-6 mb-4">
					  <label class="bold">Pilih file Word (.docx)</label>
					   <input type="hidden" name="id_bank" value="<?= $idb ?>" required>
					   <input type="file" name="file" class="form-control" accept=".docx" required>
					 </div>
					</div>
					<div class="d-flex justify-content-between align-items-center">
					<a href="../mycbt/bank/FORMAT_SOAL.docx" class="btn btn-link">
						<i class="material-icons">download</i> Format 5 Jenis Soal
					</a>
					<button type="submit" class="btn btn-primary">
						<i class="material-icons">upload</i> Import
					</button>
				   </div>			
				</form>
              </div>
			</div>
		</div>
		<div class="col-md-4">
        <div class="card bg-sandik">
          <div class="card-header bg-sandik">
			 <h5 class="card-title">FORMAT SOAL</h5>
			</div>
		 <div class="card-body">
		 1. [JENIS : PG]<br>
		 Pertanyaan:<br>
		 .........................
		 <br>insert gambar kalu ada gambar
		 <br>A. ...............
		 <br>insert gambar kalau ada gambar
		 <br>B. ...............
		 <br>insert gambar kalau ada gambar
		 <br>C. ...............
		 <br>insert gambar kalau ada gambar
		 <br>D. ...............
		 <br>insert gambar kalau ada gambar
		 <br>E. ...............
		 <br>insert gambar kalau ada gambar
		 <br>Jawaban: B
		 <br> <br>
		  2. [JENIS : MULTI]<br>
		 Pertanyaan:<br>
		 .........................
		 <br>insert gambar kalu ada gambar
		 <br>A. ...............
		 <br>insert gambar kalau ada gambar
		 <br>B. ...............
		 <br>insert gambar kalau ada gambar
		 <br>C. ...............
		 <br>insert gambar kalau ada gambar
		 <br>D. ...............
		 <br>insert gambar kalau ada gambar
		 <br>E. ...............
		 <br>insert gambar kalau ada gambar
		 <br>Jawaban: B,D,E
		  <br> <br>
		  3. [JENIS : BS]<br>
		 Pertanyaan:<br>
		 .........................
		 <br>insert gambar kalu ada gambar
		 <br>A. ...............
		 <br>insert gambar kalau ada gambar
		 <br>B. ...............
		 <br>insert gambar kalau ada gambar
		 <br>C. ...............
		 <br>insert gambar kalau ada gambar
		 <br>D. ...............
		 <br>insert gambar kalau ada gambar
		 <br>E. ...............
		 <br>insert gambar kalau ada gambar
		 <br>Jawaban: B,B,S,B,S
		  <br> <br>
		  4. [JENIS : JODOH]<br>
		 Pertanyaan:<br>
		 .........................
		 <br>insert gambar kalu ada gambar
		 <br>1. ............... #A. ........
		 <br>insert gambar kalau ada gambar
		 <br>2. ............... #B. ........
		 <br>insert gambar kalau ada gambar
		 <br>3. ............... #C. .......
		 <br>insert gambar kalau ada gambar
		 <br>4. ............... #D. .......
		 <br>insert gambar kalau ada gambar
		 <br>5. ............... #E. ......
		 <br>insert gambar kalau ada gambar
		 <br>Jawaban: D,A,E,C,B
		 <br> <br>
		  5. [JENIS : ESAI]<br>
		 Pertanyaan:<br>
		 .........................
		 <br>insert gambar kalu ada gambar
		  <br>Jawaban: ............
		           </div>
				 </div>
				</div>
			</div>
			
<script>
    $('#form-import').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'bank/tupload.php',
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
						window.location.replace("?pg=<?= enkripsi('banksoal') ?>&ac=lihat&id=<?= $idb ?>");
						}, 200);
									  
						}
					});
				return false;
			});
		</script>	
          				   