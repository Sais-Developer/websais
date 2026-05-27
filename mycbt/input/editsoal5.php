<?php
defined('APK') or exit('No Access');

$id_soal = $_GET['id_soal'] ?? '';

$stmtSoal = $pdo->prepare("SELECT * FROM soal WHERE id_soal = :id_soal");
$stmtSoal->execute([':id_soal' => $id_soal]);
$nomor = $stmtSoal->fetch(PDO::FETCH_ASSOC);

$stmtMapel = $pdo->prepare("
    SELECT b.*, m.kode 
    FROM banksoal b 
    LEFT JOIN mapel m ON m.id = b.idmapel 
    WHERE b.id_bank = :id_bank
");
$stmtMapel->execute([':id_bank' => $nomor['id_bank']]);
$mapel = $stmtMapel->fetch(PDO::FETCH_ASSOC);

$stmtCount = $pdo->prepare("
    SELECT COUNT(*) AS total 
    FROM soal 
    WHERE id_bank = :id_bank AND nomor = :nomor AND jenis = 5
");
$stmtCount->execute([':id_bank' => $mapel['id_bank'], ':nomor' => $nomor['nomor']]);
$jumsoal = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

$stmtSoal2 = $pdo->prepare("SELECT * FROM soal WHERE id_soal = :id_soal");
$stmtSoal2->execute([':id_soal' => $id_soal]);
$soal = $stmtSoal2->fetch(PDO::FETCH_ASSOC);

$checked = explode(',', $soal['jawaban'] ?? '');
$warna = explode(',', $soal['warna'] ?? '');
$jml_data = count($checked);

$stmtCek = $pdo->prepare("SELECT COUNT(*) as cnt FROM menjodohkan WHERE idbank = :id_bank AND nomor = :nomor");
$stmtCek->execute([':id_bank' => $nomor['id_bank'], ':nomor' => $nomor['nomor']]);
$jikaada = $stmtCek->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0;

if ($jikaada == 0) {
    $stmtInsert = $pdo->prepare("
        INSERT INTO menjodohkan (idbank, kode, nomor, jawab, warna)
        VALUES (:idbank, :kode, :nomor, :jawab, :warna)
    ");

    for ($i = 0; $i < $jml_data; $i++) {
        $kode = "5." . ($i + 1) . "." . $nomor['id_bank'];
        $stmtInsert->execute([
            ':idbank' => $nomor['id_bank'],
            ':kode'   => $kode,
            ':nomor'  => $nomor['nomor'],
            ':jawab'  => $checked[$i],
            ':warna'  => $warna[$i] ?? ''
        ]);
    }
}
?>
<?php include"bank/radio.php"; ?>
<style>
  
.kanane{
    float: right;
    display: block;
	margin-top:0px;
	
	  }
</style> 
<?php if ($ac == '') : ?>
 <div class="row"> 
	<form id='formsoal' action='' method='post' enctype='multipart/form-data'>
	    <input type='hidden' name='idsoal' value='<?= $_GET['id_soal'] ?>'>
		<input type='hidden' name='mapel' id="idbank" value='<?= $nomor['id_bank'] ?>'>
		<input type='hidden' name='jenis' value='<?= $nomor['jenis'] ?>'>
		<input type='hidden' name='nomor' id="nomor" value='<?= $nomor['nomor'] ?>'>
		<div class="col-md-12">
           <div class="card-header d-flex justify-content-between align-items-center mb-3">
				    <div class="d-flex align-items-center gap-1">
						<label class='btn btn-sm btn-primary'><?= $mapel['kode'] ?> </label>
						<label class='btn btn-sm btn-danger'>No Soal :<b class="sandik"> <?= $nomor['nomor'] ?></b></label>
					</div>
                <div class="d-flex align-items-center gap-2">			
                     <button type='submit' name='simpansoal' onclick="tinyMCE.triggerSave(true,true);" class='btn btn-sm btn-primary'> Simpan</button>
						<a href='?pg=<?= enkripsi('banksoal') ?>&ac=lihat&id=<?= $mapel['id_bank'] ?>' class='btn btn-sm btn-danger'> Kembali</a>
					</div>
			    </div>
		     </div>			
	<div class='row'>
		<div class="col-md-12">
		    <div class="card">
				<div class="card-header">
				<h5 class="card-title">SOAL MENJODOHKAN</h5>
				<div class="pull-right">
				 <div class="row mb-1">
					<label  class="col-md-5 col-form-label bold">Skor Jawaban Benar</label>
						<div class="col-md-4">
							<input type='number' name='skor' value="1" class='form-control' required="true" />
						</div>
					</div>
                </div>
			</div>
            <div class="card-body">
				<div class='form-group'>
					<textarea id='editor2' name='isi_soal' class='editor1'  style='width:100%;' required><?= $soal['soal'] ?></textarea>
				</div>		

				<div class='row'>	
				    <div class='col-md-6'>						
					  <div class='form-group'>
						<?php
							$fileSoal = $soal['fileSoal'] ?? '';
							if (!empty($fileSoal)) {
								$audio = ['mp3', 'wav', 'ogg'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
								$ext = strtolower(pathinfo($fileSoal, PATHINFO_EXTENSION));

								if (in_array($ext, $image)) {
									echo "<label>Gambar</label><br />
										  <img src='{$baseurl}/files/{$fileSoal}' style='max-width:100px;' />";
								} elseif (in_array($ext, $audio)) {
									echo "<label>Audio</label><br />
										  <audio controls>
										  <source src='{$baseurl}/files/{$fileSoal}' type='audio/{$ext}'>
										  Your browser does not support audio.
										  </audio>";
								} else {
									echo "File tidak didukung!";
								}

								echo "<a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileSoal' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
							} else {
								echo "<label>Gambar / Audio</label>
									  <input type='file' class='form-control' name='file'>";
							}
							?>
						</div>				        
					</div>
					<div class="col-md-6">	
					KUNCI JAWABAN<br> 1.<?= $checked[0] ?> <?php if($soal['perB']<>''){ ?>&nbsp;&nbsp;&nbsp; 2.<?= $checked[1] ?> <?php } ?><?php if($soal['perC']<>''){ ?> &nbsp;&nbsp;&nbsp; 3.<?= $checked[2] ?><?php } ?>
					<?php if($soal['perD']<>''){ ?> &nbsp;&nbsp;&nbsp; 4.<?= $checked[3] ?><?php } ?> <?php if($soal['perE']<>''){ ?> &nbsp;&nbsp;&nbsp; 5.<?= $checked[4] ?><?php } ?>
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
						<div class='form-group mb-2'   onClick="pilih1('5','1','#00BCD4','1')">PERNYATAAN 1
						<label class="checkbox kanane"><input type="radio" name="rp1" id="P51" value="#00BCD4" onclick="PR51()" required="true" checked>
						<span class="check"></span> 1</label>
					</div>
				</div>
                  <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilA'  class='editor1 pilihan form-control' style="height:100px"><?= $soal['pilA'] ?></textarea>                                   
					</div>
					<div class='form-group mb-1'>
						<?php
							if ($soal['fileA'] <> '') {
								$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
								$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
								$ext = explode(".", $soal['fileA']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									echo "
									<label>Gambar A</label><br />
									<img src='$baseurl/files/$soal[fileA]' style='max-width:80px;' />
									";
								} elseif (in_array($ext, $audio)) {
									echo "
									<label>Audio</label><br />
									<audio controls>
										<source src='$baseurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
									";
								} else {
									echo "File tidak didukung!";
									echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileA&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
								}
								echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileA&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
							} else {
								echo "
									<label>Gambar / Audio Pil A</label>
									<input type='file' name='fileA' class='form-control' />
									";
							}
						   ?>
						</div>                       
					</div>
				</div>
			</div>
            <div class="col-md-6">
				<div class="card">
					<div class="card-header" id="row2-5-1">
						  <div class='form-group mb-1' onCLick="pilih2('5','1',2,'1','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj1" value="A" id="J51" onclick="JW51()"
				    <?php if($checked[0]=='A'){echo "checked"; } ?> <?php if($checked[1]=='A'){echo "checked"; } ?> <?php if($checked[2]=='A'){echo "checked"; } ?>
				   <?php if($checked[3]=='A'){echo "checked"; } ?> <?php if($checked[4]=='A'){echo "checked"; } ?>
				   > 
						<span class="check"></span> A</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 
					
						<div class='form-group mb-4'>
							<textarea name='perA' class='editor1 pilihan form-control'><?= $soal['perA'] ?></textarea>
						</div>
					<div class="form-group d-flex justify-content-end">
						<button id="A" type="button" class="btn btn-sm btn-icon btn-success me-2"><i class="material-icons">add</i></button>										
						<button type="button" onClick="haper()" class="btn btn-sm btn-icon btn-danger" ><i class="material-icons">delete</i> Reset</button>							
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
						 <div class='form-group mb-2'   onClick="pilih1('5','2','#F44336','2')">PERNYATAAN 2
						<label class="checkbox kanane"><input type="radio" name="rp2" value="#F44336" id="P52"  onclick="PR52()" checked>
						<span class="check"></span> 2</label>
							</div>
						  </div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilB'  class='editor1 pilihan form-control'><?= $soal['pilB'] ?></textarea>                                   
					</div>
					<div class='form-group mb-0'>
						<?php
							if ($soal['fileB'] <> '') {
								$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
								$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
								$ext = explode(".", $soal['fileB']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									echo "
									<label>Gambar A</label><br />
									<img src='$baseurl/files/$soal[fileB]' style='max-width:80px;' />
									";
								} elseif (in_array($ext, $audio)) {
									echo "
									<label>Audio</label><br />
									<audio controls>
										<source src='$baseurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
									";
								} else {
									echo "File tidak didukung!";
									echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileB&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
								}
								echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileB&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
							} else {
								echo "
									<label>Gambar / Audio Pil A</label>
									<input type='file' name='fileB' class='form-control' />
									";
							}
						   ?>	
						</div>                    
					</div>
				</div>
			</div>
            <div class="col-md-6">
			    <div class="card">
					<div class="card-header" id="row2-5-2">
						  <div class='form-group mb-0' onCLick="pilih2('5','2',2,'2','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj2" value="B" id="J52" onclick="JW52()"
				    <?php if($checked[0]=='B'){echo "checked"; } ?> <?php if($checked[1]=='B'){echo "checked"; } ?> <?php if($checked[2]=='B'){echo "checked"; } ?>
				   <?php if($checked[3]=='B'){echo "checked"; } ?> <?php if($checked[4]=='B'){echo "checked"; } ?>
				   > 
						<span class="check"></span> B</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 
					
						<div class='form-group mb-4'>
							<textarea name='perB' class='editor1 pilihan form-control'><?= $soal['perB'] ?></textarea>
						</div>
						<div class="form-group d-flex justify-content-end">
						<button id="B" type="button" class="btn btn-sm btn-icon btn-success me-2"><i class="material-icons">add</i></button>										
						<button id="Btutup" type="button" class="btn btn-sm btn-icon btn-dark" ><i class="material-icons">close</i> </button>							
					</div>       
					</div>
				</div>						
			</div>	
		</div>
	</div>

<?php if($soal['perC']<>''): ?>
	<div class="form-container" id="formC">				
			<div class='row'>
				<div class="col-md-6">
					<div class="card">
						 <div class="card-header" id="row1-5-3">
						 <div class='form-group mb-2' onClick="pilih1('5','3','#4CAF50','3')">PERNYATAAN 3
						<label class="checkbox kanane"><input type="radio" name="rp3" value="#4CAF50" id="P53"  onclick="PR53()" checked>
						<span class="check"></span> 3</label>
							</div>
						  </div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilC'  class='editor1 pilihan form-control'><?= $soal['pilC'] ?></textarea>                                   
					</div>
					<div class='form-group mb-0'>
					  <?php
							if ($soal['fileC'] <> '') {
								$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
								$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
								$ext = explode(".", $soal['fileC']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									echo "
									<label>Gambar A</label><br />
									<img src='$baseurl/files/$soal[fileC]' style='max-width:80px;' />
									";
								} elseif (in_array($ext, $audio)) {
									echo "
									<label>Audio</label><br />
									<audio controls>
										<source src='$baseurl/files/$soal[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
									";
								} else {
									echo "File tidak didukung!";
									echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileC&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
								}
								echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileC&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
							} else {
								echo "
									<label>Gambar / Audio Pil A</label>
									<input type='file' name='fileC' class='form-control' />
									";
							}
						   ?>	
						</div>                  
					</div>
				</div>
			</div>
            <div class="col-md-6">
				<div class="card">
					<div class="card-header" id="row2-5-3">
						  <div class='form-group mb-0' onCLick="pilih2('5','3',2,'3','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj3" value="C" id="J53" onclick="JW53()"
				    <?php if($checked[0]=='C'){echo "checked"; } ?> <?php if($checked[1]=='C'){echo "checked"; } ?> <?php if($checked[2]=='C'){echo "checked"; } ?>
				   <?php if($checked[3]=='C'){echo "checked"; } ?> <?php if($checked[4]=='C'){echo "checked"; } ?>
				   > 
						<span class="check"></span> C</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 
					
						<div class='form-group mb-4'>
							<textarea name='perC' class='editor1 pilihan form-control'><?= $soal['perC'] ?></textarea>
						</div>
						 <div class="form-group d-flex justify-content-end">
						<button id="C" type="button" class="btn btn-sm btn-icon btn-success me-2"><i class="material-icons">add</i></button>										
						<button id="Ctutup" type="button" class="btn btn-sm btn-icon btn-dark" ><i class="material-icons">close</i> </button>							
					</div>        
					</div>
				</div>						
			</div>	
		</div>
	</div>
<?php endif; ?>
<?php if($soal['perD']<>''): ?>
	<div class="form-container" id="formD">				
			<div class='row'>
				<div class="col-md-6">
					<div class="card">
						 <div class="card-header" id="row1-5-4">
						 <div class='form-group mb-2' onClick="pilih1('5','4','#FF9800','4')">PERNYATAAN 4
						<label class="checkbox kanane"><input type="radio" name="rp4" value="#FF9800" id="P54"  onclick="PR54()" checked>
						<span class="check"></span> 4</label>
							</div>
						  </div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilD'  class='editor1 pilihan form-control'><?= $soal['pilD'] ?> </textarea>                                   
					</div>
					<div class='form-group mb-0'>
					 <?php
							if ($soal['fileD'] <> '') {
								$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
								$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
								$ext = explode(".", $soal['fileD']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									echo "
									<label>Gambar A</label><br />
									<img src='$baseurl/files/$soal[fileD]' style='max-width:80px;' />
									";
								} elseif (in_array($ext, $audio)) {
									echo "
									<label>Audio</label><br />
									<audio controls>
										<source src='$baseurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
									";
								} else {
									echo "File tidak didukung!";
									echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileD&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
								}
								echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileD&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
							} else {
								echo "
									<label>Gambar / Audio Pil A</label>
									<input type='file' name='fileD' class='form-control' />
									";
							}
						   ?>	
						</div>                    
					</div>
				</div>
			</div>
            <div class="col-md-6">
				<div class="card">
					<div class="card-header" id="row2-5-4">
						  <div class='form-group mb-0' onCLick="pilih2('5','4',2,'4','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj4" value="D" id="J54" onclick="JW54()"
				     <?php if($checked[0]=='D'){echo "checked"; } ?> <?php if($checked[1]=='D'){echo "checked"; } ?> <?php if($checked[2]=='D'){echo "checked"; } ?>
				   <?php if($checked[3]=='D'){echo "checked"; } ?> <?php if($checked[4]=='D'){echo "checked"; } ?>
				   > 
						<span class="check"></span> D</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 
					
						<div class='form-group mb-4'>
							<textarea name='perD' class='editor1 pilihan form-control'><?= $soal['perD'] ?></textarea>
						</div>
						<div class="form-group d-flex justify-content-end">
						<button id="D" type="button" class="btn btn-sm btn-icon btn-success me-2"><i class="material-icons">add</i></button>										
						<button id="Dtutup" type="button" class="btn btn-sm btn-icon btn-dark" ><i class="material-icons">close</i> </button>							
					</div>       
					</div>
				</div>						
			</div>	
		</div>
	</div>
<?php endif; ?>
<?php if($soal['perE']<>''): ?>
	<div class="form-container" id="formE">				
			<div class='row'>
				<div class="col-md-6">
					<div class="card">
						 <div class="card-header" id="row1-5-5">
						 <div class='form-group mb-2' onClick="pilih1('5','5','#0277BD','5')">PERNYATAAN 5
						<label class="checkbox kanane"><input type="radio" name="rp5" value="#0277BD" id="P55"  onclick="PR55()" checked>
						<span class="check"></span> 5</label>
							</div>
						  </div>
                   <div class="card-body">				   
					<div class='form-group mb-2'>
						<textarea name='pilE'  class='editor1 pilihan form-control'><?= $soal['pilE'] ?></textarea>                                   
					</div>
					<div class='form-group mb-0'>
						<?php
							if ($soal['fileE'] <> '') {
								$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
								$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
								$ext = explode(".", $soal['fileE']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									echo "
									<label>Gambar A</label><br />
									<img src='$baseurl/files/$soal[fileE]' style='max-width:80px;' />
									";
								} elseif (in_array($ext, $audio)) {
									echo "
									<label>Audio</label><br />
									<audio controls>
										<source src='$baseurl/files/$soal[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
									";
								} else {
									echo "File tidak didukung!";
									echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileE&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
								}
								echo "<br /><a href='?pg=$pg&ac=hapusfile&id=$soal[id_soal]&file=fileE&jenis=$jenis' class='text-red'><i class='material-icons'>close</i> Hapus</a>";
							} else {
								echo "
									<label>Gambar / Audio Pil E</label>
									<input type='file' name='fileE' class='form-control' />
									";
							}
						   ?>	
						</div>             
					</div>
				</div>
			</div>
            <div class="col-md-6">
			   <div class="card">
					<div class="card-header" id="row2-5-5">
						<div class='form-group mb-0' onCLick="pilih2('5','5',2,'4','18','2')">
				   <label  class="checkbox"> <input type="radio" name="rj5" value="E" id="J55" onclick="JW55()"
				    <?php if($checked[0]=='E'){echo "checked"; } ?> <?php if($checked[1]=='E'){echo "checked"; } ?> <?php if($checked[2]=='E'){echo "checked"; } ?>
				   <?php if($checked[3]=='E'){echo "checked"; } ?> <?php if($checked[4]=='E'){echo "checked"; } ?>
				   > 
						<span class="check"></span> E</label> 
						<label class="d-flex justify-content-end" style="margin-top:-30px">JAWABAN</label>
						</div>
						  </div>
                   <div class="card-body"> 				
						<div class='form-group mb-4'>
							<textarea name='perE' class='editor1 pilihan form-control'><?= $soal['perE'] ?></textarea>
						</div>
						<div class="form-group d-flex justify-content-end">
						<button  class="btn btn-sm btn-icon btn-light me-2" disabled><i class="material-icons">add</i></button>										
						<button id="Etutup" type="button" class="btn btn-sm btn-icon btn-dark" ><i class="material-icons">close</i> </button>							
					</div>              
					</div>
				</div>						
			</div>	
		</div>
	</div>
<?php endif; ?>
</form>			
</div>
<?php elseif ($ac == 'hapusfile') : ?>
 <?php
$id = $_GET['id'];
$file = $_GET['file'];
$stmt = $pdo->prepare("SELECT * FROM soal WHERE id_soal = :id_soal");
$stmt->execute([':id_soal' => $id]);
$soal = $stmt->fetch(PDO::FETCH_ASSOC);
$filePath = "../files/" . $soal[$file];

if (file_exists($filePath)) {
    unlink($filePath); 
}
$updateStmt = $pdo->prepare("UPDATE soal SET $file = '' WHERE id_soal = :id_soal");
$updateStmt->execute([':id_soal' => $id]);
jump("?pg=$pg&id_soal=$id");
?> 						   
	<?php endif; ?>
<script>
<?php if($soal['perA']<>''): ?>
 document.getElementById("row1-5-1").style.backgroundColor = '#00BCD4';
 <?php if($checked[0]=='A'){$warnamu=$warna[0]; } ?> <?php if($checked[1]=='A'){$warnamu=$warna[1]; } ?> <?php if($checked[2]=='A'){$warnamu=$warna[2]; } ?>
 <?php if($checked[3]=='A'){$warnamu=$warna[3]; } ?> <?php if($checked[4]=='A'){$warnamu=$warna[4]; } ?>
 document.getElementById("row2-5-1").style.backgroundColor = '<?= $warnamu ?>';
 <?php endif; ?>
 <?php if($soal['perB']<>''): ?>
 document.getElementById("row1-5-2").style.backgroundColor = '#F44336';
 <?php if($checked[0]=='B'){$warnamu=$warna[0]; } ?> <?php if($checked[1]=='B'){$warnamu=$warna[1]; } ?> <?php if($checked[2]=='B'){$warnamu=$warna[2]; } ?>
 <?php if($checked[3]=='B'){$warnamu=$warna[3]; } ?> <?php if($checked[4]=='B'){$warnamu=$warna[4]; } ?>
 document.getElementById("row2-5-2").style.backgroundColor = '<?= $warnamu ?>';
 <?php endif; ?>
 <?php if($soal['perC']<>''): ?>
 document.getElementById("row1-5-3").style.backgroundColor = '#4CAF50';
 <?php if($checked[0]=='C'){$warnamu=$warna[0]; } ?> <?php if($checked[1]=='C'){$warnamu=$warna[1]; } ?> <?php if($checked[2]=='C'){$warnamu=$warna[2]; } ?>
 <?php if($checked[3]=='C'){$warnamu=$warna[3]; } ?> <?php if($checked[4]=='C'){$warnamu=$warna[4]; } ?>
 document.getElementById("row2-5-3").style.backgroundColor = '<?= $warnamu ?>';
 <?php endif; ?>
 <?php if($soal['perD']<>''): ?>
 document.getElementById("row1-5-4").style.backgroundColor = '#FF9800';
 <?php if($checked[0]=='D'){$warnamu=$warna[0]; } ?> <?php if($checked[1]=='D'){$warnamu=$warna[1]; } ?> <?php if($checked[2]=='D'){$warnamu=$warna[2]; } ?>
 <?php if($checked[3]=='D'){$warnamu=$warna[3]; } ?> <?php if($checked[4]=='D'){$warnamu=$warna[4]; } ?>
 document.getElementById("row2-5-4").style.backgroundColor = '<?= $warnamu ?>';
 <?php endif; ?>
 <?php if($soal['perE']<>''): ?>
 document.getElementById("row1-5-5").style.backgroundColor = '#0277BD';
 <?php if($checked[0]=='E'){$warnamu=$warna[0]; } ?> <?php if($checked[1]=='E'){$warnamu=$warna[1]; } ?> <?php if($checked[2]=='E'){$warnamu=$warna[2]; } ?>
 <?php if($checked[3]=='E'){$warnamu=$warna[3]; } ?> <?php if($checked[4]=='E'){$warnamu=$warna[4]; } ?>
 document.getElementById("row2-5-5").style.backgroundColor = '<?= $warnamu ?>';
 <?php endif; ?>
</script>
<script>
	function PR51() {

	var warna = $('#P51').val();
	var idbank = $('#idbank').val();
	var nomor = $('#nomor').val();
	$.ajax({
	type: 'POST',
	url: 'bank/tjodoh.php?pg=JDH1',
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
	url: 'bank/tjodoh.php?pg=UPJDH1',
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
	url: 'bank/tjodoh.php?pg=JDH2',
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
	url: 'bank/tjodoh.php?pg=UPJDH1',
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
	url: 'bank/tjodoh.php?pg=JDH3',
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
	url: 'bank/tjodoh.php?pg=UPJDH1',
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
	url: 'bank/tjodoh.php?pg=JDH4',
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
	url: 'bank/tjodoh.php?pg=UPJDH1',
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
	url: 'bank/tjodoh.php?pg=JDH5',
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
	url: 'bank/tjodoh.php?pg=UPJDH1',
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
<?php if($soal['perC']<>''): ?>
$("#Ctutup").click(function() {$("#formC").hide();}); 
$("#C").click(function() {$("#formD").show(); });
<?php endif; ?>
<?php if($soal['perD']<>''): ?>
$("#Dtutup").click(function() {$("#formD").hide();});
$("#D").click(function() {$("#formE").show(); });
<?php endif; ?>
<?php if($soal['perE']<>''): ?>
$("#Etutup").click(function() {$("#formE").hide();});
<?php endif; ?>  
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
  <?php if($soal['perC']<>''): ?>
  document.getElementById("P53").checked = false;
  document.getElementById("J53").checked = false; 
  document.getElementById("row1-5-3").style.backgroundColor = 'white';
  document.getElementById("row2-5-3").style.backgroundColor = 'white';
  <?php endif; ?>
  <?php if($soal['perD']<>''): ?>
  document.getElementById("P54").checked = false;
  document.getElementById("J54").checked = false; 
  document.getElementById("row1-5-4").style.backgroundColor = 'white';
  document.getElementById("row2-5-4").style.backgroundColor = 'white';
  <?php endif; ?>
  <?php if($soal['perE']<>''): ?>
  document.getElementById("P55").checked = false;
  document.getElementById("J55").checked = false; 
  document.getElementById("row1-5-5").style.backgroundColor = 'white';
  document.getElementById("row2-5-5").style.backgroundColor = 'white';
  <?php endif; ?>
var idbank = $('#idbank').val();
var nomor = $('#nomor').val();
$.ajax({
	type: 'POST',
	url: 'bank/tjodoh.php?pg=RESET',
	data: 'idbank=' + idbank + "&nomor=" + nomor,
	success: function(response) {
						 
	}
	});
}
</script>
<script>
$('#formsoal').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
             url: 'bank/tbanksoal2.php?pg=simpan_soal',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
             beforeSend: function() {
                $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
            },
            success: function(data) {
               
                setTimeout(function() {
                    window.location.replace("?pg=<?= enkripsi('banksoal') ?>&ac=lihat&id=<?= $mapel['id_bank'] ?>");
                }, 200);
            }
        })
        return false;
    });
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
