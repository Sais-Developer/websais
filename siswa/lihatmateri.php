<?php
$id = $_GET['id'];
$query = "SELECT m.*, g.nama AS nama_guru, p.nama_mapel 
          FROM materi m
          LEFT JOIN guru g ON g.id_guru = m.guru
          LEFT JOIN mapel p ON p.id = m.mapel
          WHERE m.idm = :idm";
$stmt = $pdo->prepare($query);
$stmt->execute([':idm' => $id]);
$materi = $stmt->fetch(PDO::FETCH_ASSOC);

function youtube($url) {
    $link = str_replace(['http://www.youtube.com/watch?v=', 'https://www.youtube.com/watch?v='], '', $url);
    return '<iframe width="100%" height="315" src="https://www.youtube.com/embed/' . $link . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
}

$where_mapel = $materi['mapel'];
$where_idsiswa = $_SESSION['id_siswa'];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM absen_daring WHERE idsiswa = :idsiswa AND mapel = :mapel");
$stmt->execute([':idsiswa' => $where_idsiswa, ':mapel' => $where_mapel]);
$count = $stmt->fetchColumn();

if ($count == 0) {
    $insert = $pdo->prepare("INSERT INTO absen_daring (mapel, idsiswa, kelas, tanggal, jam, bulan, ket, guru, tahun, kode)
                             VALUES (:mapel, :idsiswa, :kelas, :tanggal, :jam, :bulan, :ket, :guru, :tahun, :kode)");
    $insert->execute([
        ':mapel'   => $materi['mapel'],
        ':idsiswa' => $_SESSION['id_siswa'],
        ':kelas'   => $siswa['kelas'],
        ':tanggal' => date('Y-m-d'),
        ':jam'     => date('H:i:s'),
        ':bulan'   => date('m'),
        ':ket'     => 'H',
        ':guru'    => $materi['guru'],
        ':tahun'   => date('Y'),
        ':kode'    => 'Belajar Materi ' . $materi['kode']
    ]);
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class='card-title'>Detail Materi Siswa</h5>
            </div>
            <div class='card-body'>			
                <table class='table table-bordered table-striped'>
                    <tr>
                        <th width='150'>Mata Pelajaran</th>
                        <td width='10'>:</td>
                        <td><?= htmlspecialchars($materi['nama_mapel']) ?></td>
                    </tr>
                    <tr>
                        <th>Tgl Pembelajaran</th>
                        <td width='10'>:</td>
                        <td><?= htmlspecialchars($materi['dari']) ?> - <?= htmlspecialchars($materi['sampai']) ?></td>
                    </tr>
                    <?php if(!empty($materi['file'])): 
                        $ext = pathinfo($materi['file'], PATHINFO_EXTENSION); ?>
                        <tr>
                            <th>Download</th>
                            <td width='10'>:</td>
                            <td>
                                <a href="<?= $baseurl . '/materi/' . $materi['file'] ?>" target="_blank" class="btn btn-sm btn-success">
                                    <i class="material-icons">download</i> Materi
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if(!empty($materi['link'])): ?>
                        <tr>
                            <th>Link</th>
                            <td width='10'>:</td>
                            <td>
                                <a href="<?= htmlspecialchars($materi['link']) ?>" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="material-icons">link</i> Materi
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>

                <?php if(!empty($materi['file'])): ?>
                    <?php if(in_array($ext, ['mp4'])): ?>
                        <video src="<?= $baseurl ?>/materi/<?= $materi['file'] ?>" controls width="100%" height="315"></video>
                    <?php elseif(in_array($ext, ['jpg','png'])): ?>
                        <img src="<?= $baseurl ?>/materi/<?= $materi['file'] ?>" width="100%" height="315">
                    <?php elseif($ext == 'pdf'): ?>
                        <iframe src="<?= $baseurl ?>/materi/<?= $materi['file'] ?>" width="100%" height="315"></iframe>
                    <?php elseif($ext == 'docx'): ?>
                        <iframe src="https://docs.google.com/viewer?url=<?= $baseurl ?>/materi/<?= $materi['file'] ?>&embedded=true" width="100%" height="315" style="border:none;"></iframe>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="col-md-12"><br>
                    <h6><?= htmlspecialchars($materi['judul']) ?></h6>
                </div>

                <?php if(!empty($materi['youtube'])): ?>
                    <div class="col-md-12">
                        <?= youtube($materi['youtube']) ?>
                    </div>
                <?php endif; ?>

                <div class="col-md-12">
                    <p><?= $materi['isimateri'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
