 <link rel='stylesheet' href='siswa/sandik.css' />
 <style>
 /* DEFAULT: Desktop */
.desktop-only {
    display: block;
}
.mobile-only {
    display: none;
}

/* Bar bawah (desktop) */
.box-footer-bottom {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #fff;
    border-top: 1px solid #ccc;
    padding: 12px;
    z-index: 999;
}

/* Bar atas (mobile) */
.box-footer-top {
    position: fixed;
    top: 60px;
    left: 0;
    width: 100%;
    background: #fff;
    border-bottom: 1px solid #ccc;
    padding: 20px;
    z-index: 999;
}

/* MOBILE mode */
@media (max-width: 768px) {
    .desktop-only {
        display: none !important;
    }
    .mobile-only {
        display: block !important;
    }

    /* beri jarak agar soal tidak ketutup */
    body {
        padding-top: 90px;
    }
}
</style>
<?php
session_start();
require("konek/koneksi.php");
require("konek/function.php");
require("konek/crud.php");

$id_bank  = isset($_POST['id_bank']) ? intval($_POST['id_bank']) : 0;
$id_siswa = isset($_POST['id_siswa']) ? intval($_POST['id_siswa']) : 0;
$ac       = isset($_POST['idu']) ? intval($_POST['idu']) : 0;
$pg       = $_POST['pg'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM ujian WHERE id_jadwal = :id_jadwal");
$stmt->execute([':id_jadwal' => $ac]);
$mapel = $stmt->fetch(PDO::FETCH_ASSOC);

$waktumu = date('Y-m-d H:i:s');
$stmt_update = $pdo->prepare("UPDATE nilai SET ujian_berlangsung = :waktumu WHERE id_ujian = :id_ujian AND id_siswa = :id_siswa");
$stmt_update->execute([
    ':waktumu'  => $waktumu,
    ':id_ujian' => $ac,
    ':id_siswa' => $id_siswa
]);

$stmt_nilai = $pdo->prepare("SELECT * FROM nilai WHERE id_ujian = :id_ujian AND id_siswa = :id_siswa");
$stmt_nilai->execute([':id_ujian' => $ac, ':id_siswa' => $id_siswa]);
$nilai = $stmt_nilai->fetch(PDO::FETCH_ASSOC);

$ujian_berlangsung = $nilai['ujian_berlangsung'] ?? date('Y-m-d H:i:s');
$ujian_mulai       = $nilai['ujian_mulai'] ?? date('Y-m-d H:i:s');
$habis             = strtotime($ujian_berlangsung) - strtotime($ujian_mulai);
$lamaujian         = ($mapel['lama_ujian'] ?? 0) * 60;

if (!empty($nilai['ujian_selesai'])) {
    jump("$baseurl");
    exit;
}

$no_soal = isset($_POST['no_soal']) ? intval($_POST['no_soal']) : 0;

$audio = ['mp3','wav','ogg','MP3','WAV','OGG'];
$image = ['jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP'];

if (!isset($_SESSION['soal_acak'][$id_bank])) {
    $stmt_soal = $pdo->prepare("SELECT id_soal FROM soal WHERE id_bank = :id_bank");
    $stmt_soal->execute([':id_bank' => $id_bank]);
    $soal_ids = $stmt_soal->fetchAll(PDO::FETCH_COLUMN);

    shuffle($soal_ids);
    $_SESSION['soal_acak'][$id_bank] = $soal_ids;
}

$soal_ids = $_SESSION['soal_acak'][$id_bank];
$total = count($soal_ids);

if ($no_soal < 0) $no_soal = 0;
if ($no_soal >= $total) $no_soal = $total - 1;

$id_soal = $soal_ids[$no_soal];

$stmt_soal_detail = $pdo->prepare("SELECT * FROM soal WHERE id_soal = :id_soal LIMIT 1");
$stmt_soal_detail->execute([':id_soal' => $id_soal]);
$soal = $stmt_soal_detail->fetch(PDO::FETCH_ASSOC);

$no_prev = max(0, $no_soal - 1);
$no_next = min($total - 1, $no_soal + 1);

$stmt_jawaban = $pdo->prepare("SELECT * FROM jawaban WHERE id_siswa = :id_siswa AND id_bank = :id_bank AND id_soal = :id_soal");
$stmt_jawaban->execute([
    ':id_siswa' => $id_siswa,
    ':id_bank'  => $id_bank,
    ':id_soal'  => $soal['id_soal']
]);
$jawab = $stmt_jawaban->fetch(PDO::FETCH_ASSOC);
?>


<div class="box-footer-top mobile-only">
    <table width='100%'>
        <tr>
            <td style="text-align:center">
                <?php if ($no_soal > 0): ?>
                    <button class='btn btn-primary' onclick="loadsoal(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $no_prev ?>)">
                        Prev
                    </button>
                <?php else: ?>
                    <button class='btn btn-dark' disabled>
                         Prev
                    </button>
                <?php endif; ?>
            </td>

            <td style="text-align:center"></td>

            <td style="text-align:center">
                <?php if ($no_soal < $total - 1): ?>
                    <button class='btn btn-success' onclick="loadsoal(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $no_next ?>)">
                        Next
                    </button>
                <?php else: ?>
                    <input type='submit' name='done' id='selesai-submit' style='display:none;' />
					<button class='done-btn btn btn-danger' >Selesai</button>
				<?php endif; ?>
            </td>
        </tr>
    </table>
</div>
<?php if ($pg == 'soal'): ?>

<div class='card-body'>
<div class='row'>
<div class='col-md-12' style="text-align:center"> 
<?php
if ($soal['fileSoal'] <> '') {
$ext = explode(".", $soal['fileSoal']);
$ext = end($ext);
if (in_array($ext, $image)) {
echo "<span  id='zoom' style='display:inline-block'> <img  src='$baseurl/files/$soal[fileSoal]' style='max-width:50%;'></span>";
} elseif (in_array($ext, $audio)) {
echo "<audio controls='controls' ><source src='$baseurl/files/$soal[fileSoal]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
} else {
echo "File tidak didukung!";
}
}
?>
</div>
<div class='col-md-12'>
<div class='callout soal'>						 
<div class='soaltanya animated fadeIn' style="text-align:justify"><?= $soal['soal'] ?> </div>
</div>					
</div>
<div class='col-md-12'>
<?php if ($soal['jenis'] == 1) : ?>
<?php
$a = ($jawab['jawaban'] == 'A') ? 'checked' : '';
$b = ($jawab['jawaban'] == 'B') ? 'checked' : '';
$c = ($jawab['jawaban'] == 'C') ? 'checked' : '';
$d = ($jawab['jawaban'] == 'D') ? 'checked' : '';
$e = ($jawab['jawaban'] == 'E') ? 'checked' : '';
?>
<table width='100%' class='table'>
<tr>
<td width='60'>
<input class='hidden radio-label' type='radio' name='jawab' id='A' onclick="jawabsoal(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'A','1')" <?= $a ?> />
<label class='button-label' for='A'>
<h1>A</h1>
</label>
</td>
<td style='vertical-align:middle;'>
<span class='soal'><?= $soal['pilA'] ?></span>
	<?php
	if ($soal['fileA'] <> '') {
		$ext = explode(".", $soal['fileA']);
		$ext = end($ext);
		if (in_array($ext, $image)) {
			echo "<img src='$baseurl/files/$soal[fileA]' class='img-responsive' style='max-width:50%;'/>";
		} elseif (in_array($ext, $audio)) {
			echo "<audio controls='controls'><source src='$baseurl/files/$soal[fileA]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
		} else {
			echo "File tidak didukung!";
		}
	}
	?>
</td>
</tr>
<?php if ($soal['pilB'] <>'') { ?>
<tr>
<td>
	<input class='hidden radio-label' type='radio' name='jawab' id='B' onclick="jawabsoal(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'B','1')" <?= $b ?> />
	<label class='button-label' for='B'>
		<h1>B</h1>
	</label>
</td>
<td style='vertical-align:middle;'>
	<span class='soal'><?= $soal['pilB'] ?></span>
	<?php
	if ($soal['fileB'] <> '') {
		$ext = explode(".", $soal['fileB']);
		$ext = end($ext);
		if (in_array($ext, $image)) {
			echo "<img src='$baseurl/files/$soal[fileB]' class='img-responsive' style='max-width:50%;'/>";
		} elseif (in_array($ext, $audio)) {
			echo "<audio controls='controls' ><source src='$baseurl/files/$soal[fileB]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
		} else {
			echo "File tidak didukung!";
		}
	}
	?>
</td>
</tr>
<?php } ?>
<?php if ($soal['pilC'] <>'') { ?>
<tr>
<td>
	<input class='hidden radio-label' type='radio' name='jawab' id='C' onclick="jawabsoal(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'C','1')" <?= $c ?> />
	<label class='button-label' for='C'>
		<h1>C</h1>
	</label>

</td>
<td style='vertical-align:middle;'>
	<span class='soal'><?= $soal['pilC'] ?></span>
	<?php
	if ($soal['fileC'] <> '') {
		$ext = explode(".", $soal['fileC']);
		$ext = end($ext);
		if (in_array($ext, $image)) {
			echo "<img src='$baseurl/files/$soal[fileC]' class='img-responsive' style='max-width:50%;'/>";
		} elseif (in_array($ext, $audio)) {
			echo "<audio controls='controls' ><source src='$baseurl/files/$soal[fileC]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
		} else {
			echo "File tidak didukung!";
		}
	}
	?>
</td>
</tr>
<?php } ?>
<?php if ($soal['pilD'] <>'') { ?>
<tr>
	<td>
		<input class='hidden radio-label' type='radio' name='jawab' id='D' onclick="jawabsoal(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'D','1')" <?= $d ?> />
		<label class='button-label' for='D'>
			<h1>D</h1>
		</label>
	</td>
	<td style='vertical-align:middle;'>
		<span class='soal'><?= $soal['pilD'] ?></span>
		<?php
		if ($soal['fileD'] <> '') {
			$ext = explode(".", $soal['fileD']);
			$ext = end($ext);
			if (in_array($ext, $image)) {
				echo "<img src='$baseurl/files/$soal[fileD]' class='img-responsive' style='max-width:50%;'/>";
			} elseif (in_array($ext, $audio)) {
				echo "<audio controls='controls' ><source src='$baseurl/files/$soal[fileD]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
			} else {
				echo "File tidak didukung!";
			}
		}
		?>
	</td>
</tr>
<?php } ?>
<?php if  ($soal['pilE'] <>'') { ?>
<tr>
	<td>
		<input class='hidden radio-label' type='radio' name='jawab' id='E' onclick="jawabsoal(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'E','1')" <?= $e ?> />
		<label class='button-label' for='E'>
			<h1>E</h1>
		</label>
	</td>
	<td style='vertical-align:middle;'>
		<span class='soal'><?= $soal['pilE'] ?></span>
		<?php
		if ($soal['fileE'] <> '') {
		 
			$ext = explode(".", $soal['fileE']);
			$ext = end($ext);
			if (in_array($ext, $image)) {
				echo "<img src='$baseurl/files/$soal[fileE]' class='img-responsive' style='max-width:50%;'/>";
			} elseif (in_array($ext, $audio)) {
				echo "<audio controls='controls' ><source src='$baseurl/files/$soal[fileE]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
			} else {
				echo "File tidak didukung!";
			}
		}
		?>
	</td>
</tr>
<?php } ?>
</table> 

<?php elseif ($soal['jenis'] == 2) : ?>
<?php $checked = explode(',',$jawab['jawaban']); ?>
<table width='100%' class='table'>								 
<tr>
<td width='60'>
	<label style="margin-top:0px" class="checkbox"> 
	<input type='checkbox' name='jawab[]' value="A" onclick="jawabmulti(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>, 'A', 2)" <?php in_array ('A', $checked) ? print 'checked' : ''; ?>>
	 <span class="check"></span>
	   </label>
</td>
<td style='vertical-align:middle;'>
 <?php
	if ($soal['fileA'] <> '') {
	$ext = explode(".", $soal['fileA']);
	$ext = end($ext);
	if (in_array($ext, $image)) {
	echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileA]' style='max-width:50%;'/></span>";
	} elseif (in_array($ext, $audio)) {
	 echo "<audio controls><source src='$baseurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
		} else {
		  echo "File tidak didukung!";
		}
		echo "<br>";
	   }
	 ?>
					 
	<span class='soal'><?= $soal['pilA'] ?></span>
</td>
</tr>
 <?php if ($soal['pilB'] <>'') { ?>
<tr>
<td>
   <label style="margin-top:0px" class="checkbox">
	   <input type='checkbox' name='jawab[]' value="B" onclick="jawabmulti(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>, 'B', 2)" <?php in_array ('B', $checked) ? print 'checked' : ''; ?>>
	 <span class="check"></span>
	   </label>
</td>
<td style='vertical-align:middle;'>
<?php
							
if ($soal['fileB'] <> '') {
	 $ext = explode(".", $soal['fileB']);
	 $ext = end($ext);
	 if (in_array($ext, $image)) {
	echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileB]' style='max-width:50%;'/></span>";
	} elseif (in_array($ext, $audio)) {
   echo "<audio controls><source src='$baseurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
	} else {
	  echo "File tidak didukung!";
		  }
		  echo "<br>";
		 }
		 ?>

	 <span class='soal'><?= $soal['pilB'] ?></span>
</td>
</tr>
<?php } ?>
<?php if ($soal['pilC'] <>'') { ?>
<tr>
<td>
	 <label style="margin-top:0px" class="checkbox">
		 <input type='checkbox' name='jawab[]' value="C" onclick="jawabmulti(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>, 'C', 2)" <?php in_array ('C', $checked) ? print 'checked' : ''; ?>>
	<span class="check"></span>
	   </label>
</td>
<td style='vertical-align:middle;'>
	
  <?php
   if ($soal['fileC'] <> '') {
   $ext = explode(".", $soal['fileC']);
   $ext = end($ext);
   if (in_array($ext, $image)) {
   echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileC]' style='max-width:50%;'/></span>";
   } elseif (in_array($ext, $audio)) {
   echo "<audio controls><source src='$baseurl/files/$soal[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
   } else {
   echo "File tidak didukung!";
	 }
	 echo "<br>";
	 }
	?>
	
<span class='soal'><?= $soal['pilC'] ?></span>
</td>

</tr>
<?php } ?>
<?php if ($soal['pilD'] <>'') { ?>
<tr>
	<td>
	   <label style="margin-top:0px" class="checkbox"> 
		  <input type='checkbox' name='jawab[]' value="D" onclick="jawabmulti(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>, 'D', 2)" <?php in_array ('D', $checked) ? print 'checked' : ''; ?>>
	<span class="check"></span>
	   </label>
	</td>
	<td style='vertical-align:middle;'>
		<?php
		  if ($soal['fileD'] <> '') {
			$ext = explode(".", $soal['fileD']);
			$ext = end($ext);
		   if (in_array($ext, $image)) {
			 echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileD]' style='max-width:50%;'/></span>";
			  } elseif (in_array($ext, $audio)) {
			 echo "<audio controls><source src='$baseurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
		  } else {
			 echo "File tidak didukung!";
			 }
		   echo "<br>";
			}
		  ?>    																
	<span class='soal'><?= $soal['pilD'] ?></span>
	</td>
</tr>
<?php } ?>
<?php if ($soal['pilE'] <>'') { ?>
<tr>
	<td>
	  <label style="margin-top:0px" class="checkbox">  
		  <input type='checkbox' name='jawab[]' value="E" onclick="jawabmulti(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>, 'E', 2)" <?php in_array ('E', $checked) ? print 'checked' : ''; ?>>
	 <span class="check"></span>
	   </label>
	</td>
	<td style='vertical-align:middle;'>
	   
		<?php
		if ($soal['fileE'] <> '') {
			$ext = explode(".", $soal['fileE']);
			$ext = end($ext);
			if (in_array($ext, $image)) {
				echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileE]' style='max-width:50%;'/></span>";
			} elseif (in_array($ext, $audio)) {
				echo "<audio controls='controls' ><source src='$baseurl/files/$soal[fileE]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
			} else {
				echo "File tidak didukung!";
			}
			echo "<br>";
		}
		?>												
		 <span class='soal'><?= $soal['pilE'] ?></span>
	</td>											
</tr>
<?php } ?>
</table>
<?php elseif ($soal['jenis'] == 3) : ?>
<?php $checked = explode(',',$jawab['jawaban']); ?>
<table width='100%' class='table'>
<?php if ($soal['pilA']<>''){ ?>
<tr style='vertical-align:middle;'>
	<td><b>Pernyataan</b></td>
	<td class="text-center" width="5%" ><b>Benar</b></td>
	<td class="text-center" width="5%" ><b>Salah</b></td>
</tr>
	<?php }else{ ?>
<tr>
	<td class="text-center" width="5%" ><b>Benar</b></td>
	<td class="text-center" width="5%" ><b>Salah</b></td>
</tr>
<?php } ?>
<?php if ($soal['pilA'] <>'') : ?>
 <tr style='vertical-align:middle;'>		
	<td style='vertical-align:middle;'>
		<?php
		   if ($soal['fileA'] <> '') {
			$ext = explode(".", $soal['fileA']);
			$ext = end($ext);
			if (in_array($ext, $image)) {
			echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileA]' style='max-width:50%;'/></span>";
			   } elseif (in_array($ext, $audio)) {
			 echo "<audio controls><source src='$baseurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
				} else {
			 echo "File tidak didukung!";
				 }
			 }
			 ?>
			<span class='soal'><?= $soal['pilA'] ?></span>
		</td>
		<td class="text-center">
			  <label class="radio">
				<input type="radio" name="jawab[<?= $no_next ?>][0]"  value="B"
					   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
					   <?php if($checked[0]=='B') echo 'checked'; ?>>
				<span class="check"></span>
			  </label>
			</td>
			<td class="text-center">
			  <label class="radio">
				<input type="radio" name="jawab[<?= $no_next ?>][0]" value="S"
					   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
					   <?php if($checked[0]=='S') echo 'checked'; ?>>
				<span class="check"></span>
			  </label>
			</td>														
		</tr>
		<?php endif; ?>
					
					  <?php if ($soal['pilB'] <>'') : ?>
					 
					<tr style='vertical-align:middle;'>										
						<td style='vertical-align:middle;'>
					<?php                                              
							if ($soal['fileB'] <> '') {
								$ext = explode(".", $soal['fileB']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileB]' style='max-width:100%;'/></span>";
								} elseif (in_array($ext, $audio)) {
									echo "<audio controls><source src='$baseurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
								} else {
									echo "File tidak didukung!";
								}
							}
							?>
						
					<span class='soal'><?= $soal['pilB'] ?></span>
					</td>					
					<td class="text-center">
					  <label class="radio">
						<input type="radio" name="jawab[<?= $no_next ?>][1]"  value="B"
							   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
							   <?php if($checked[1]=='B') echo 'checked'; ?>>
						<span class="check"></span>
					  </label>
					</td>
						<td class="text-center">
						  <label class="radio">
							<input type="radio" name="jawab[<?= $no_next ?>][1]" value="S"
								   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
								   <?php if($checked[1]=='S') echo 'checked'; ?>>
							<span class="check"></span>
						  </label>
						</td>																
					</tr>
					<?php endif; ?>
					
					  <?php if ($soal['pilC'] <>'') : ?>
					  
					<tr style='vertical-align:middle;'>
						<td style='vertical-align:middle;'>
					<?php
							
					if ($soal['fileC'] <> '') {
					 $ext = explode(".", $soal['fileC']);
					 $ext = end($ext);
					  if (in_array($ext, $image)) {
					  echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileC]' style='max-width:100%;'/></span>";
					   } elseif (in_array($ext, $audio)) {
					   echo "<audio controls><source src='$baseurl/files/$soal[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
					  } else {
					   echo "File tidak didukung!";
						   }
						}
					?>
							<span class='soal'><?= $soal['pilC'] ?></span>
					</td>
					<td class="text-center">
					  <label class="radio">
						<input type="radio" name="jawab[<?= $no_next ?>][2]"  value="B"
							   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
							   <?php if($checked[2]=='B') echo 'checked'; ?>>
						<span class="check"></span>
					  </label>
					</td>
						<td class="text-center">
						  <label class="radio">
							<input type="radio" name="jawab[<?= $no_next ?>][2]" value="S"
								   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
								   <?php if($checked[2]=='S') echo 'checked'; ?>>
							<span class="check"></span>
						  </label>
						</td>																
					</tr>
					<?php endif; ?>
					
					  <?php if ($soal['pilD'] <>'') : ?>
					  
					<tr style='vertical-align:middle;'>
						<td style='vertical-align:middle;'>
					<?php
							
							if ($soal['fileD'] <> '') {
								$ext = explode(".", $soal['fileD']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileD]' style='max-width:100%;'/></span>";
								} elseif (in_array($ext, $audio)) {
									echo "<audio controls><source src='$baseurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
								} else {
									echo "File tidak didukung!";
								}
							}
							?>
						<span class='soal'><?= $soal['pilD'] ?></span>
					
					</td>
					<td class="text-center">
					  <label class="radio">
						<input type="radio" name="jawab[<?= $no_next ?>][3]"  value="B"
							   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
							   <?php if($checked[3]=='B') echo 'checked'; ?>>
						<span class="check"></span>
					  </label>
					</td>
						<td class="text-center">
						  <label class="radio">
							<input type="radio" name="jawab[<?= $no_next ?>][3]" value="S"
								   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
								   <?php if($checked[3]=='S') echo 'checked'; ?>>
							<span class="check"></span>
						  </label>
						</td>																
					</tr>
					<?php endif; ?>
					
					 <?php if ($soal['pilE'] <>'') : ?>
					 
					<tr style='vertical-align:middle;'>
						<td style='vertical-align:middle;'>
					<?php
							
							if ($soal['fileE'] <> '') {
								$ext = explode(".", $soal['fileE']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									 echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileE]' style='max-width:100%;'/></span>";
								} elseif (in_array($ext, $audio)) {
									echo "<audio controls><source src='$baseurl/files/$soal[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
								} else {
									echo "File tidak didukung!";
								}
							}
							?>
							<span class='soal'><?= $soal['pilE'] ?></span>
					</td>
					<td class="text-center">
					  <label class="radio">
						<input type="radio" name="jawab[<?= $no_next ?>][4]"  value="B"
							   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
							   <?php if($checked[4]=='B') echo 'checked'; ?>>
						<span class="check"></span>
					  </label>
					</td>
						<td class="text-center">
						  <label class="radio">
							<input type="radio" name="jawab[<?= $no_next ?>][4]" value="S"
								   onchange="jawabbs(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, '3', <?= $no_next ?>)"
								   <?php if($checked[4]=='S') echo 'checked'; ?>>
							<span class="check"></span>
						  </label>
						</td>															
					</tr>
					<?php endif; ?>															
				</table>
	<?php elseif ($soal['jenis'] == 4) : ?>
	  <?php 
		$jawabanTersimpan = isset($jawab['jawaban']) ? $jawab['jawaban'] : '';
		$warnaTersimpan   = isset($jawab['warna']) ? $jawab['warna'] : '';
		?>

		<div class="container" id="container<?= $soal['id_soal'] ?>">
		  <div class="column" id="pernyataan<?= $soal['id_soal'] ?>">
			<b>Pernyataan</b>
			<?php if ($soal['pilA'] != '') : ?>
			  <div class="item" data-label="A" data-color="#00BCD4">
			  <?= $soal['pilA'] ?>
			  <?php
		   if ($soal['fileA'] <> '') {
			$ext = explode(".", $soal['fileA']);
			$ext = end($ext);
			if (in_array($ext, $image)) {
			echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileA]' style='max-width:50%;'/></span>";
			   } elseif (in_array($ext, $audio)) {
			 echo "<audio controls><source src='$baseurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
				} else {
			 echo "File tidak didukung!";
				 }
			 }
			 ?>
			  </div>
			<?php endif; ?>
			<?php if ($soal['pilB'] != '') : ?>
			  <div class="item" data-label="B" data-color="#F44336">
			  <?= $soal['pilB'] ?>
			  <?php                                              
				if ($soal['fileB'] <> '') {
				   $ext = explode(".", $soal['fileB']);
				   $ext = end($ext);
				   if (in_array($ext, $image)) {
					 echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileB]' style='max-width:100%;'/></span>";
				   } elseif (in_array($ext, $audio)) {
					 echo "<audio controls><source src='$baseurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
					} else {
					  echo "File tidak didukung!";
						 }
					  }
				?>
			  </div>
			<?php endif; ?>
			<?php if ($soal['pilC'] != '') : ?>
			  <div class="item" data-label="C" data-color="#4CAF50">
			  <?= $soal['pilC'] ?>
			  <?php
							
					if ($soal['fileC'] <> '') {
					 $ext = explode(".", $soal['fileC']);
					 $ext = end($ext);
					  if (in_array($ext, $image)) {
					  echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileC]' style='max-width:100%;'/></span>";
					   } elseif (in_array($ext, $audio)) {
					   echo "<audio controls><source src='$baseurl/files/$soal[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
					  } else {
					   echo "File tidak didukung!";
						   }
						}
					?>
			  </div>
			<?php endif; ?>
			<?php if ($soal['pilD'] != '') : ?>
			  <div class="item" data-label="D" data-color="#FF9800">
			  <?= $soal['pilD'] ?>
			  <?php
							
							if ($soal['fileD'] <> '') {
								$ext = explode(".", $soal['fileD']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileD]' style='max-width:100%;'/></span>";
								} elseif (in_array($ext, $audio)) {
									echo "<audio controls><source src='$baseurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
								} else {
									echo "File tidak didukung!";
								}
							}
							?>
			  </div>
			<?php endif; ?>
			<?php if ($soal['pilE'] != '') : ?>
			  <div class="item" data-label="E" data-color="#0277BD">
			  <?= $soal['pilE'] ?>
			  <?php
							
							if ($soal['fileE'] <> '') {
								$ext = explode(".", $soal['fileE']);
								$ext = end($ext);
								if (in_array($ext, $image)) {
									 echo "<span  class='lup' style='display:inline-block'><img src='$baseurl/files/$soal[fileE]' style='max-width:100%;'/></span>";
								} elseif (in_array($ext, $audio)) {
									echo "<audio controls><source src='$baseurl/files/$soal[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
								} else {
									echo "File tidak didukung!";
								}
							}
							?>
			  </div>
			<?php endif; ?>
		  </div>

		  <div class="column" id="pilihan<?= $soal['id_soal'] ?>">
			<b>Pilihan Jawaban</b>
			<?php if ($soal['perA'] != '') : ?>
			  <div class="item" data-pilihan="A"><?= $soal['perA'] ?></div>
			<?php endif; ?>
			<?php if ($soal['perB'] != '') : ?>
			  <div class="item" data-pilihan="B"><?= $soal['perB'] ?></div>
			<?php endif; ?>
			<?php if ($soal['perC'] != '') : ?>
			  <div class="item" data-pilihan="C"><?= $soal['perC'] ?></div>
			<?php endif; ?>
			<?php if ($soal['perD'] != '') : ?>
			  <div class="item" data-pilihan="D"><?= $soal['perD'] ?></div>
			<?php endif; ?>
			<?php if ($soal['perE'] != '') : ?>
			  <div class="item" data-pilihan="E"><?= $soal['perE'] ?></div>
			<?php endif; ?>
		  </div>												  
		</div>
		  
		<div class="text-center mt-1 mb-3">
		<div class="mb-3"></div>
		  <button class="btn btn-danger  reset-jodoh" data-idsoal="<?= $soal['id_soal'] ?>">
			<i class="fa fa-undo"></i> Reset Jawaban
		  </button>
		</div>
		<br><br><br>
		<script>
		(function() {
		  const idsoal = <?= $soal['id_soal'] ?>;
		  let activeColor = null;
		  let activePernyataan = null;
		  let jawabanJodoh = [];
		  let warnaJodoh = [];

		
		  const jawabanTersimpan = "<?= $jawabanTersimpan ?>";
		  const warnaTersimpan   = "<?= $warnaTersimpan ?>";

		  if (jawabanTersimpan && warnaTersimpan) {
			const arrJawaban = jawabanTersimpan.split(',');
			const arrWarna   = warnaTersimpan.split(',');

			arrJawaban.forEach((pil, i) => {
			  const warna = arrWarna[i] || '#ccc';

			  $('#pilihan' + idsoal + ' .item[data-pilihan="' + pil + '"]').css('background-color', warna);

			  
			  const perItem = $('#pernyataan' + idsoal + ' .item').eq(i);
			  perItem.css({'background-color': warna, 'outline': '2px solid #fff'});
			});
		  }

		  $(document).on('click', '#pernyataan' + idsoal + ' .item', function() {
			$('#pernyataan' + idsoal + ' .item').css('outline', 'none');
			const color = $(this).data('color');
			$(this).css({'background-color': color, 'outline': '2px solid #fff'});
			activeColor = color;
			activePernyataan = $(this);
		  });

		 
		  $(document).on('click', '#pilihan' + idsoal + ' .item', function() {
			if (activeColor && activePernyataan) {
			  const pilihan = $(this).data('pilihan');
			  $(this).css('background-color', activeColor);

			  jawabanJodoh.push(pilihan);
			  warnaJodoh.push(activeColor);

			  const jawabanString = jawabanJodoh.join(',');
			  const warnaString = warnaJodoh.join(',');

			  simpanJawabanJodoh(
				<?= $id_bank ?>,
				<?= $id_siswa ?>,
				idsoal,
				4,
				jawabanString,
				warnaString
			  );
			}
		  });

		  
		  $(document).on('click', '.reset-jodoh[data-idsoal="' + idsoal + '"]', function() {
			$('#pernyataan' + idsoal + ' .item, #pilihan' + idsoal + ' .item').css({
			  'background-color': '',
			  'outline': 'none'
			});
			jawabanJodoh = [];
			warnaJodoh = [];
			activeColor = null;
			activePernyataan = null;

			simpanJawabanJodoh(
			  <?= $id_bank ?>,
			  <?= $id_siswa ?>,
			  idsoal,
			  4,
			  '',
			  ''
			);
			
		  });
		})();
		</script>
<?php elseif ($soal['jenis'] == 5) : ?>
   <br>
	  <b> Isi Jawaban </b>
	  <textarea id='jawabesai' name='textjawab' rows="5" class='form-control' onchange="jawabesai(<?= $id_bank ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,5)"><?= $jawab['jawaban'] ?></textarea>
<?php endif; ?>				   
</div>
<div class="box-footer-bottom desktop-only">
	<table width='100%'>
		<tr>
			<td style="text-align:center">
				<?php if ($no_soal > 0): ?>
					<button id='move-prev' class='btn btn-primary' onclick="loadsoal(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $no_prev ?>)">
						<i class='material-icons' style="vertical-align:middle">chevron_left</i> Prev
					</button>
				<?php else: ?>
				<button id='move-prev' class='btn btn-dark' disabled>
						<i class='material-icons' style="vertical-align:middle">chevron_left</i> Prev
					</button>
				<?php endif; ?>
			</td>

			<td style="text-align:center">
				
			</td>

			<td style="text-align:center">
				<?php if ($no_soal < $total - 1): ?>
					<button id='move-next' class='btn btn-success' onclick="loadsoal(<?= $id_bank ?>, <?= $id_siswa ?>, <?= $no_next ?>)">
						Next &nbsp; <i class='material-icons' style="vertical-align:middle">chevron_right</i>
					</button>
				<?php else: ?>
				<input type='submit' name='done' id='selesai-submit' style='display:none;' />
					<button class='done-btn btn btn-danger' >Selesai</button>
				<?php endif; ?>
			</td>
		</tr>
	</table>
</div>
<?php elseif ($pg == 'jawab'): ?>
<?php
$id_bank  = filter_input(INPUT_POST, 'id_bank', FILTER_VALIDATE_INT);
$id_siswa = filter_input(INPUT_POST, 'id_siswa', FILTER_VALIDATE_INT);
$id_soal  = filter_input(INPUT_POST, 'id_soal', FILTER_VALIDATE_INT);
$jawaban  = $_POST['jawaban'] ?? '';
$jenis    = filter_input(INPUT_POST, 'jenis', FILTER_VALIDATE_INT);

if (!$id_bank || !$id_siswa || !$id_soal || !$jenis) {
    die("Data tidak valid.");
}

try {
   
    $stmt_check = $pdo->prepare("
        SELECT COUNT(*) FROM jawaban 
        WHERE id_siswa = :id_siswa AND id_bank = :id_bank AND id_soal = :id_soal AND jenis = :jenis
    ");
    $stmt_check->execute([
        ':id_siswa' => $id_siswa,
        ':id_bank' => $id_bank,
        ':id_soal' => $id_soal,
        ':jenis' => $jenis
    ]);
    $cekjawaban = (int)$stmt_check->fetchColumn();

    if ($cekjawaban == 0) {
        
        $stmt_insert = $pdo->prepare("
            INSERT INTO jawaban (id_siswa, id_bank, id_soal, jawaban, jenis)
            VALUES (:id_siswa, :id_bank, :id_soal, :jawaban, :jenis)
        ");
        $stmt_insert->execute([
            ':id_siswa' => $id_siswa,
            ':id_bank' => $id_bank,
            ':id_soal' => $id_soal,
            ':jawaban' => $jawaban,
            ':jenis' => $jenis
        ]);
    } else {
        
        $stmt_update = $pdo->prepare("
            UPDATE jawaban 
            SET jawaban = :jawaban, jenis = :jenis
            WHERE id_siswa = :id_siswa AND id_bank = :id_bank AND id_soal = :id_soal
        ");
        $stmt_update->execute([
            ':jawaban' => $jawaban,
            ':jenis' => $jenis,
            ':id_siswa' => $id_siswa,
            ':id_bank' => $id_bank,
            ':id_soal' => $id_soal
        ]);
    }

    $stmt_soal = $pdo->prepare("SELECT jawaban, max_skor FROM soal WHERE id_soal = :id_soal");
    $stmt_soal->execute([':id_soal' => $id_soal]);
    $soale = $stmt_soal->fetch(PDO::FETCH_ASSOC);

    $stmt_jawab = $pdo->prepare("SELECT jawaban FROM jawaban WHERE id_soal = :id_soal AND id_siswa = :id_siswa");
    $stmt_jawab->execute([':id_soal' => $id_soal, ':id_siswa' => $id_siswa]);
    $jawabane = $stmt_jawab->fetch(PDO::FETCH_ASSOC);

    if ($soale && $jawabane) {
        $skore_per_soal = ($soale['jawaban'] == $jawabane['jawaban']) ? (float)$soale['max_skor'] : 0;

        $stmt_update_jawaban = $pdo->prepare("
            UPDATE jawaban
            SET skor = :skor
            WHERE id_soal = :id_soal AND id_siswa = :id_siswa AND id_bank = :id_bank
        ");
        $stmt_update_jawaban->execute([
            ':skor' => $skore_per_soal,
            ':id_soal' => $id_soal,
            ':id_siswa' => $id_siswa,
            ':id_bank' => $id_bank
        ]);

        $stmt_sum = $pdo->prepare("
            SELECT SUM(skor) FROM jawaban 
            WHERE id_siswa = :id_siswa AND id_bank = :id_bank
        ");
        $stmt_sum->execute([':id_siswa' => $id_siswa, ':id_bank' => $id_bank]);
        $total_skor = (float)$stmt_sum->fetchColumn();

        $stmt_max = $pdo->prepare("SELECT SUM(max_skor) FROM soal WHERE id_bank = :id_bank");
        $stmt_max->execute([':id_bank' => $id_bank]);
        $total_max = (float)$stmt_max->fetchColumn();

        $nilai_akhir = ($total_max > 0) ? ($total_skor / $total_max) * 100 : 0;

        $stmt_update_nilai = $pdo->prepare("
            UPDATE nilai
            SET skor = :total_skor, nilai = :nilai_akhir
            WHERE id_siswa = :id_siswa AND id_bank = :id_bank
        ");
        $stmt_update_nilai->execute([
            ':total_skor' => $total_skor,
            ':nilai_akhir' => $nilai_akhir,
            ':id_siswa' => $id_siswa,
            ':id_bank' => $id_bank
        ]);
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>


<?php elseif ($pg == 'multi'): ?>
<?php
$id_siswa = $_POST['id_siswa'] ?? 0;
$id_bank  = $_POST['id_bank'] ?? 0;
$id_soal  = $_POST['id_soal'] ?? 0;
$jenis    = $_POST['jenis'] ?? 0;

$jawab = isset($_POST['jawaban']) ? implode(',', $_POST['jawaban']) : '';

if (!$id_siswa || !$id_bank || !$id_soal || !$jenis) {
    die("Data tidak valid.");
}

try {
    
    $stmt_check = $pdo->prepare("
        SELECT 1 FROM jawaban WHERE id_siswa = :id_siswa AND id_soal = :id_soal AND jenis = :jenis
    ");
    $stmt_check->execute([
        ':id_siswa' => $id_siswa,
        ':id_soal' => $id_soal,
        ':jenis' => $jenis
    ]);
    $exists = $stmt_check->fetchColumn();

    if ($exists) {
        
        $stmt_update = $pdo->prepare("
            UPDATE jawaban 
            SET jawaban = :jawaban 
            WHERE id_siswa = :id_siswa AND id_soal = :id_soal AND jenis = :jenis
        ");
        $stmt_update->execute([
            ':jawaban' => $jawab,
            ':id_siswa' => $id_siswa,
            ':id_soal' => $id_soal,
            ':jenis' => $jenis
        ]);
    } else {
       
        $stmt_insert = $pdo->prepare("
            INSERT INTO jawaban (id_siswa, id_bank, id_soal, jawaban, jenis)
            VALUES (:id_siswa, :id_bank, :id_soal, :jawaban, :jenis)
        ");
        $stmt_insert->execute([
            ':id_siswa' => $id_siswa,
            ':id_bank' => $id_bank,
            ':id_soal' => $id_soal,
            ':jawaban' => $jawab,
            ':jenis' => $jenis
        ]);
    }

    $stmt_all = $pdo->prepare("
        SELECT j.jawaban AS user_jwb, s.jawaban AS kunci, s.max_skor 
        FROM jawaban j
        JOIN soal s ON j.id_soal = s.id_soal
        WHERE j.id_siswa = :id_siswa AND j.id_bank = :id_bank
    ");
    $stmt_all->execute([':id_siswa' => $id_siswa, ':id_bank' => $id_bank]);
    $rows = $stmt_all->fetchAll(PDO::FETCH_ASSOC);

    $total_skor = 0;
    $total_max  = 0;

    foreach ($rows as $row) {
        $kunci = array_map('trim', explode(',', strtoupper($row['kunci'])));
        $jawab_user = array_map('trim', explode(',', strtoupper($row['user_jwb'])));
        $max_skor = (float)$row['max_skor'];
        $total_max += $max_skor;

        $jumlah_kunci = count($kunci);
        $jumlah_jawaban = count($jawab_user);
        $jumlah_benar = 0;
        $skor_soal = 0;

        if ($jumlah_jawaban <= $jumlah_kunci) {
            for ($i = 0; $i < $jumlah_jawaban; $i++) {
                if (isset($kunci[$i]) && $jawab_user[$i] === $kunci[$i]) {
                    $jumlah_benar++;
                }
            }

            if ($jumlah_benar > 0) {
                $skor_soal = ($max_skor / $jumlah_kunci) * $jumlah_benar;
                if ($skor_soal > $max_skor) $skor_soal = $max_skor;
            }
        }

        $total_skor += $skor_soal;

        $stmt_update_jawaban = $pdo->prepare("
            UPDATE jawaban 
            SET skor = :skor 
            WHERE id_soal = :id_soal AND id_siswa = :id_siswa AND id_bank = :id_bank
        ");
        $stmt_update_jawaban->execute([
            ':skor' => $skor_soal,
            ':id_soal' => $id_soal,
            ':id_siswa' => $id_siswa,
            ':id_bank' => $id_bank
        ]);
    }

    $stmt_sum = $pdo->prepare("SELECT SUM(max_skor) AS total_max FROM soal WHERE id_bank = :id_bank");
    $stmt_sum->execute([':id_bank' => $id_bank]);
    $total_max_skor = (float)($stmt_sum->fetchColumn() ?? 0);

    $nilai_akhir = ($total_max_skor > 0) ? (($total_skor / $total_max_skor) * 100) : 0;

    $stmt_update_nilai = $pdo->prepare("
        UPDATE nilai 
        SET skor = :total_skor, nilai = :nilai_akhir
        WHERE id_bank = :id_bank AND id_siswa = :id_siswa
    ");
    $stmt_update_nilai->execute([
        ':total_skor' => $total_skor,
        ':nilai_akhir' => $nilai_akhir,
        ':id_bank' => $id_bank,
        ':id_siswa' => $id_siswa
    ]);

    echo "OK";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>



<?php elseif ($pg == 'bs'): ?>
<?php
$id_bank  = isset($_POST['id_bank'])  ? (int)$_POST['id_bank']  : 0;
$id_siswa = isset($_POST['id_siswa']) ? (int)$_POST['id_siswa'] : 0;
$id_soal  = isset($_POST['id_soal'])  ? (int)$_POST['id_soal']  : 0;
$jawaban  = trim($_POST['jawaban'] ?? '');
$jenis    = trim($_POST['jenis'] ?? '');

if ($id_bank <= 0 || $id_siswa <= 0 || $id_soal <= 0 || $jawaban === '') {
    echo "Input tidak lengkap";
    exit;
}

try {
   
    $stmt_cek = $pdo->prepare("SELECT 1 FROM jawaban WHERE id_siswa = :id_siswa AND id_soal = :id_soal");
    $stmt_cek->execute([':id_siswa' => $id_siswa, ':id_soal' => $id_soal]);
    $exists = $stmt_cek->fetchColumn();

    if ($exists) {
       
        $stmt_upd = $pdo->prepare("
            UPDATE jawaban SET jawaban = :jawaban, jenis = :jenis 
            WHERE id_siswa = :id_siswa AND id_soal = :id_soal
        ");
        $stmt_upd->execute([
            ':jawaban' => $jawaban,
            ':jenis' => $jenis,
            ':id_siswa' => $id_siswa,
            ':id_soal' => $id_soal
        ]);
    } else {
       
        $stmt_ins = $pdo->prepare("
            INSERT INTO jawaban (id_siswa, id_bank, id_soal, jawaban, jenis)
            VALUES (:id_siswa, :id_bank, :id_soal, :jawaban, :jenis)
        ");
        $stmt_ins->execute([
            ':id_siswa' => $id_siswa,
            ':id_bank' => $id_bank,
            ':id_soal' => $id_soal,
            ':jawaban' => $jawaban,
            ':jenis' => $jenis
        ]);
    }

    $stmt_all = $pdo->prepare("
        SELECT j.jawaban AS user_jwb, s.jawaban AS kunci, s.max_skor 
        FROM jawaban j 
        JOIN soal s ON j.id_soal = s.id_soal
        WHERE j.id_siswa = :id_siswa AND j.id_bank = :id_bank
    ");
    $stmt_all->execute([':id_siswa' => $id_siswa, ':id_bank' => $id_bank]);
    $rows = $stmt_all->fetchAll(PDO::FETCH_ASSOC);

    $total_skor = 0;

    foreach ($rows as $row) {
        $kunci = array_map('trim', explode(',', strtoupper($row['kunci'])));
        $jawab_user = array_map('trim', explode(',', strtoupper($row['user_jwb'])));
        $max_skor = (float)$row['max_skor'];

        $jumlah_kunci = count($kunci);
        $jumlah_jawaban = count($jawab_user);
        $jumlah_benar = 0;
        $skor_soal = 0;

        if ($jumlah_jawaban <= $jumlah_kunci) {
            for ($i = 0; $i < $jumlah_jawaban; $i++) {
                if (isset($kunci[$i]) && $jawab_user[$i] === $kunci[$i]) {
                    $jumlah_benar++;
                }
            }
            if ($jumlah_benar > 0) {
                $skor_soal = ($max_skor / $jumlah_kunci) * $jumlah_benar;
                if ($skor_soal > $max_skor) $skor_soal = $max_skor;
            }
        }

        $total_skor += $skor_soal;

        $stmt_update_jawaban = $pdo->prepare("
            UPDATE jawaban SET skor = :skor 
            WHERE id_soal = :id_soal AND id_siswa = :id_siswa AND id_bank = :id_bank
        ");
        $stmt_update_jawaban->execute([
            ':skor' => $skor_soal,
            ':id_soal' => $id_soal,
            ':id_siswa' => $id_siswa,
            ':id_bank' => $id_bank
        ]);
    }

    $stmt_sum = $pdo->prepare("SELECT SUM(max_skor) AS total_max FROM soal WHERE id_bank = :id_bank");
    $stmt_sum->execute([':id_bank' => $id_bank]);
    $total_max_skor = (float)($stmt_sum->fetchColumn() ?? 0);

    $nilai_akhir = ($total_max_skor > 0) ? (($total_skor / $total_max_skor) * 100) : 0;

    $stmt_update_nilai = $pdo->prepare("
        UPDATE nilai SET skor = :total_skor, nilai = :nilai_akhir
        WHERE id_bank = :id_bank AND id_siswa = :id_siswa
    ");
    $stmt_update_nilai->execute([
        ':total_skor' => $total_skor,
        ':nilai_akhir' => $nilai_akhir,
        ':id_bank' => $id_bank,
        ':id_siswa' => $id_siswa
    ]);

    echo "OK";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<?php elseif ($pg == 'esai'): ?>
<?php

$id_bank  = filter_input(INPUT_POST, 'id_bank', FILTER_VALIDATE_INT);
$id_siswa = filter_input(INPUT_POST, 'id_siswa', FILTER_VALIDATE_INT);
$id_soal  = filter_input(INPUT_POST, 'id_soal', FILTER_VALIDATE_INT);
$jawaban  = strtolower(trim($_POST['jawaban'] ?? ''));
$jenis    = filter_input(INPUT_POST, 'jenis', FILTER_VALIDATE_INT);

if (!$id_bank || !$id_siswa || !$id_soal || !$jenis) {
    die("Data tidak valid.");
	}

$stmt_check = $pdo->prepare("SELECT COUNT(*) FROM jawaban WHERE id_siswa = :id_siswa AND id_bank = :id_bank AND id_soal = :id_soal AND jenis = :jenis");
$stmt_check->execute([
    ':id_siswa' => $id_siswa,
    ':id_bank'  => $id_bank,
    ':id_soal'  => $id_soal,
    ':jenis'    => $jenis
]);
$cek = $stmt_check->fetchColumn();

if ($cek == 0) {
    $stmt_insert = $pdo->prepare("INSERT INTO jawaban (id_siswa, id_bank, id_soal, jawaban, jenis) VALUES (:id_siswa, :id_bank, :id_soal, :jawaban, :jenis)");
    $stmt_insert->execute([
        ':id_siswa' => $id_siswa,
        ':id_bank'  => $id_bank,
        ':id_soal'  => $id_soal,
        ':jawaban'  => $jawaban,
        ':jenis'    => $jenis
    ]);
} else {
    $stmt_update = $pdo->prepare("UPDATE jawaban SET jawaban = :jawaban, jenis = :jenis WHERE id_siswa = :id_siswa AND id_bank = :id_bank AND id_soal = :id_soal");
    $stmt_update->execute([
        ':jawaban'  => $jawaban,
        ':jenis'    => $jenis,
        ':id_siswa' => $id_siswa,
        ':id_bank'  => $id_bank,
        ':id_soal'  => $id_soal
    ]);
}

$stmt_soal = $pdo->prepare("SELECT jawaban, max_skor FROM soal WHERE id_soal = :id_soal");
$stmt_soal->execute([':id_soal' => $id_soal]);
$soale = $stmt_soal->fetch(PDO::FETCH_ASSOC);

$stmt_jawab = $pdo->prepare("SELECT jawaban FROM jawaban WHERE id_soal = :id_soal AND id_siswa = :id_siswa");
$stmt_jawab->execute([
    ':id_soal'  => $id_soal,
    ':id_siswa' => $id_siswa
]);
$jawabane = $stmt_jawab->fetch(PDO::FETCH_ASSOC);

if ($soale && $jawabane) {
    $jawaban_soal = strtolower(trim($soale['jawaban']));
    $jawaban_user = strtolower(trim($jawabane['jawaban']));
    $skor_per_soal = ($jawaban_soal === $jawaban_user) ? (float)$soale['max_skor'] : 0;

    $stmt_update_jawaban = $pdo->prepare("UPDATE jawaban SET skor = :skor WHERE id_soal = :id_soal AND id_siswa = :id_siswa AND id_bank = :id_bank");
    $stmt_update_jawaban->execute([
        ':skor'     => $skor_per_soal,
        ':id_soal'  => $id_soal,
        ':id_siswa' => $id_siswa,
        ':id_bank'  => $id_bank
    ]);

    $stmt_sum = $pdo->prepare("SELECT SUM(skor) FROM jawaban WHERE id_siswa = :id_siswa AND id_bank = :id_bank");
    $stmt_sum->execute([':id_siswa' => $id_siswa, ':id_bank' => $id_bank]);
    $total_skor = (float)$stmt_sum->fetchColumn();

    $stmt_max = $pdo->prepare("SELECT SUM(max_skor) FROM soal WHERE id_bank = :id_bank");
    $stmt_max->execute([':id_bank' => $id_bank]);
    $total_max = (float)$stmt_max->fetchColumn();

    $nilai_akhir = ($total_max > 0) ? ($total_skor / $total_max) * 100 : 0;

    $stmt_update_nilai = $pdo->prepare("UPDATE nilai SET skor = :total_skor, nilai = :nilai_akhir WHERE id_siswa = :id_siswa AND id_bank = :id_bank");
    $stmt_update_nilai->execute([
        ':total_skor'  => $total_skor,
        ':nilai_akhir' => $nilai_akhir,
        ':id_siswa'    => $id_siswa,
        ':id_bank'     => $id_bank
    ]);
}

echo "OK";
exit;
?>



<?php elseif ($pg == 'jodoh'): ?>
<?php

$id_bank  = $_POST['id_bank'] ?? null;
$id_siswa = $_POST['id_siswa'] ?? null;
$id_soal  = $_POST['id_soal'] ?? null;
$jawaban  = trim($_POST['jawaban'] ?? '');
$warna    = $_POST['warna'] ?? '';
$jenis    = $_POST['jenis'] ?? null;

if (!$id_siswa || !$id_soal || !$id_bank) {
    http_response_code(400);
    echo "Data tidak lengkap.";
    exit;
}

$stmt = $pdo->prepare("SELECT id_jawaban FROM jawaban WHERE id_siswa = :id_siswa AND id_soal = :id_soal");
$stmt->execute([':id_siswa' => $id_siswa, ':id_soal' => $id_soal]);
$exists = $stmt->fetchColumn();

if ($exists) {
    $stmt_update = $pdo->prepare("
        UPDATE jawaban 
        SET jawaban = :jawaban, warna = :warna, jenis = :jenis
        WHERE id_siswa = :id_siswa AND id_soal = :id_soal
    ");
    $stmt_update->execute([
        ':jawaban'  => $jawaban,
        ':warna'    => $warna,
        ':jenis'    => $jenis,
        ':id_siswa' => $id_siswa,
        ':id_soal'  => $id_soal
    ]);
} else {
    $stmt_insert = $pdo->prepare("
        INSERT INTO jawaban (id_siswa, id_bank, id_soal, jawaban, warna, jenis)
        VALUES (:id_siswa, :id_bank, :id_soal, :jawaban, :warna, :jenis)
    ");
    $stmt_insert->execute([
        ':id_siswa' => $id_siswa,
        ':id_bank'  => $id_bank,
        ':id_soal'  => $id_soal,
        ':jawaban'  => $jawaban,
        ':warna'    => $warna,
        ':jenis'    => $jenis
    ]);
}

$stmt_all = $pdo->prepare("
    SELECT j.jawaban AS user_jwb, s.jawaban AS kunci, s.max_skor 
    FROM jawaban j 
    JOIN soal s ON j.id_soal = s.id_soal 
    WHERE j.id_siswa = :id_siswa AND j.id_bank = :id_bank
");
$stmt_all->execute([':id_siswa' => $id_siswa, ':id_bank' => $id_bank]);
$jawaban_rows = $stmt_all->fetchAll(PDO::FETCH_ASSOC);

$total_skor = 0;

foreach ($jawaban_rows as $row) {
    $kunci_raw = strtoupper(trim($row['kunci']));
    $jawab_raw = strtoupper(trim($row['user_jwb']));
    $max_skor  = (float)$row['max_skor'];

    if ($jawab_raw === '') continue;

    $skor_soal = 0;

    if (strpos($kunci_raw, ':') !== false) {
        $kunci_pairs = array_map('trim', explode(',', $kunci_raw));
        $jawab_pairs = array_map('trim', explode(',', $jawab_raw));

        $jumlah_kunci  = count($kunci_pairs);
        $jumlah_jawaban = count($jawab_pairs);
        $jumlah_benar = 0;

        if ($jumlah_jawaban <= $jumlah_kunci) {
            foreach ($jawab_pairs as $pair) {
                if (in_array($pair, $kunci_pairs)) {
                    $jumlah_benar++;
                }
            }
            if ($jumlah_benar > 0) {
                $skor_soal = ($max_skor / $jumlah_kunci) * $jumlah_benar;
                if ($skor_soal > $max_skor) $skor_soal = $max_skor;
            }
        }
    } else {
        $kunci_arr  = array_map('trim', explode(',', $kunci_raw));
        $jawab_arr  = array_map('trim', explode(',', $jawab_raw));

        $jumlah_kunci = count($kunci_arr);
        $jumlah_jawaban = count($jawab_arr);
        $jumlah_benar = 0;

        if ($jumlah_jawaban <= $jumlah_kunci) {
            for ($i = 0; $i < $jumlah_jawaban; $i++) {
                if (isset($kunci_arr[$i]) && $jawab_arr[$i] === $kunci_arr[$i]) {
                    $jumlah_benar++;
                }
            }
            if ($jumlah_benar > 0) {
                $skor_soal = ($max_skor / $jumlah_kunci) * $jumlah_benar;
                if ($skor_soal > $max_skor) $skor_soal = $max_skor;
            }
        }
    }

    $total_skor += $skor_soal;
}

$stmt_sum = $pdo->prepare("SELECT SUM(max_skor) AS total_max FROM soal WHERE id_bank = :id_bank");
$stmt_sum->execute([':id_bank' => $id_bank]);
$total_max_skor = (float)($stmt_sum->fetchColumn() ?? 0);

$nilai_akhir = ($total_max_skor > 0) ? (($total_skor / $total_max_skor) * 100) : 0;

$stmt_update_nilai = $pdo->prepare("
    UPDATE nilai 
    SET skor = :total_skor, nilai = :nilai_akhir
    WHERE id_bank = :id_bank AND id_siswa = :id_siswa
");
$stmt_update_nilai->execute([
    ':total_skor'  => $total_skor,
    ':nilai_akhir' => $nilai_akhir,
    ':id_bank'     => $id_bank,
    ':id_siswa'    => $id_siswa
]);

$stmt_update_jawaban = $pdo->prepare("
    UPDATE jawaban 
    SET skor = :skor
    WHERE id_soal = :id_soal AND id_siswa = :id_siswa AND id_bank = :id_bank
");
$stmt_update_jawaban->execute([
    ':skor'     => $skor_soal,
    ':id_soal'  => $id_soal,
    ':id_siswa' => $id_siswa,
    ':id_bank'  => $id_bank
]);

echo "OK";
?>


<?php endif; ?>

     
   
	