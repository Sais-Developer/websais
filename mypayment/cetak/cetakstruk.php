<?php
ob_start();
error_reporting(0);
require("../../konek/koneksi.php"); // pastikan $pdo = new PDO(...) ada di sini
require("../../konek/function.php");
require("../../konek/crud.php");

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut(intval($nilai / 10)) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut(intval($nilai / 100)) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut(intval($nilai / 1000)) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut(intval($nilai / 1000000)) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut(intval($nilai / 1000000000)) . " milyar" . penyebut($nilai % 1000000000);
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut(intval($nilai / 1000000000000)) . " trilyun" . penyebut($nilai % 1000000000000);
    }
    return $temp;
}

function terbilang($nilai) {
    if ($nilai < 0) {
        return "minus " . trim(penyebut($nilai));
    } else {
        return trim(penyebut($nilai));
    }
}

function format_rp($num) {
    return "Rp " . number_format($num, 0, ',', '.');
}

$id = isset($_GET['idt']) ? intval($_GET['idt']) : 0;
if ($id <= 0) die("ID transaksi tidak valid.");

$sql = "SELECT 
            t.id_trx, t.tanggal, t.bayar AS jumlah_bayar, t.bukti, m.total AS total_tagihan, m.model, t.ke,
            m.nama AS nama_bayar, m.kode AS kode_bayar,
            s.id_siswa, s.nama AS nama_siswa, s.kelas
        FROM trx_bayar t
        LEFT JOIN m_bayar m ON m.id = t.idbayar
        LEFT JOIN siswa s ON s.id_siswa = t.idsiswa
        WHERE t.id_trx = :id
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) die("Transaksi tidak ditemukan.");

$tanggal = date('d-m-Y', strtotime($data['tanggal']));
$jumlah = (int)$data['jumlah_bayar'];
$terbilang = ucfirst(terbilang($jumlah)) . " rupiah";
$model = htmlspecialchars($data['model']);
$ke = htmlspecialchars($data['ke']);
$nama_siswa = htmlspecialchars($data['nama_siswa']);
$kelas = htmlspecialchars($data['kelas']);
$nama_bayar = htmlspecialchars($data['nama_bayar']);
$kode_bayar = htmlspecialchars($data['kode_bayar']);
$keterangan = htmlspecialchars($data['bukti']);
$total_tagihan = (int)$data['total_tagihan'];

?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Kwitansi Pembayaran #<?= $data['id_trx'] ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body { font-family: Arial, Helvetica, sans-serif; color:#222; margin:20px; }
    .kwitansi { width: 800px; max-width: 100%; border: 1px solid #333; padding:20px; margin: 0 auto; box-shadow: 0 0 8px rgba(0,0,0,0.06); }
    .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
    .logo { width:70px; }
    .company { text-align:right; }
    h2 { margin:0; font-size:18px; }
    .meta { margin-top:6px; font-size:13px; color:#333; }

    .title { text-align:center; margin:18px 0; font-weight:bold; font-size:18px; text-decoration:underline; }
    table.info { width:100%; border-collapse:collapse; margin-bottom:12px; }
    table.info td { padding:6px; vertical-align:top; font-size:14px; }
    .line { border-top:1px dashed #999; margin:10px 0; }

    table.items { width:100%; border-collapse:collapse; margin-bottom:12px; }
    table.items th, table.items td { border:1px solid #ddd; padding:8px; text-align:left; font-size:14px; }
    table.items th { background:#f4f4f4; }

    .total { display:flex; justify-content:flex-end; margin-top:10px; }
    .total .box { width:320px; border:1px solid #ccc; padding:10px; }
    .terbilang { font-size:13px; color:#333; margin-top:6px; }

    .sign { display:flex; justify-content:space-between; margin-top:10px; }
    .sign .left, .sign .right { width:80%; text-align:center; }
</style>
</head>
<body>
<div class="kwitansi" id="kwitansi">
    <div class="header">
        <div class="logo">
            <img src="<?= $baseurl; ?>/images/<?= $setting['logo'] ?>" alt="Logo" style="max-width:100%;">
        </div>
        <div class="company" style="margin-top:-100px">
            <h4><?= $setting['sekolah'] ?></h4>
            <div class="meta">
                <?= $setting['alamat'] ?><br>
                Telp: <?= $setting['nowa'] ?> <br> Email: <?= $setting['email'] ?>
            </div>
        </div>
    </div>

    <div class="title">KWITANSI PEMBAYARAN</div>

    <table class="info">
        <tr>
            <td style="width:50%;">
                <strong>No. Kwitansi:</strong> <?= htmlspecialchars($data['id_trx']) ?><br>
                <strong>Tanggal:</strong> <?= $tanggal ?><br>
                <strong>Untuk:</strong> <?= $nama_bayar ?> (<?= $kode_bayar ?>)
            </td>
            <td style="width:50%;">
                <strong>Nama:</strong> <?= $nama_siswa ?><br>
                <strong>Kelas:</strong> <?= $kelas ?><br>
                <strong>Reff &nbsp;&nbsp;:</strong> <?= $keterangan ?: '-' ?>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width:8%; text-align:center">No</th>
                <th>Uraian</th>
                <th style="width:20%; text-align:right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center">1</td>
                <td>
                    Pembayaran <?= $nama_bayar ?> <?= ($model ? " (Model: $model)" : "") ?> <?= ($ke ? " - Ke: $ke" : "") ?>
                </td>
                <td style="text-align:right"><?= format_rp($jumlah) ?></td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        <table width="100%">
            <tr>
                <td>
                    <div class="box">
                        <strong>Total Dibayar:</strong>
                        <div style="font-size:18px; margin-top:6px; font-weight:bold; text-align:right"><?= format_rp($jumlah) ?></div>
                        <div class="terbilang"><em><?= $terbilang ?></em></div>
                        <?php if ($total_tagihan > 0 && $total_tagihan != $jumlah): ?>
                            <div style="margin-top:8px; font-size:13px;">Total Tagihan: <?= format_rp($total_tagihan) ?></div>
                            <div style="margin-top:8px; font-size:13px;">Sisa Tagihan: <?= format_rp($total_tagihan-$jumlah) ?></div>
                        <?php endif; ?>
                    </div>
                </td>
                <td width="10%"></td>
                <td>
                    <br>...........................................
                    <br>Bendahara Sekolah
                </td>
            </tr>
        </table>
    </div>

    <div class="line"></div>

    <div style="margin-top:12px; font-size:12px; color:#555;">
        <em>Catatan: Simpan bukti ini sebagai tanda pembayaran yang sah.</em>
    </div>
</div>
</body>
</html>

<?php
$html = ob_get_clean();

require_once __DIR__ . '/../../dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Kwitansi_".$data['id_trx'].".pdf", ["Attachment" => false]);
exit(0);
?>
