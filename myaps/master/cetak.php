<?php
ob_start();
error_reporting(0);
require("../../konek/koneksi.php"); 
require("../../konek/function.php");
require("../../konek/crud.php");

$id = $_GET['idguru'];

$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = :id_guru");
$stmt->bindParam(':id_guru', $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>AKUN GTK</title>
</head>
<style>
@page { 
    margin-top: 1cm; 
    margin-right: 1cm; 
    margin-bottom: 1cm; 
    margin-left: 2cm; 
}
body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 4px; }
th { background-color: #f0f0f0; }
.header-table {
    width: 100%;
    border-collapse: collapse;
}
.header-table td {
    border: none;
    vertical-align: middle;
}
.header-table h3 {
    margin: 0;
    line-height: 1.2;
    font-size: 18px; 
    text-transform: uppercase;
}
.header-table p {
    margin: 2px 0 0 0;
    font-size: 12px;
    line-height: 1.3;
}
.double-hr {
    border: none;
    border-top: 1px solid #000; 
    margin: 5px 0 0 0;
    position: relative;
}
.double-hr::after {
    content: "";
    display: block;
    border-top: 1px solid #000; 
    margin-top: 2px;
}
.text-center { text-align: center; }
strong { font-size: 18px; }
</style>
<body>    
<div style='background:#fff; width:97%; margin: auto; height:90%;'>
     <table class="header-table">
    <tr>
        <td width="70">
            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width="70" alt="Logo">
        </td>
        <td class="text-center">
            <h3>
                <?= $setting['header'] ?? '' ?><br>
                <?= $setting['sekolah'] ?? '' ?>
            </h3>
            <p>
                Alamat: <?= $setting['alamat'] ?? '' ?> Desa <?= $setting['desa'] ?? '' ?> 
                Kecamatan <?= $setting['kecamatan'] ?? '' ?> Kabupaten <?= $setting['kabupaten'] ?? '' ?>
            </p>
        </td>
    </tr>
</table>

<hr class="double-hr">
       <br> 
    <table width="100%" >
        <tr class="text-center">
          <td>SURAT PEMBERITAHUAN AKSES LAYANAN<br>
          SANDIK (SISTEM APLIKASI PENDIDIK) <?= strtoupper($setting['sekolah']); ?></td>  
        </tr>          
    </table>

     <br>
     <table class="header-table">
            <tr>
           <td>Kepada yth,<br>
                <?= strtoupper($user['nama']); ?><br>
                <?= strtoupper($setting['sekolah']); ?>
                </td> 
                <td width="20%"></td>
                <td>Tanggal : <?= date('d M Y') ?><br>
                    Perihal &nbsp;&nbsp;&nbsp;: Surat Akun Login Aplikasi<br>
                    Sifat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: SANGAT RAHASIA
                </td>              
            </tr>          
    </table>
    <br><br><br>
        <p>Dengan hormat,</p>
        <br>
        <p style="text-align:justify;">Pengembangan Sistem Aplikasi Pendidik merupakan Layanan secara online maupun offline bagi Guru dan Tenaga Kependidikan di <?= $setting['sekolah'] ?>. Layanan ini diselenggarakan oleh <?= $setting['sekolah'] ?> dalam rangka meningkatkan kualitas GTK di <?= $setting['sekolah'] ?>. Melalui surat ini, kami memberitahukan bahwa Anda RESMI tercatat di SISTEM APLIKASI PENDIDIK <?= $setting['sekolah'] ?>.
        <br>dengan akun sebagai berikut :
        </p>          
    <br>
    <br>
      <table class="header-table"  style="margin-left:100px;">
        <tr>
          <td width="80px"> &nbsp;Username</td>
          <td> : &nbsp;<?= $user['username'] ?></td>          
        </tr>  
        <tr>
          <td> &nbsp;Password</td>
          <td> : &nbsp;<?= $user['password'] ?></td>          
        </tr>      
    </table>
     <br>
  <p>Gunakan informasi diatas untuk melakukan login pada alamat berikut: <?= $setting['server'] ?></p>
    <br> <br>
    <table class="header-table">
                    <tr>
                    <td width="5%"></td>
                    <td width='20px'></td>
                        <td>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>                            
                            <br/>
                            
                        </td>
                        <td width='30%'></td>
                        <td width="5%"></td>
                        <td>
                            <?= $setting['kabupaten'] ?>, <?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= date('Y') ?><br/>
                            
                    Kepala <?= $setting['sekolah'] ?>
                
                    <br><br><br><br><br>
                                <u><?= $setting['kepsek'] ?></u>
                            <br>
                            
                        <p>NIP. <?= $setting['nip'] ?></p>
                        </td>
                    </tr>
                </table>
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
$dompdf->setPaper('A4', 'Potrait');
$dompdf->render();
$dompdf->stream("Akun Pegawai ". $user['nama'] . ".pdf", array("Attachment" => false));
exit(0);
?>
