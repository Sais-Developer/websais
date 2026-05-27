<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
require("../../konek/dis.php");

$id_bank = $_GET['id'] ?? '';

$stmtMapel = $pdo->prepare("
    SELECT b.*, g.* 
    FROM banksoal b
    LEFT JOIN guru g ON g.id_guru = b.idguru
    WHERE b.id_bank = :id_bank
");
$stmtMapel->execute([':id_bank' => $id_bank]);
$mapel = $stmtMapel->fetch(PDO::FETCH_ASSOC);

$model = '';
if ($mapel['model'] == 1) {
    $model = 'Literasi';
} elseif ($mapel['model'] == 2) {
    $model = 'Numerasi';
}
?>

	  <style>
		* {
			margin: auto;
			padding: 0;
			line-height: 100%;
		}

		td {
			padding: 1px 3px 1px 3px;
		}

		.garis {
			border: 1px solid #000;
			border-left: 0px;
			border-right: 0px;
			padding: 1px;
			margin-top: 5px;
			margin-bottom: 5px;
		}
	</style>
			
			<table width="100%">
			<tr>
			<td rowspan='5'>
				<img src="../../images/<?= $setting['logo'] ?>" width='90px'/>
			</td>
			<td width=200>Mata Pelajaran </td>
			<td width=200>: <?= $mapel['kode'] ?></td> 
			<td rowspan='5' width=400></td>					
			</tr>
			<tr>
				<td>Jenis Soal </td>
				<td>: <?= $model ?></td>
			</tr>
			<tr>
				<td>Tingkat | Jurusan </td>
				<td>: <?= $mapel['tingkat'] ?> | <?= $mapel['jurusan'];  ?></td>
			</tr>
			<tr>
				<td>Pembuat Soal</td>
				<td>: <?= $mapel['nama'] ?></td>
			</tr>
			<tr>
				<td>Satuan Pendidikan</td>
				<td width=400>: <?= $setting['sekolah'] ?></td>
			</tr>
			</table>
			<div class='garis'></div>
		    <br/>
				
		<table  class='table' width="100%">
			<tbody>
				<?php
				$stmtSoal = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank ORDER BY nomor");
				$stmtSoal->execute([':id_bank' => $id_bank]);
				while ($soal = $stmtSoal->fetch(PDO::FETCH_ASSOC)) :
				?>
			<tr>
				<td style='width:30px;vertical-align:top'>
					<?= $soal['nomor'] ?>
				</td>
				<td style="text-align:justify">
					<?php
						if (!empty($soal['fileSoal'])) :
							$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
							$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
							$ext = pathinfo($soal['fileSoal'], PATHINFO_EXTENSION);
							$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileSoal'];

							if (in_array($ext, $image)) {
								echo "<p style='margin-bottom:5px'>
										<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Soal'>
									  </p>";
							} elseif (in_array($ext, $audio)) {
								echo "<p style='margin-bottom:5px'>
										<audio controls>
											<source src='" . htmlspecialchars($filePath) . "' type='audio/" . strtolower($ext) . "'>
											Browser Anda tidak mendukung audio.
										</audio>
									  </p>";
							} else {
								echo "<p><em>File tidak didukung!</em></p>";
							}
						endif;
						?>

					<?= $soal['soal']; ?>
					
					<?php if ($soal['jenis'] == '1') : ?>
					<table width="100%">
						<tr>
							<td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
							<td style="padding: 3px;width: 31%; vertical-align: text-top;">
								<?php
								if (!empty($soal['pilA'])) {
									echo $soal['pilA'];
								}

								if (!empty($soal['fileA'])) {
									$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
									$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

									$ext = strtolower(pathinfo($soal['fileA'], PATHINFO_EXTENSION));
									$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileA'];

									if (in_array($ext, $image)) {
										echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan A' />";
									}
								}
								?>

							</td>
							 <?php if ($soal['pilC'] <>'') : ?>
							<td style="padding: 3px;width: 2%; vertical-align: text-top;">C.</td>
							<td style="padding: 3px;width: 31%; vertical-align: text-top;">
								<?php
							if (!empty($soal['pilC'])) {
								echo $soal['pilC'];
							}

							if (!empty($soal['fileC'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

								$ext = strtolower(pathinfo($soal['fileC'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileC'];

								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
							</td>
							  <?php endif; ?>
							<?php if ($soal['pilE'] <>'') : ?>
								<td style="padding: 3px;width: 2%; vertical-align: text-top;">E.</td>
								<td style="padding: 3px; vertical-align: text-top;">
								   <?php
							if (!empty($soal['pilE'])) {
								echo $soal['pilE'];
							}

							if (!empty($soal['fileE'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

								$ext = strtolower(pathinfo($soal['fileE'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileE'];

								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
								</td>
							<?php endif; ?>

						</tr>

						<tr>
						<?php if ($soal['pilB']<>'') : ?>
							<td style="padding: 3px;width: 2%; vertical-align: text-top;">B.</td>
							<td style="padding: 3px;width: 31%; vertical-align: text-top;">
							   <?php
							if (!empty($soal['pilB'])) {
								echo $soal['pilB'];
							}

							if (!empty($soal['fileB'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

								$ext = strtolower(pathinfo($soal['fileB'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileB'];

								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
							</td>
							 <?php endif; ?>
							<?php if ($soal['pilD'] <>'') : ?>
								<td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
								<td style="padding: 3px;width: 31%; vertical-align: text-top;">
									<?php
							if (!empty($soal['pilD'])) {
								echo $soal['pilD'];
							}

							if (!empty($soal['fileD'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

								$ext = strtolower(pathinfo($soal['fileD'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileD'];

								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
								</td>

							<?php endif; ?>

						</tr>

					</table>
																		
					<?php endif; ?>
					
				
				<?php if ($soal['jenis'] == '2') : ?>
				 <table width="100%">
				 <tr>
						  <td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
						 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
						 <td style="padding: 3px;width: 31%; vertical-align: text-top;">
						  <?= $soal['pilA'] ?><br>
						 <?php
								if (!empty($soal['fileA'])) {
									$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
									$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

									$ext = strtolower(pathinfo($soal['fileA'], PATHINFO_EXTENSION));
									$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileA'];

									if (in_array($ext, $image)) {
										echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan A' />";
									}
								}
								?>
						 </td>
						  <?php if ($soal['pilB'] <>''){ ?>
						 <td style="padding: 3px;width: 2%; vertical-align: text-top;">B.</td>
						 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
						 <td style="padding: 3px;width: 31%; vertical-align: text-top;"> 
						 <?= $soal['pilB'] ?><br>
							<?php
							if (!empty($soal['fileB'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

								$ext = strtolower(pathinfo($soal['fileB'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileB'];

								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						 </td>
						<?php } ?>
						</tr>
						 <tr>
						  <?php if ($soal['pilC'] <>''){ ?>
						  <td style="padding: 3px;width: 2%; vertical-align: text-top;">C.</td>
						 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
						 <td style="padding: 3px;width: 31%; vertical-align: text-top;">
						 <?= $soal['pilC'] ?><br>
						  <?php
							if (!empty($soal['fileC'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

								$ext = strtolower(pathinfo($soal['fileC'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileC'];

								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						 
						 </td>
							<?php } ?>
						 <?php if ($soal['pilD'] <>''){ ?>
						<td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
						 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
						 <td style="padding: 3px;width: 31%; vertical-align: text-top;"> 
						 <?= $soal['pilD'] ?><br>
						  <?php
							if (!empty($soal['fileD'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

								$ext = strtolower(pathinfo($soal['fileD'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileD'];

								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						 </td>
						<?php } ?>
						</tr>
						
						  <?php if ($soal['pilE'] <>''){ ?>
						<tr>
						  <td style="padding: 3px;width: 2%; vertical-align: text-top;">E.</td>
						 <td style="padding: 3px;width: 2%; vertical-align: text-top;"><input type="checkbox" name="<?= $soal['id_soal'] ?>"></td>
						 <td style="padding: 3px;width: 31%; vertical-align: text-top;">
						 <?= $soal['pilE'] ?><br>
						  <?php
							if (!empty($soal['fileE'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];

								$ext = strtolower(pathinfo($soal['fileE'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileE'];

								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						 </td>
						 <td style="padding: 3px;width: 2%; vertical-align: text-top;"></td>
						 <td style="padding: 3px;width: 2%; vertical-align: text-top;"></td>
						 <td style="padding: 3px;width: 31%; vertical-align: text-top;"> </td>
						
						</tr>
						<?php } ?>
						</table>
						
				<?php endif; ?>
				
				
				<?php if ($soal['jenis'] == '3' ) : ?>
				 <table width="100%" class='table'>
				  <?php if ($soal['pilA']<>''){ ?>
				 <tr>									 
						<td class="text-center" ><b>Pernyataan</b></td>
						<td class="text-center" width="5%" ><b>Benar</b></td>
						<td class="text-center" width="5%" ><b>Salah</b></td>														
						</tr>
					 <?php }else{ ?>
				 <tr>															
						<td class="text-center" width="5%" ><b>Benar</b></td>
						<td class="text-center" width="5%" ><b>Salah</b></td>															
						</tr>
					   <?php } ?>   
						<tr>
						<?php if ($soal['pilA']<>''){ ?>
						<td>
						<?= $soal['pilA'] ?><br>
						 <?php
							if (!empty($soal['fileA'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileA'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileA'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						
						</td>
						<?php } ?>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>1"></td>			
						</tr>
						
						<?php if ($soal['pilB']<>''){ ?>
						<tr>
					<?php if ($soal['pilB']<>''){ ?>
						<td>
						<?= $soal['pilB'] ?><br>
						<?php
							if (!empty($soal['fileB'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileB'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileB'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						</td>
						<?php } ?>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>2"></td>											
						</tr>
						<?php } ?>
						<?php if ($soal['pilC']<>''){ ?>
						<tr>
						<?php if ($soal['pilC']<>''){ ?>
						<td>
						<?= $soal['pilC'] ?><br>
						<?php
							if (!empty($soal['fileC'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileC'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileC'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						</td>
						<?php } ?>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>3"></td>
						</tr>
						<?php } ?>
						<?php if ($soal['pilD']<>''){ ?>
						<tr>
						<?php if ($soal['pilD']<>''){ ?>
						<td>
						<?= $soal['pilD'] ?><br>
						<?php
							if (!empty($soal['fileD'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileD'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileD'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						</td>
						<?php } ?>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>4"></td>											
						</tr>
							<?php } ?>
					 <?php if ($soal['pilE']<>''){ ?>
						<tr>
						<?php if ($soal['pilE']<>''){ ?>
						<td>
						<?= $soal['pilE'] ?><br>
						<?php
							if (!empty($soal['fileE'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileE'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileE'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						</td>
						<?php } ?>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
						<td class="text-center"><input type="radio" name="<?= $soal['id_soal'] ?>5"></td>
						
						</tr>
						<?php } ?>
						</table>
						
				<?php endif; ?>
				<?php if ($soal['jenis'] == '4') : ?>
				 <table width="100%" class='table'>
					   <tr>
					  
						<td class="text-center" ><b>Pernyataan</b></td>	
						<td class="text-center" width="5%" ><b></b></td>	
						<td class="text-center" width="5%" ><b></b></td>	
						<td class="text-center" ><b>Jawaban</b></td>	
																				
						</tr>
					   
						<tr>															
						<td>
						 <?php
							if (!empty($soal['fileA'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileA'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileA'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						<?= $soal['pilA'] ?>
						</td>															
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td>
						<?= $soal['perA'] ?>
						</td>															
						</tr>
						<?php if ($soal['pilB']<>''){ ?>
						<tr>															
						<td>
						<?php
							if (!empty($soal['fileB'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileB'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileB'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?><?= $soal['pilB'] ?>
							</td>															
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td>
						<?= $soal['perB'] ?>
						
						</td>															
						</tr>
						<?php } ?>
						<?php if ($soal['pilC']<>''){ ?>
						<tr>															
						<td>
						<?php
							if (!empty($soal['fileC'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileC'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileC'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						<?= $soal['pilC'] ?>
						</td>															
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td>
						<?= $soal['perC'] ?>
						
						</td>															
						</tr>
						<?php } ?>
						<?php if ($soal['pilD']<>''){ ?>
						<tr>															
						<td>
						<?php
							if (!empty($soal['fileD'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileD'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileD'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						<?= $soal['pilD'] ?>
						</td>															
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td>
						<?= $soal['perD'] ?>
						
						</td>															
						</tr>
							<?php } ?>
						 <?php if ($soal['pilE']<>''){ ?>
						<tr>															
						<td>
						<?php
							if (!empty($soal['fileE'])) {
								$audio = ['mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG'];
								$image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'];
								$ext = strtolower(pathinfo($soal['fileE'], PATHINFO_EXTENSION));
								$filePath = rtrim($baseurl, '/') . '/files/' . $soal['fileE'];
								if (in_array($ext, $image)) {
									echo "<img src='" . htmlspecialchars($filePath) . "' style='max-width:100px;' alt='Gambar Pilihan C' />";
								} 
							}
							?>
						<?= $soal['pilE'] ?>
						
						</td>															
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td><input type="checkbox" name="<?= $soal['id_soal'] ?>1"></td>
						<td>
						
						<?= $soal['perE'] ?><br>
						
						</td>															
						</tr>
						<?php } ?>
						</table>
				<?php endif; ?>
		<?php endwhile; ?>
	</tbody>
</table>
