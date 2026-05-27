<?php
defined('APK') or exit('No Access');

$id_soal = $_GET['id_soal'] ?? '';
$ac      = $_GET['ac'] ?? '';
$pg      = $_GET['pg'] ?? '';

$stmtSoal = $pdo->prepare("SELECT * FROM soal WHERE id_soal = :id_soal");
$stmtSoal->execute([':id_soal' => $id_soal]);
$soal = $stmtSoal->fetch(PDO::FETCH_ASSOC);
$stmtSoal->closeCursor();  

$id_bank = $soal['id_bank'] ?? 0;

$stmtMapel = $pdo->prepare("
    SELECT b.*, m.kode 
    FROM banksoal b 
    LEFT JOIN mapel m ON m.id = b.idmapel 
    WHERE b.id_bank = :id_bank
");
$stmtMapel->execute([':id_bank' => $id_bank]);
$mapel = $stmtMapel->fetch(PDO::FETCH_ASSOC);
$stmtMapel->closeCursor();  

$stmtCount = $pdo->prepare("
    SELECT COUNT(*) as total 
    FROM soal 
    WHERE id_bank = :id_bank AND nomor = :nomor AND jenis = 5
");
$stmtCount->execute([':id_bank' => $id_bank, ':nomor' => $soal['nomor']]);
$jumsoal = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$stmtCount->closeCursor();  
?>


<?php if ($ac === '') : ?>
<div class="row"> 
<form id='formsoal' action='' method='post' enctype='multipart/form-data'>
    <input type='hidden' name='idsoal' value='<?= $soal['id_soal'] ?>'>
    <input type='hidden' name='mapel' value='<?= $soal['id_bank'] ?>'>
    <input type="hidden" name="jenis" value="<?= $soal['jenis'] ?>">
    <input type='hidden' name='nomor' value='<?= $soal['nomor'] ?>'>
    <div class="col-md-12">
        <div class="card-header d-flex justify-content-between align-items-center mb-3">
				    <div class="d-flex align-items-center gap-1">
						<label class='btn btn-sm btn-primary'><?= $mapel['kode'] ?> </label>
						<label class='btn btn-sm btn-danger'>No Soal :<b class="sandik"> <?= $soal['nomor'] ?></b></label>
					</div>
                <div class="d-flex align-items-center gap-2">			
                     <button type='submit' name='simpansoal' onclick="tinyMCE.triggerSave(true,true);" class='btn btn-sm btn-primary'> Simpan</button>
						<a href='?pg=<?= enkripsi('banksoal') ?>&ac=lihat&id=<?= $mapel['id_bank'] ?>' class='btn btn-sm btn-danger'> Kembali</a>
					</div>
			    </div>
		     </div>		

    <div class='row'>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5>Soal</h5></div>
                <div class="card-body">
                    <textarea id='editor2' name='isi_soal' class='editor1' rows='10' style='width:100%;'><?= htmlspecialchars($soal['soal']) ?></textarea>
                    <br>
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
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5>Opsi & Kunci Jawaban</h5></div>
                <div class="card-body">
                    <div class="row mb-1">
                        <label class="col-md-8 col-form-label">Skor Maximal</label>
                        <div class="col-md-4">
                            <input type='number' name='skor' value="<?= $soal['max_skor'] ?>" class='form-control' required />
                        </div>
                    </div>
                    <div class='form-group'>
                        <textarea id='jawabesai' name='pilA' rows='10' class='form-control' required><?= htmlspecialchars($soal['jawaban']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>
	</div>
 </form>
</div>
<?php elseif ($ac === 'hapusfile'): ?>
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
$('#formsoal').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
             url: 'bank/editesai.php?pg=simpan_soal',
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
                    window.location.reload();
                }, 200);
            }
        })
        return false;
    });
	</script>
