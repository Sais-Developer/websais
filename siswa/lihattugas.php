<?php
$tanggal = date('Y-m-d');
$id = $_GET['id'];

$query = "SELECT t.*, g.nama AS nama_guru, p.nama_mapel 
          FROM tugas t
          LEFT JOIN guru g ON g.id_guru = t.guru
          LEFT JOIN mapel p ON p.id = t.mapel
          WHERE t.id_tugas = :id_tugas";
$stmt = $pdo->prepare($query);
$stmt->execute([':id_tugas' => $id]);
$tugas = $stmt->fetch(PDO::FETCH_ASSOC);

$where_mapel = $tugas['mapel'];
$where_idsiswa = $_SESSION['id_siswa'];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM absen_daring WHERE idsiswa = :idsiswa AND mapel = :mapel");
$stmt->execute([':idsiswa' => $where_idsiswa, ':mapel' => $where_mapel]);
$count = $stmt->fetchColumn();

if ($count == 0) {
    $insert = $pdo->prepare("INSERT INTO absen_daring 
        (mapel, idsiswa, kelas, tanggal, jam, bulan, ket, guru, tahun, kode) 
        VALUES (:mapel, :idsiswa, :kelas, :tanggal, :jam, :bulan, :ket, :guru, :tahun, :kode)");
    $insert->execute([
        ':mapel'   => $tugas['mapel'],
        ':idsiswa' => $_SESSION['id_siswa'],
        ':kelas'   => $siswa['kelas'],
        ':tanggal' => date('Y-m-d'),
        ':jam'     => date('H:i:s'),
        ':bulan'   => date('m'),
        ':ket'     => 'H',
        ':guru'    => $tugas['guru'],
        ':tahun'   => date('Y'),
        ':kode'    => 'Mengerjakan Tugas ' . $tugas['kode']
    ]);
}
$stmt = $pdo->prepare("SELECT * FROM jawaban_tugas WHERE id_siswa = :idsiswa AND id_tugas = :id_tugas");
$stmt->execute([':idsiswa' => $_SESSION['id_siswa'], ':id_tugas' => $tugas['id_tugas']]);
$jawab_tugas = $stmt->fetch(PDO::FETCH_ASSOC);

$jawaban = $jawab_tugas['jawaban'] ?? '';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class='card-title'>TUGAS SISWA</h5>
            </div>
            <div class='card-body'>		
                <table class='table table-bordered table-striped'>
                    <tr>
                        <th width='150'>Mata Pelajaran</th>
                        <td width='10'>:</td>
                        <td><?= htmlspecialchars($tugas['nama_mapel']) ?></td>
                    </tr>
                    <tr>
                        <th>Tgl Mulai</th>
                        <td width='10'>:</td>
                        <td><?= htmlspecialchars($tugas['tgl_mulai']) ?></td>
                    </tr>
                    <tr>
                        <th>Tgl Selesai</th>
                        <td width='10'>:</td>
                        <td><?= htmlspecialchars($tugas['tgl_selesai']) ?></td>
                    </tr>
                    <?php if(!empty($tugas['file'])): ?>
                        <tr>
                            <th>Download</th>
                            <td width='10'>:</td>
                            <td>
                                <a href="<?= $baseurl . '/tugas/' . $tugas['file'] ?>" target="_blank" class="btn btn-sm btn-danger">
                                    <i class="fas fa-download fa-fw"></i> Download Tugas
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>

                <?php if(!empty($tugas['file'])): 
                    $ekstensi = pathinfo($tugas['file'], PATHINFO_EXTENSION); ?>
                    <?php if($ekstensi == 'mp4'): ?>
                        <video src="<?= $baseurl ?>/tugas/<?= $tugas['file'] ?>" controls autoplay width="100%" height="315"></video>
                    <?php elseif(in_array($ekstensi, ['jpg','png'])): ?>
                        <img src="<?= $baseurl ?>/tugas/<?= $tugas['file'] ?>" width="100%" height="315">
                    <?php elseif($ekstensi == 'pdf'): ?>
                        <iframe src="<?= $baseurl ?>/tugas/<?= $tugas['file'] ?>" width="100%" height="315"></iframe>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="col-md-12">	 
                    <label class="bold"><?= $tugas['judul'] ?></label>
                </div> 
                <div class="col-md-12">					  
                    <p><?= $tugas['tugas'] ?></p>
                </div>
                <hr>

                <?php if (!empty($jawab_tugas['nilai'])): ?>
                    <div class="alert alert-success" role="alert">
                        <strong>Jawaban telah dikoreksi dan dinilai</strong>
                    </div>
                    <h4>Nilai Tugas <?= htmlspecialchars($tugas['mapel']) ?> : <?= htmlspecialchars($jawab_tugas['nilai']) ?></h4>
                <?php else: ?>
                    <form id='formjawaban' class="row g-2" enctype="multipart/form-data">
                        <input type="hidden" name="id_tugas" value="<?= $tugas['id_tugas'] ?>">
                        <input type="hidden" name="kelas" value="<?= $siswa['kelas'] ?>">
                        <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa'] ?>">
                        <input type="hidden" name="mapel" value="<?= $tugas['mapel'] ?>">

                        <div class="col-md-12">	
                            <label class="bold">Lembar Jawaban</label>
                            <textarea class="form-control" name="jawaban" id="txtjawaban" rows="5"><?= $jawaban ?></textarea>
                        </div>
                        <?php if (empty($jawab_tugas['file'])): ?>
                            <div class="col-md-12 mb-4">	
                                <label class="bold">Upload Jawaban</label>
                                <input type="file" class="form-control" name="file">
                            </div>
                        <?php endif; ?>

                        <div class="text-end">	
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$('#formjawaban').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'siswa/simpantugas.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            $('#progressbox').html('<div><img src="<?= $baseurl; ?>/images/animasi.gif" style="width:50px;"></div>');
            setTimeout(function() {
                window.location.reload();
            }, 200);
        }
    });
    return false;
});

tinymce.init({
    selector: '#txtjawaban',
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste'
    ],
    toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist backcolor forecolor | emoticons code | imagetools link image paste',
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
    paste_data_images: true,
    paste_as_text: true,
    images_upload_handler: function(blobInfo, success, failure) {
        success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
    },
    image_class_list: [{ title: 'Responsive', value: 'img-responsive' }],
    setup: function(editor) {
        editor.on('change', function() {
            tinymce.triggerSave();
        });
    }
});
</script>
