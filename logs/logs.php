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
function absis($pdo, $status) {
    if ($status === "eskul") {
        $sql = "
            SELECT a.*, s.nama as nama_siswa, s.kelas, s.foto, s.jk,
                   g.nama as nama_guru, g.jabatan, g.foto as foto_guru, a.level
            FROM absensi_les a
            LEFT JOIN siswa s ON s.id_siswa = a.idsiswa
            LEFT JOIN guru g ON g.id_guru = a.idpeg
            WHERE a.tanggal = CURDATE()
            ORDER BY a.id DESC
            LIMIT 1
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
            LIMIT 1
        ";
    }
    return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}

$absiswa = absis($pdo, $status);
$ketMap = [
    'H' => 'Hadir',
    'I' => 'Izin',
    'A' => 'Alpha',
    'S' => 'Sakit'
];
$ketText = $ketMap[$absiswa['ket'] ?? ''] ?? 'Tidak diketahui';

if($absiswa['level'] === 'siswa') {
    $nama = $absiswa['nama_siswa'];
    $kelas = 'Kelas ' . $absiswa['kelas'];
    if(!empty($absiswa['foto'])) {
        $foto = "images/fotosiswa/" . htmlspecialchars($absiswa['foto']);
    } else {
        $foto = ($absiswa['jk'] ?? 'L') === 'L' ? "images/siswa.png" : "images/wanita.png";
    }
} else {
    $nama = $absiswa['nama_guru'];
    $kelas = 'Jabatan ' . $absiswa['jabatan'];
    if(!empty($absiswa['foto_guru'])) {
        $foto = "images/fotoguru/" . htmlspecialchars($absiswa['foto_guru']);
    } else {
        $foto = "images/user.png";
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
    $jamPresensi = $absiswa['masuk'];
}
?>

<?php if ($status === "masuk" && !empty($absiswa)): ?>
<div class="card widget widget-info">
    <div class="card-body" style="height:485px">
        <div class="widget-info-container text-center">
            <!-- Foto Bulat -->
            <div class="widget-info-image" style="
                background: url('<?= $foto ?>');
                width: 150px; height: 150px;
                border-radius: 50%;
                background-size: cover;
                background-position: center;
                margin: 0 auto 15px auto;
            "></div>

            <a href="#" class="btn btn-info widget-info-action mb-2">Live Presensi <?= ucfirst($status) ?></a>
            
            <h5 class="widget-info-title"><?= htmlspecialchars($nama) ?></h5>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($kelas) ?><br>
                <?php if($jamPresensi): ?>
                    <?= htmlspecialchars($jamPresensi) ?><br>
                <?php endif; ?>
                Status Kehadiran: <?= htmlspecialchars($ketText) ?>
            </p>

            <h6 class="widget-info-title"><?= htmlspecialchars($setting['sekolah'] ?? 'Sekolah') ?></h6>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($setting['alamat'] ?? '') ?> Desa <?= htmlspecialchars($setting['desa'] ?? '') ?> 
                Kec. <?= htmlspecialchars($setting['kecamatan'] ?? '') ?> 
				Kab. <?= htmlspecialchars($setting['kabupaten'] ?? '') ?>
            </p>
        </div>
    </div>
</div>
<?php elseif ($status === "pulang" && !empty($absiswa['pulang'])): ?>
<div class="card widget widget-info">
    <div class="card-body" style="height:485px">
        <div class="widget-info-container text-center">
            <!-- Foto Bulat -->
            <div class="widget-info-image" style="
                background: url('<?= $foto ?>');
                width: 120px; height: 120px;
                border-radius: 50%;
                background-size: cover;
                background-position: center;
                margin: 0 auto 15px auto;
            "></div>

            <a href="#" class="btn btn-info widget-info-action mb-2">Live Presensi <?= ucfirst($status) ?></a>
            
            <h5 class="widget-info-title"><?= htmlspecialchars($nama) ?></h5>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($kelas) ?><br>
                <?php if($jamPresensi): ?>
                    <?= htmlspecialchars($jamPresensi) ?><br>
                <?php endif; ?>
                Status Kehadiran: <?= htmlspecialchars($ketText) ?>
            </p>

            <h5 class="widget-info-title"><?= htmlspecialchars($setting['sekolah'] ?? 'Sekolah') ?></h5>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($setting['alamat'] ?? '') ?> Desa <?= htmlspecialchars($setting['desa'] ?? '') ?> 
                Kec. <?= htmlspecialchars($setting['kecamatan'] ?? '') ?> 
                Kab. <?= htmlspecialchars($setting['kabupaten'] ?? '') ?>
            </p>
        </div>
    </div>
</div>
<?php elseif ($status === "eskul" && !empty($absiswa['masuk'])): ?>
<div class="card widget widget-info">
    <div class="card-body" style="height:485px">
        <div class="widget-info-container text-center">
            <!-- Foto Bulat -->
            <div class="widget-info-image" style="
                background: url('<?= $foto ?>');
                width: 120px; height: 120px;
                border-radius: 50%;
                background-size: cover;
                background-position: center;
                margin: 0 auto 15px auto;
            "></div>

            <a href="#" class="btn btn-info widget-info-action mb-2">Live Presensi <?= ucfirst($status) ?></a>
            
            <h5 class="widget-info-title"><?= htmlspecialchars($nama) ?></h5>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($kelas) ?><br>
                <?php if($jamPresensi): ?>
                    <?= htmlspecialchars($jamPresensi) ?><br>
                <?php endif; ?>
                Status Kehadiran: <?= htmlspecialchars($ketText) ?>
            </p>

            <h5 class="widget-info-title"><?= htmlspecialchars($setting['sekolah'] ?? 'Sekolah') ?></h5>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($setting['alamat'] ?? '') ?> Desa <?= htmlspecialchars($setting['desa'] ?? '') ?> 
                Kec. <?= htmlspecialchars($setting['kecamatan'] ?? '') ?> 
                Kab. <?= htmlspecialchars($setting['kabupaten'] ?? '') ?>
            </p>
        </div>
    </div>
</div>
<?php elseif ($status === "pulang eskul" && !empty($absiswa['pulang'])): ?>
<div class="card widget widget-info">
    <div class="card-body" style="height:485px">
        <div class="widget-info-container text-center">
            <!-- Foto Bulat -->
            <div class="widget-info-image" style="
                background: url('<?= $foto ?>');
                width: 120px; height: 120px;
                border-radius: 50%;
                background-size: cover;
                background-position: center;
                margin: 0 auto 15px auto;
            "></div>

            <a href="#" class="btn btn-info widget-info-action mb-2">Live Presensi <?= ucfirst($status) ?></a>
            
            <h5 class="widget-info-title"><?= htmlspecialchars($nama) ?></h5>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($kelas) ?><br>
                <?php if($jamPresensi): ?>
                    <?= htmlspecialchars($jamPresensi) ?><br>
                <?php endif; ?>
                Status Kehadiran: <?= htmlspecialchars($ketText) ?>
            </p>

            <h5 class="widget-info-title"><?= htmlspecialchars($setting['sekolah'] ?? 'Sekolah') ?></h5>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($setting['alamat'] ?? '') ?> Desa <?= htmlspecialchars($setting['desa'] ?? '') ?> 
                Kec. <?= htmlspecialchars($setting['kecamatan'] ?? '') ?> 
                Kab. <?= htmlspecialchars($setting['kabupaten'] ?? '') ?>
            </p>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card widget widget-info">
    <div class="card-body" style="height:485px">
        <div class="widget-info-container text-center">
            <div class="widget-info-image" style="
                background: url('images/animasi.gif');
                width: 150px; height: 150px;
                border-radius: 50%;
                background-size: cover;
                background-position: center;
                margin: 0 auto 15px auto;
            "></div>
            <a href="#" class="btn btn-info widget-info-action">Live Presensi <?= ucfirst($status) ?></a>
            <h5 class="widget-info-title"><?= htmlspecialchars($setting['sekolah'] ?? 'Sekolah') ?></h5>
            <p class="widget-info-text m-t-n-xs">
                <?= htmlspecialchars($setting['alamat'] ?? '') ?> Desa <?= htmlspecialchars($setting['desa'] ?? '') ?> 
                Kec. <?= htmlspecialchars($setting['kecamatan'] ?? '') ?> 
                Kab. <?= htmlspecialchars($setting['kabupaten'] ?? '') ?>
            </p>
            <a href="#" class="btn btn-danger widget-info-action">Tidak Ada Aktifitas</a>
        </div>
    </div>
</div>
<?php endif; ?>
