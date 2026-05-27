<?php
require("../../konek/koneksi.php"); 
require("../../konek/function.php");
require("../../konek/crud.php");

$id     = $_POST['id'];
$idguru = $_POST['idguru'];
$catat  = $_POST['catatan'];
$jur = fetch($koneksi,'kebiasaan_harian',['id'=>$id]);
$siswa = fetch($koneksi,'siswa',['id_siswa'=>$jur['id_siswa']]);
$nowa = $siswa['nowa'];
$pesan = "Assalamualaikum wr.wb\n\nTerima kasih ananda\n*".$siswa['nama']."*\nTelah mengisi Jurnal Kebiasaan Harian pada hari ini\nJurnal hari ini telah di paraf oleh Guru Kelas, untuk melihat data silahkan cek di aplikasi. Terima kasih tidak perlu dibalas\n\n Wassalamualaikum.wr.wb";
$signature_ortu = $_POST['signature_ortu'];

$signature_file = null;
if (!empty($signature_ortu)) {
    $signature_ortu = str_replace('data:image/png;base64,', '', $signature_ortu);
    $signature_ortu = str_replace(' ', '+', $signature_ortu);
    $signature_data = base64_decode($signature_ortu);

    $lokasi = '../../images/ttd/';
    if (!is_dir($lokasi)) {
        mkdir($lokasi, 0777, true); // buat folder jika belum ada
    }

    $signature_file = 'sign_' . time() . '-' . $idguru . '.png';

  
    file_put_contents($lokasi . $signature_file, $signature_data);
}

$query = "UPDATE kebiasaan_harian 
          SET id_guru='$idguru', 
              paraf_guru='$signature_file', 
              catatan_guru='$catat'
          WHERE id='$id'";

if (mysqli_query($koneksi, $query)) {
   
  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => $setting['url_api'].'/send-message',   
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('message' => $pesan,'number' => $nowa),
));
$response = curl_exec($curl);
curl_close($curl);
   
} else {
    echo "Gagal menyimpan: " . mysqli_error($koneksi);
}
?>
