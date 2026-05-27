<?php 
$id_bank = $_GET['id'] ?? 0; 
?>


<div class="row">          
    <div class="col-md-12">
        <div class="card">
		   <div class="card-header d-flex justify-content-between align-items-center">
		       <div class="col-md-4">
                <div class="form-group">
                <select onChange="document.location.href=this.options[this.selectedIndex].value;" class="form-select">
                <option value="0">-- PILIH SOAL -- </option>
                <option value="?pg=<?= htmlspecialchars($pg) ?>&ac=pg&id=<?= $id_bank ?>&jenis=1">Pilihan Ganda</option>                      		 
                <option value="?pg=<?= htmlspecialchars($pg) ?>&ac=multi&id=<?= $id_bank ?>&jenis=2">PG Multi Choice</option>
                <option value="?pg=<?= htmlspecialchars($pg) ?>&ac=bs&id=<?= $id_bank ?>&jenis=3">Benar Salah</option>
                <option value="?pg=<?= htmlspecialchars($pg) ?>&ac=urut&id=<?= $id_bank ?>&jenis=4">Menjodohkan</option>
				<option value="?pg=<?= htmlspecialchars($pg) ?>&ac=pg&id=<?= $id_bank ?>&jenis=5">Uraian Singkat</option>						
                </select>
              </div>
            </div>
		<div>
            <a href="?pg=<?= enkripsi('banksoal') ?>" class="btn btn-sm btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali">
			<i class="material-icons">arrow_back</i></a>
			
            <button class="btn btn-sm btn-primary" onclick="frames['frameresult'].print()" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak">
			<i class="material-icons">print</i></button>
			
			<button id="btnreset" data-id="<?= $id_bank ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
			<i class="material-icons">delete</i></button>
            
			<iframe name="frameresult" src="<?= $baseurl ?>/mycbt/bank/cetaksoal.php?id=<?= $id_bank ?>" style="border:none;width:1px;height:1px;"></iframe>
            
         </div>	
     </div>
    <div class="card-body">      
 <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-PG-tab" data-bs-toggle="pill" data-bs-target="#pills-PG" type="button" role="tab" aria-controls="pills-PG" aria-selected="true">PG</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-MULTI-tab" data-bs-toggle="pill" data-bs-target="#pills-MULTI" type="button" role="tab" aria-controls="pills-MULTI" aria-selected="false">PG MULTI</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-BS-tab" data-bs-toggle="pill" data-bs-target="#pills-BS" type="button" role="tab" aria-controls="pills-BS" aria-selected="false">BENAR SALAH</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-JODOH-tab" data-bs-toggle="pill" data-bs-target="#pills-JODOH" type="button" role="tab" aria-controls="pills-JODOH" aria-selected="false">MENJODOHKAN</button>
    </li>  
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-ESAI-tab" data-bs-toggle="pill" data-bs-target="#pills-ESAI" type="button" role="tab" aria-controls="pills-ESAI" aria-selected="false">ESAI</button>
    </li> 
</ul> 

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-PG" role="tabpanel" aria-labelledby="pills-PG-tab">
       <div class="table-responsive">
        <table id="tabelPG" class="table align-middle">
				<tbody>
				<?php 
					$no = 0;
					$stmt = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = 1 ORDER BY nomor");
					$stmt->bindValue(':id_bank', $id_bank, PDO::PARAM_INT);
					$stmt->execute();
					$soalList = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if ($soalList) :
						$image = ['jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP'];
						$audio = ['mp3','wav','ogg','MP3','WAV','OGG'];

						foreach ($soalList as $soal) :
							$no++;
				?>
					<tr>
						<td style="width:12%;text-align:center;vertical-align:top">
							<?= $no ?>. 
							<button data-id="<?= $soal['id_soal'] ?>" class="hapus btn btn-sm btn-outline-danger mt-2" title="Hapus">
								<i class="material-icons">delete</i>
							</button>
							<a href="?pg=<?= enkripsi('editsoal1') ?>&id_soal=<?= $soal['id_soal'] ?>"
							   class="btn btn-sm btn-outline-primary mt-1" title="Edit">
								  <i class="material-icons">edit</i>
							</a>
						</td>
						<td style="text-align:justify">
							<?php
							if (!empty($soal['fileSoal'])) :
								$ext = pathinfo($soal['fileSoal'], PATHINFO_EXTENSION);
								if (in_array($ext, $image)) {
									echo "<p><img src='{$baseurl}/files/{$soal['fileSoal']}' style='max-width:120px;'/></p>";
								} elseif (in_array($ext, $audio)) {
									echo "<p><audio controls><source src='{$baseurl}/files/{$soal['fileSoal']}' type='audio/{$ext}'></audio></p>";
								}
							endif;
							?>
                <div class="mb-2"><?= $soal['soal']; ?></div>
                <div class="container">
                    <div class="row">
                        <?php 
                        $options = ['A','B','C','D','E'];
                        foreach ($options as $opt) :
                            $pil = 'pil'.$opt;
                            $file = 'file'.$opt;
                            if (!empty($soal[$pil])) :
                        ?>
                            <div class="col-md-6">
                                <b><?= $opt ?>.</b>
                                <input type="radio" name="radio<?= $soal['id_soal'] ?>" <?= ($soal['jawaban'] == $opt ? 'checked' : '') ?>>
                                <?= $soal[$pil] ?>
                                <?php 
                                if (!empty($soal[$file])) :
                                    $ext = pathinfo($soal[$file], PATHINFO_EXTENSION);
                                    if (in_array($ext, $image)) {
                                        echo "<img src='{$baseurl}/files/{$soal[$file]}' style='max-width:100px;' class='mt-1'/>";
                                    } elseif (in_array($ext, $audio)) {
                                        echo "<audio controls class='mt-1'><source src='{$baseurl}/files/{$soal[$file]}' type='audio/{$ext}'></audio>";
                                    }
                                endif;
                                ?>
                            </div>
                        <?php 
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="mt-2">
                    <b>Skor Max:</b> <?= $soal['max_skor'] ?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Kunci:</b> <?= $soal['jawaban'] ?>
					</div>
				</td>
			</tr>
		<?php endforeach; else : ?>
        <tr>
            <td colspan="2" class="text-center text-muted p-4">
                <i>Tidak ada soal pilihan ganda.</i>
            </td>
        </tr>
		<?php endif; ?>
		</tbody>
	</table>
 </div>
</div>

<div class="tab-pane fade" id="pills-MULTI" role="tabpanel" aria-labelledby="pills-MULTI-tab">
    <div class="table-responsive">
        <table id="tabelMULTI" class="table align-middle">
				<tbody>
				<?php 
					$no = 0;
					$stmt = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = 2 ORDER BY nomor");
					$stmt->bindValue(':id_bank', $id_bank, PDO::PARAM_INT);
					$stmt->execute();

					$soalList = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if ($soalList) :
						$image = ['jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP'];
						$audio = ['mp3','wav','ogg','MP3','WAV','OGG'];

						foreach ($soalList as $soal) :
							$no++;
							$checked = array_map('trim', explode(',', $soal['jawaban']));
				?>
					<tr>
						<td style="width:12%;text-align:center;vertical-align:top">
							<?= $no ?>. 
							<button data-id="<?= $soal['id_soal'] ?>" class="hapus btn btn-sm btn-outline-danger mt-2" title="Hapus">
								<i class="material-icons">delete</i>
							</button>
							<a href="?pg=<?= enkripsi('editsoal3') ?>&id_soal=<?= $soal['id_soal'] ?>"
								class="btn btn-sm btn-outline-primary mt-1" title="Edit">
									<i class="material-icons">edit</i>
							</a>
						</td>
						<td style="text-align:justify">
							<?php
							if (!empty($soal['fileSoal'])) :
								$ext = pathinfo($soal['fileSoal'], PATHINFO_EXTENSION);
								if (in_array($ext, $image)) {
									echo "<p><img src='{$baseurl}/files/{$soal['fileSoal']}' style='max-width:120px;'/></p>";
								} elseif (in_array($ext, $audio)) {
									echo "<p><audio controls><source src='{$baseurl}/files/{$soal['fileSoal']}' type='audio/{$ext}'></audio></p>";
								}
							endif;
							?>
                <div class="mb-2"><?= $soal['soal']; ?></div>
                <div class="container">
                    <div class="row">
                        <?php 
                        $options = ['A','B','C','D','E'];
                        foreach ($options as $opt) :
                            $pil = 'pil'.$opt;
                            $file = 'file'.$opt;
                            if (!empty($soal[$pil])) :
                        ?>
                            <div class="col-md-6">
                                <b><?= $opt ?>.</b>
                                <input type="checkbox" name="check<?= $soal['id_soal'] ?>[]" <?= (in_array($opt, $checked) ? 'checked' : '') ?>>
                                <?= $soal[$pil] ?>
                                <?php 
                                if (!empty($soal[$file])) :
                                    $ext = pathinfo($soal[$file], PATHINFO_EXTENSION);
                                    if (in_array($ext, $image)) {
                                        echo "<img src='{$baseurl}/files/{$soal[$file]}' style='max-width:100px;' class='mt-1'/>";
                                    } elseif (in_array($ext, $audio)) {
                                        echo "<audio controls class='mt-1'><source src='{$baseurl}/files/{$soal[$file]}' type='audio/{$ext}'></audio>";
                                    }
                                endif;
                                ?>
                            </div>
                        <?php 
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>

                <div class="mt-2">
                    <b>Skor Max:</b> <?= $soal['max_skor'] ?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Kunci:</b> <?= $soal['jawaban'] ?>
                </div>
            </td>
        </tr>
    <?php 
        endforeach;
    else :
    ?>
        <tr>
            <td colspan="2" class="text-center text-muted p-4">
                <i>Tidak ada soal pilihan ganda multi.</i>
            </td>
        </tr>
		<?php endif; ?>
		</tbody>
	</table>
    </div>
</div>

<div class="tab-pane fade" id="pills-BS" role="tabpanel" aria-labelledby="pills-BS-tab">
        <div class="table-responsive">
            <table id="tabelBS" class="table">
			<tbody>
			<?php 
				$no = 0; 
				$stmt = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = 3 ORDER BY nomor");
				$stmt->bindValue(':id_bank', $id_bank, PDO::PARAM_INT);
				$stmt->execute();

				$soalList = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if ($soalList) :
					$image = ['jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP'];
					$audio = ['mp3','wav','ogg','MP3','WAV','OGG'];

					foreach ($soalList as $soal) :
						$no++;
						$checked = array_map('trim', explode(',', $soal['jawaban']));
			?>
				<tr>
					<td style="width:12%;text-align:center;vertical-align:top">
						<?= $no ?>. 
						<button data-id="<?= $soal['id_soal'] ?>" class="hapus btn-sm btn btn-outline-danger" title="Hapus">
						  <i class="material-icons">delete</i>
						</button>
						<a href="?pg=<?= enkripsi('editsoal4') ?>&id_soal=<?= $soal['id_soal'] ?>"
						  class="btn btn-sm btn-outline-primary mt-1" title="Edit">
							 <i class="material-icons">edit</i>
						</a>
					</td>

					<td style="text-align:justify">
					<?php
					if (!empty($soal['fileSoal'])) :
						$ext = pathinfo($soal['fileSoal'], PATHINFO_EXTENSION);
						if (in_array($ext, $image)) {
							echo "<p><img src='{$baseurl}/files/{$soal['fileSoal']}' style='max-width:120px;'/></p>";
						} elseif (in_array($ext, $audio)) {
							echo "<p><audio controls><source src='{$baseurl}/files/{$soal['fileSoal']}' type='audio/{$ext}'></audio></p>";
						}
					endif;
					?>
                <?= $soal['soal']; ?>
                <table width="100%" class="table table-bordered">
                    <tr>
                        <th>Pernyataan</th>
                        <th class="text-center">Benar</th>
                        <th class="text-center">Salah</th>
                    </tr>
                    <?php
                    $opsi = ['A','B','C','D','E'];
                    foreach ($opsi as $i => $huruf) :
                        $pil = $soal['pil'.$huruf] ?? '';
                        $file = $soal['file'.$huruf] ?? '';
                        if (!empty($pil)) :
                    ?>
                    <tr>
                        <td>
                            <?php
                            if (!empty($file)) {
                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                if (in_array($ext, $image)) {
                                    echo "<img src='{$baseurl}/files/{$file}' style='max-width:100px;' class='mb-1'/>";
                                } elseif (in_array($ext, $audio)) {
                                    echo "<audio controls class='mb-1'><source src='{$baseurl}/files/{$file}' type='audio/{$ext}'>Your browser does not support the audio tag.</audio>";
                                } else {
                                    echo "File tidak didukung!";
                                }
                            }
                            ?>
                            <?= $pil ?>
                        </td>
                        <td class="text-center"><input type="radio" <?= ($checked[$i] ?? '') === 'B' ? 'checked' : '' ?>></td>
                        <td class="text-center"><input type="radio" <?= ($checked[$i] ?? '') === 'S' ? 'checked' : '' ?>></td>
                    </tr>
                    <?php 
                        endif;
                    endforeach;
                    ?>
                </table>

                <b>Skor Max :</b> <?= $soal['max_skor'] ?>&nbsp;&nbsp;
                <b>Kunci :</b> <?= $soal['jawaban'] ?>
            </td>
        </tr>
    <?php 
        endforeach;
    else :
    ?>
     <tr>
       <td colspan="2" class="text-center text-muted p-4">
         <i>Tidak ada soal pilihan benar salah.</i>
        </td>
    </tr>
		<?php endif; ?>
		</tbody>
	</table>
   </div>
</div>

<div class="tab-pane fade" id="pills-JODOH" role="tabpanel" aria-labelledby="pills-JODOH-tab">
    <div class='table-responsive'>
        <table id="tabelJODOH" class="table">
			<tbody>
			<?php 
				$no = 0;
				$stmt = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = 4 ORDER BY nomor");
				$stmt->bindValue(':id_bank', $id_bank, PDO::PARAM_INT);
				$stmt->execute();

				$soalList = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if ($soalList) :
					$image = ['jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP'];
					$audio = ['mp3','wav','ogg','MP3','WAV','OGG'];

					foreach ($soalList as $soal) :
						$no++;
						$checked = !empty($soal['jawaban']) ? explode(',', $soal['jawaban']) : [];
						$warna   = !empty($soal['warna']) ? explode(',', $soal['warna']) : [];
						$jumlah  = count($warna);

						$warna_opsi = [];
						foreach ($checked as $index => $huruf) {
							$warna_opsi[$huruf] = $warna[$index] ?? '';
						}
			?>
        <tr>
            <td style="width:12%;text-align:center;vertical-align:top">
                <?= $no ?>
                <button data-id="<?= $soal['id_soal'] ?>" class="hapus btn-sm btn btn-outline-danger" 
                        data-toggle="tooltip" data-placement="top" title="Hapus">
                     <i class="material-icons">delete</i>
                </button>
                <a href="?pg=<?= enkripsi('editsoal5'); ?>&id_soal=<?= $soal['id_soal']; ?>"
                   class="btn btn-sm btn-outline-primary mt-1" title="Edit">
                    <i class="material-icons">edit</i>
                </a>
            </td>

            <td style="text-align:justify">
            <?php
                if (!empty($soal['fileSoal'])) :
                    $ext = pathinfo($soal['fileSoal'], PATHINFO_EXTENSION);
                    if (in_array($ext, $image)) {
                        echo "<p><img src='{$baseurl}/files/{$soal['fileSoal']}' style='max-width:120px;'/></p>";
                    } elseif (in_array($ext, $audio)) {
                        echo "<p><audio controls><source src='{$baseurl}/files/{$soal['fileSoal']}' type='audio/{$ext}'></audio></p>";
                    }
                endif;
            ?>

                <?= $soal['soal']; ?>
                <table width="100%" class="table table-bordered">
                    <tr>
                        <td class="text-center"><b>Pernyataan</b></td>
                        <td class="text-center" width="6%"></td>
                        <td class="text-center" width="6%"></td>
                        <td class="text-center"><b>Jawaban</b></td>
                    </tr>
                    <?php
                        $opsi = ['A','B','C','D','E'];
                        foreach ($opsi as $i => $huruf) :
                            $pilihan = $soal['pil'.$huruf] ?? '';
                            $perny   = $soal['per'.$huruf] ?? '';
                            $file    = $soal['file'.$huruf] ?? '';
                            if (!empty($pilihan)):
                    ?>
                    <tr>
                        <td style="background-color:<?= $warna[$i] ?? '' ?>">
                            <?= $pilihan ?>
                        </td>
                        <td> <?= $i + 1 ?> </td>
                        <td> <?= $huruf ?> </td>
                        <td style="background-color:<?= $warna_opsi[$huruf] ?? '' ?>">
                        <?php
                            if (!empty($file)) {
                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                if (in_array($ext, $image)) {
                                    echo "<img src='{$baseurl}/files/{$file}' style='max-width:100px;' />";
                                } elseif (in_array($ext, $audio)) {
                                    echo "<audio controls><source src='{$baseurl}/files/{$file}' type='audio/$ext'></audio>";
                                } else {
                                    echo "File tidak didukung!";
                                }
                            }
                        ?>
                        <?= $perny ?>
                        </td>
                    </tr>
                    <?php endif; endforeach; ?>
                </table>

                <b>Skor Max :</b> <?= $soal['max_skor']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                <b>Kunci :</b> 
                1.<?= $checked[0] ?? '' ?>
                <?php if(!empty($soal['perB'])): ?>&nbsp;&nbsp;&nbsp; 2.<?= $checked[1] ?? '' ?><?php endif; ?>
                <?php if(!empty($soal['perC'])): ?>&nbsp;&nbsp;&nbsp; 3.<?= $checked[2] ?? '' ?><?php endif; ?>
                <?php if(!empty($soal['perD'])): ?>&nbsp;&nbsp;&nbsp; 4.<?= $checked[3] ?? '' ?><?php endif; ?>
                <?php if(!empty($soal['perE'])): ?>&nbsp;&nbsp;&nbsp; 5.<?= $checked[4] ?? '' ?><?php endif; ?>
            </td>
        </tr>
    <?php 
        endforeach;
    else :
    ?>
        <tr>
            <td colspan="2" class="text-center text-muted p-4">
                <i>Tidak ada soal pilihan menjodohkan.</i>
            </td>
        </tr>
       <?php endif; ?>
       </tbody>
     </table>
   </div>
</div>

 <div class="tab-pane fade" id="pills-ESAI" role="tabpanel" aria-labelledby="pills-ESAI-tab">
    <div class="table-responsive">
        <table id="tabelESAI" class="table">
						<tbody>
						<?php 
							$no = 0; 
							$stmt = $pdo->prepare("SELECT * FROM soal WHERE id_bank = :id_bank AND jenis = 5 ORDER BY nomor");
							$stmt->bindValue(':id_bank', $id_bank, PDO::PARAM_INT);
							$stmt->execute();

							$soalList = $stmt->fetchAll(PDO::FETCH_ASSOC);

							if ($soalList) :
								$image = ['jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP'];
								$audio = ['mp3','wav','ogg','MP3','WAV','OGG'];

								foreach ($soalList as $soal) : 
									$no++; 
						?>
							<tr>
								<td style="width:12%;text-align:center;vertical-align:top">
									<?= $no ?>
									<button data-id="<?= $soal['id_soal'] ?>" 
											class="hapus btn-sm btn btn-outline-danger" 
											data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
										 <i class="material-icons">delete</i>
									</button>
									<a href="?pg=<?= enkripsi('editsoal2') ?>&id_soal=<?= $soal['id_soal'] ?>"
									  class="btn btn-sm btn-outline-primary mt-1" title="Edit">
										 <i class="material-icons">edit</i>
									</a>
								</td>

								<td style="text-align:justify">
								<?php
									if (!empty($soal['fileSoal'])) :
										$ext = pathinfo($soal['fileSoal'], PATHINFO_EXTENSION);
										if (in_array($ext, $image)) {
											echo "<p><img src='{$baseurl}/files/{$soal['fileSoal']}' style='max-width:120px;'/></p>";
										} elseif (in_array($ext, $audio)) {
											echo "<p><audio controls><source src='{$baseurl}/files/{$soal['fileSoal']}' type='audio/{$ext}'></audio></p>";
										}
									endif;
								?>

									<?= $soal['soal']; ?>
									<table width="100%">
										<tr>
											<td>
												<b>Skor Max :</b> <?= $soal['max_skor'] ?>&nbsp;&nbsp;&nbsp;&nbsp;
												<b>Kunci :</b> <?= $soal['jawaban'] ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						<?php 
								endforeach;
							else :
						?>
							<tr>
								<td colspan="2" class="text-center text-muted p-4">
									<i>Tidak ada soal pilihan esai / uraian singkat.</i>
								</td>
							</tr>
						<?php endif; ?>
						</tbody>
						  </table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
		
<script>
$('#tabelPG').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data Soal akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '<?= $baseurl ?>/mycbt/bank/tbanksoal.php?pg=hapussoal',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>
<script>
$('#tabelESAI').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data Soal akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '<?= $baseurl ?>/mycbt/bank/tbanksoal.php?pg=hapussoal',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>
<script>
$('#tabelJODOH').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data Soal akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '<?= $baseurl ?>/mycbt/bank/tbanksoal.php?pg=hapussoal',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>
<script>
$('#tabelBS').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data Soal akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '<?= $baseurl ?>/mycbt/bank/tbanksoal.php?pg=hapussoal',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>
<script>
$('#tabelMULTI').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data Soal akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '<?= $baseurl ?>/mycbt/bank/tbanksoal.php?pg=hapussoal',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>

<script>
$("#btnreset").click(function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data Soal akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '<?= $baseurl ?>/mycbt/bank/tbanksoal.php?pg=kosongsoal',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>

										
										