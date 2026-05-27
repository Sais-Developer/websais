<?php
require("../konek/koneksi.php"); 
$mode = $pdo->query("SELECT mode FROM status ORDER BY id DESC LIMIT 1")->fetchColumn();
$statusMap = [
    1 => "masuk",
    2 => "pulang",
    3 => "eskul",
    4 => "pulang eskul"
];
$status = $statusMap[$mode] ?? "tidak diketahui";

function absis($pdo, $status, $limit = 6) {
    if ($status === "eskul") {
        $sql = "
            SELECT a.*, s.nama as nama_siswa, s.kelas, s.foto, s.jk,
                   g.nama as nama_guru, g.jabatan, g.foto as foto_guru, a.level
            FROM absensi_les a
            LEFT JOIN siswa s ON s.id_siswa = a.idsiswa
            LEFT JOIN guru g ON g.id_guru = a.idpeg
            WHERE a.tanggal = CURDATE()
            ORDER BY a.id DESC
            LIMIT $limit
        ";
    } else {
        $sql = "
            SELECT a.*, s.nama as nama_siswa, s.kelas, s.foto, s.jk,
                   g.nama as nama_guru, g.jabatan, g.foto as foto_guru, a.level
            FROM absensi a
            LEFT JOIN siswa s ON s.id_siswa = a.idsiswa
            LEFT JOIN guru g ON g.id_guru = a.idpeg
            WHERE a.tanggal = CURDATE()
            ORDER BY a.id DESC
            LIMIT $limit
        ";
    }
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

$absensis = absis($pdo, $status);

$ketMap = [
    'H' => 'Hadir',
    'I' => 'Izin',
    'A' => 'Alpha',
    'S' => 'Sakit'
];
?>
<div class="card widget widget-list">
<div class="card-header">
   <h5 class="card-title text-center">LIVE PRESENSI <?= strtoupper($status) ?><br><small>HARI INI</small></h5>
       </div>
    <div class="card-body" style="height:590px">
	 <ul class="widget-list-content list-unstyled">
<?php foreach($absensis as $absiswa): 
    $ketText = $ketMap[$absiswa['ket'] ?? ''] ?? 'Tidak diketahui';

    if($absiswa['level'] === 'siswa') {
        $nama = $absiswa['nama_siswa'];
        $kelas = 'Kelas ' . $absiswa['kelas'];
        if(!empty($absiswa['foto'])) {
            $foto = "../images/fotosiswa/" . htmlspecialchars($absiswa['foto']);
        } else {
            $foto = ($absiswa['jk'] ?? 'L') === 'L' ? "../images/siswa.png" : "../images/wanita.png";
        }
    } else {
        $nama = $absiswa['nama_guru'];
        $kelas = 'Jabatan ' . $absiswa['jabatan'];
        if(!empty($absiswa['foto_guru'])) {
            $foto = "../images/fotoguru/" . htmlspecialchars($absiswa['foto_guru']);
        } else {
            $foto = "../images/user.png";
        }
    }

    $jamPresensi = '';
    if ($status === "masuk" && !empty($absiswa['masuk'])) {
        $jamPresensi = $absiswa['masuk'];
    } elseif ($status === "pulang" && !empty($absiswa['pulang'])) {
        $jamPresensi = $absiswa['pulang'];
    } elseif ($status === "eskul" && !empty($absiswa['masuk'])) { 
        $jamPresensi = $absiswa['masuk'];
    } elseif ($status === "pulang eskul" && !empty($absiswa['pulang'])) { 
        $jamPresensi = $absiswa['pulang'];
    }
?>
<?php if ($status === "masuk" && !empty($absiswa)): ?>
<li class="widget-list-item widget-list-item-green">
    <span class="widget-list-item-avatar">
        <div class="avatar avatar-rounded">
            <img src="<?= $foto ?>" alt="" style="border-radius:50%; width:50px; height:50px; object-fit:cover;">
        </div>
    </span>
    <span class="widget-list-item-description">
        <a href="#" class="widget-list-item-description-title">
            <?= htmlspecialchars($nama) ?> 
        </a>
        <span class="widget-list-item-description-subtitle d-flex justify-content-between">
            <span><?= htmlspecialchars($kelas) ?></span>
            <span style="color:blue;"><?= htmlspecialchars($ketText) ?></span>
        </span>
    </span>
</li>
<?php elseif ($status === "pulang" && !empty($absiswa['pulang'])): ?>
<li class="widget-list-item widget-list-item-green">
    <span class="widget-list-item-avatar">
        <div class="avatar avatar-rounded">
            <img src="<?= $foto ?>" alt="" style="border-radius:50%; width:50px; height:50px; object-fit:cover;">
        </div>
    </span>
    <span class="widget-list-item-description">
        <a href="#" class="widget-list-item-description-title">
            <?= htmlspecialchars($nama) ?> 
        </a>
        <span class="widget-list-item-description-subtitle d-flex justify-content-between">
            <span><?= htmlspecialchars($kelas) ?></span>
            <span style="color:blue;"><?= htmlspecialchars($ketText) ?></span>
        </span>
    </span>
</li>
<?php elseif ($status === "eskul" && !empty($absiswa['masuk'])): ?>
<li class="widget-list-item widget-list-item-green">
    <span class="widget-list-item-avatar">
        <div class="avatar avatar-rounded">
            <img src="<?= $foto ?>" alt="" style="border-radius:50%; width:50px; height:50px; object-fit:cover;">
        </div>
    </span>
    <span class="widget-list-item-description">
        <a href="#" class="widget-list-item-description-title">
            <?= htmlspecialchars($nama) ?> 
        </a>
        <span class="widget-list-item-description-subtitle d-flex justify-content-between">
            <span><?= htmlspecialchars($kelas) ?></span>
            <span style="color:blue;"><?= htmlspecialchars($ketText) ?></span>
        </span>
    </span>
</li>
<?php elseif ($status === "pulang eskul" && !empty($absiswa['pulang'])): ?>
<li class="widget-list-item widget-list-item-green">
    <span class="widget-list-item-avatar">
        <div class="avatar avatar-rounded">
            <img src="<?= $foto ?>" alt="" style="border-radius:50%; width:50px; height:50px; object-fit:cover;">
        </div>
    </span>
    <span class="widget-list-item-description">
        <a href="#" class="widget-list-item-description-title">
            <?= htmlspecialchars($nama) ?> 
        </a>
        <span class="widget-list-item-description-subtitle d-flex justify-content-between">
            <span><?= htmlspecialchars($kelas) ?></span>
            <span style="color:blue;"><?= htmlspecialchars($ketText) ?></span>
        </span>
    </span>
</li>

<?php endif; ?>
<?php endforeach; ?>
<?php if(empty($absiswa)): ?>
<li class="widget-list-item widget-list-item-green">
    <span class="widget-list-item-avatar">
        <div class="avatar avatar-rounded">
           <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
</div>
        </div>
    </span>
    <span class="widget-list-item-description">
        <a href="#" class="widget-list-item-description-title">
           Tidak ada aktifitas
        </a>
        <span class="widget-list-item-description-subtitle d-flex justify-content-between">
            <span><?= htmlspecialchars($kelas) ?></span>
            <span style="color:blue;"></span>
        </span>
    </span>
</li>
<?php endif; ?>
</ul>
 </div>
</div>