<?php
require("../../konek/koneksi.php"); 
require("../../konek/function.php");
require("../../konek/crud.php");

$idserver = $setting['kode_sekolah'];
echo "<link rel='stylesheet' href='$baseurl/vendor/css/cetak.min.css'>";

$sesi = $_GET['id_sesi'] ?? '';
$id_bank = $_GET['id_bank'] ?? '';
$ruang = $_GET['id_ruang'] ?? '';
$kelas = $_GET['id_kelas'] ?? '';

$lebarusername = '10%';
$lebarnopes = '17%';

$stmt = $pdo->prepare("
    SELECT u.*, b.*, m.nama_mapel 
    FROM ujian u
    LEFT JOIN banksoal b ON b.id_bank = u.idbank
    LEFT JOIN mapel m ON m.id = b.idmapel
    WHERE u.idbank = :id_bank AND u.sesi = :sesi
    LIMIT 1
");
$stmt->execute(['id_bank' => $id_bank, 'sesi' => $sesi]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    die("<span style='font-size:30; color:red'>Data ujian tidak ditemukan.</span>");
}

if (date('m') >= 7 && date('m') <= 12) {
    $ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 && date('m') <= 6) {
    $ajaran = (date('Y') - 1) . "/" . date('Y');
}

$ckck = [];
if ($sesi != '' && $ruang != '' && $kelas != '') {
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE sesi = :sesi AND kelas = :kelas AND ruang = :ruang");
    $stmt->execute(['sesi' => $sesi, 'kelas' => $kelas, 'ruang' => $ruang]);
    $ckck = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$jumlahData = count($ckck);
if ($jumlahData == 0) {
    echo "<span style='font-size:30; color:red'>Tidak ada Peserta Ujian dengan mapel " . htmlspecialchars($result['nama_mapel']) . ", pada: <br>= sesi: " . htmlspecialchars($sesi) . ", <br>= ruang: " . htmlspecialchars($ruang) . ", <br>= kelas: " . htmlspecialchars($kelas) . "</span>";
    die;
}

$jumlahn = 20;
$n = ceil($jumlahData / $jumlahn);
$nomer = 1;

$date = date_create($result['tgl_ujian']);
?>

<?php for ($i = 1; $i <= $n; $i++) : ?>
    <?php
    $mulai = $i - 1;
    $batas = ($mulai * $jumlahn);
    $batasakhir = $batas + $jumlahn;
    $pageData = array_slice($ckck, $batas, $jumlahn);
    ?>

    <div class='page'>
        <table width='100%'>
            <tr>
                <td width='100'>
                    <img src="<?= $baseurl; ?>/images/kemdikbud.png" height='80px' />
                </td>
                <td style="text-align:center">
                    <strong class='f12'>
                        DAFTAR HADIR PESERTA <br>
                        <?= strtoupper($setting['jenis_ujian']) ?><br>
                        TAHUN PELAJARAN <?= $ajaran ?>
                    </strong>
                </td>
                <td width='100'><img src="<?= $baseurl; ?>/images/<?= $setting['logo'] ?>" height='75'></td>
            </tr>
        </table>

        <table class='detail'>
            <tr>
                <td>SEKOLAH</td>
                <td>:</td>
                <td><span style='width:350px;'>&nbsp;<?= $setting['sekolah'] ?></span></td>
                <td>ID SERVER</td>
                <td>:</td>
                <td><span style='width:150px;'>&nbsp;<?= $setting['kode_server'] ?></span></td>
            </tr>
            <tr>
                <td>RUANG</td>
                <td>:</td>
                <td><span style='width:350px;'>&nbsp;<?= $ruang ?></span></td>
                <td>SESI</td>
                <td>:</td>
                <td><span style='width:150px;'>&nbsp;<?= $sesi ?></span></td>
            </tr>
            <tr>
                <td>HARI</td>
                <td>:</td>
                <td>
                    <span style='width:90px;'>&nbsp;<?= strtoupper(buat_tanggal('D', $result['tgl_ujian'])) ?></span>
                    TANGGAL : <span style='width:190px;'>&nbsp;<?= strtoupper(buat_tanggal('d M Y', $result['tgl_ujian'])) ?></span>
                </td>
                <td>PUKUL</td>
                <td>:</td>
                <td><span style='width:150px;'>&nbsp;<?= buat_tanggal('H:i', $result['tgl_ujian']) . " - " . buat_tanggal('H:i', $result['tgl_selesai']) ?></span></td>
            </tr>
            <tr>
                <td>MATA PELAJARAN</td>
                <td>:</td>
                <td colspan='4'><span style='width:350px;'>&nbsp;<?= $result['nama_mapel'] ?></span></td>
            </tr>
        </table>

        <table class='it-grid it-cetak' width='100%'>
            <tr height='40px'>
                <th>No.</th>
                <th>Username</th>
                <th>No Peserta</th>
                <th>Nama Peserta</th>
                <th>Tanda Tangan</th>
                <th>Ket</th>
            </tr>

            <?php foreach ($pageData as $f) : ?>
                <?php if ($nomer % 2 == 0) : ?>
                    <tr>
                        <td style="text-align:center;width:15"><?= $nomer ?>.</td>
                        <td width='<?= $lebarusername ?>' style="text-align:center"><?= htmlspecialchars($f['username']) ?></td>
                        <td width='<?= $lebarnopes ?>' style="text-align:center"><?= htmlspecialchars($f['nopes']) ?></td>
                        <td width='*'><?= htmlspecialchars($f['nama']) ?></td>
                        <td width='150'><span style='float:right;width:80px;'>&nbsp;<?= $nomer ?>.</span></td>
                        <td width='6%'>&nbsp;</td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td style="text-align:center;width:15"><?= $nomer ?>.</td>
                        <td width='<?= $lebarusername ?>' style="text-align:center"><?= htmlspecialchars($f['username']) ?></td>
                        <td width='<?= $lebarnopes ?>' style="text-align:center"><?= htmlspecialchars($f['nopes']) ?></td>
                        <td width='*'><?= htmlspecialchars($f['nama']) ?></td>
                        <td width='150'><span style='float:left;width:80px;'>&nbsp;<?= $nomer ?>.</span></td>
                        <td width='6%'>&nbsp;</td>
                    </tr>
                <?php endif; ?>
                <?php $nomer++; ?>
            <?php endforeach; ?>
        </table>

        <table>
            <tr><td colspan='2'><strong><i>Keterangan :</i></strong></td></tr>
            <tr><td>1. Dibuat rangkap 3 (tiga), masing-masing untuk sekolah, Cabang Dinas dan Provinsi.</td></tr>
            <tr><td>2. Pengawas ruang menyilang Nama Peserta yang tidak hadir.</td></tr>
        </table>

        <table width='100%'>
            <tr>
                <td>
                    <table style='border:1px solid black'>
                        <tr>
                            <td>Jumlah Peserta yang Seharusnya Hadir</td>
                            <td>:</td>
                            <td> <?= $nomer - 1 ?> orang</td>
                        </tr>
                        <tr>
                            <td>Jumlah Peserta yang Tidak Hadir</td>
                            <td>:</td>
                            <td>_____ orang</td>
                        </tr>
                        <tr style='border-top:1px solid black'>
                            <td>Jumlah Peserta Hadir</td>
                            <td>:</td>
                            <td>_____ orang</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center; width:200">
                    Proktor<br><br><br><br><br>(<nip></nip>)<br><br>&nbsp;&nbsp;&nbsp;&nbsp;NIP. <nip></nip>
                </td>
                <td style="text-align:center; width:175">
                    Pengawas<br><br><br><br><br>(<nip></nip>)<br><br>&nbsp;&nbsp;&nbsp;&nbsp;NIP. <nip></nip>
                </td>
            </tr>
        </table>

        <div class='footer'>
            <table width='100%' height='30'>
                <tr>
                    <td width='25px' style='border:1px solid black'></td>
                    <td width='5px'>&nbsp;</td>
                    <td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['nama_ujian']) . " " . $setting['sekolah'] ?></td>
                    <td width='5px'>&nbsp;</td>
                    <td width='25px' style='border:1px solid black'></td>
                </tr>
            </table>
        </div>
    </div>

<?php endfor; ?>
