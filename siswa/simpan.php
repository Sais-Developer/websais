<?php
include "../konek/koneksi.php"; 

$ids     = $_POST['ids'];
$kelas   = $_POST['kelas'];
$tanggal = $_POST['tanggal'];
$bangun_pagi = $_POST['bangun_pagi'];

$subuh   = isset($_POST['subuh']) ? 1 : 0;
$dzuhur  = isset($_POST['dzuhur']) ? 1 : 0;
$ashar   = isset($_POST['ashar']) ? 1 : 0;
$maghrib = isset($_POST['maghrib']) ? 1 : 0;
$isya    = isset($_POST['isya']) ? 1 : 0;
$dhuha   = isset($_POST['dhuha']) ? 1 : 0;

$subuh_pilihan   = $subuh   ? $_POST['subuh_pilihan']   : '';
$dzuhur_pilihan  = $dzuhur  ? $_POST['dzuhur_pilihan']  : '';
$ashar_pilihan   = $ashar   ? $_POST['ashar_pilihan']   : '';
$maghrib_pilihan = $maghrib ? $_POST['maghrib_pilihan'] : '';
$isya_pilihan    = $isya    ? $_POST['isya_pilihan']    : '';
$dhuha_pilihan   = $dhuha   ? $_POST['dhuha_pilihan']   : '';

$ibadah_lainnya  = $_POST['ibadah_lainnya'];
$olahraga_jenis  = $_POST['olahraga_jenis'];
$olahraga_durasi = $_POST['olahraga_durasi'];
$mapel           = $_POST['mapel'];
$menu_makan      = $_POST['menu_makan'];
$kegiatan_masyarakat = $_POST['kegiatan_masyarakat'];
$istirahat       = $_POST['istirahat'];
$ortu            = $_POST['ortu'];
$signature_ortu  = $_POST['signature_ortu'];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM kebiasaan_harian WHERE tanggal = :tanggal AND id_siswa = :id_siswa");
$stmt->execute([
    ':tanggal' => $tanggal,
    ':id_siswa' => $ids
]);
$exists = $stmt->fetchColumn();

if (!$exists) {

    $signature_file = null;

    if (!empty($signature_ortu)) {
        $signature_ortu = str_replace('data:image/png;base64,', '', $signature_ortu);
        $signature_ortu = str_replace(' ', '+', $signature_ortu);
        $signature_data = base64_decode($signature_ortu);

        $directory = '../images/ttd/';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        $filename = 'sign_' . time() . '-' . $ids . '.png';
        file_put_contents($directory . $filename, $signature_data);
        $signature_file = $filename;
    }

    $query = "INSERT INTO kebiasaan_harian (
        id_siswa, kelas, tanggal, bangun_pagi,
        subuh, subuh_pilihan,
        dzuhur, dzuhur_pilihan,
        ashar, ashar_pilihan,
        maghrib, maghrib_pilihan,
        isya, isya_pilihan,
        dhuha, dhuha_pilihan,
        ibadah_lainnya, olahraga_jenis, olahraga_durasi,
        mapel, menu_makan, kegiatan_masyarakat, istirahat,
        ortu, paraf_ortu
    ) VALUES (
        :id_siswa, :kelas, :tanggal, :bangun_pagi,
        :subuh, :subuh_pilihan,
        :dzuhur, :dzuhur_pilihan,
        :ashar, :ashar_pilihan,
        :maghrib, :maghrib_pilihan,
        :isya, :isya_pilihan,
        :dhuha, :dhuha_pilihan,
        :ibadah_lainnya, :olahraga_jenis, :olahraga_durasi,
        :mapel, :menu_makan, :kegiatan_masyarakat, :istirahat,
        :ortu, :paraf_ortu
    )";

    $stmt = $pdo->prepare($query);
    $success = $stmt->execute([
        ':id_siswa' => $ids,
        ':kelas' => $kelas,
        ':tanggal' => $tanggal,
        ':bangun_pagi' => $bangun_pagi,
        ':subuh' => $subuh,
        ':subuh_pilihan' => $subuh_pilihan,
        ':dzuhur' => $dzuhur,
        ':dzuhur_pilihan' => $dzuhur_pilihan,
        ':ashar' => $ashar,
        ':ashar_pilihan' => $ashar_pilihan,
        ':maghrib' => $maghrib,
        ':maghrib_pilihan' => $maghrib_pilihan,
        ':isya' => $isya,
        ':isya_pilihan' => $isya_pilihan,
        ':dhuha' => $dhuha,
        ':dhuha_pilihan' => $dhuha_pilihan,
        ':ibadah_lainnya' => $ibadah_lainnya,
        ':olahraga_jenis' => $olahraga_jenis,
        ':olahraga_durasi' => $olahraga_durasi,
        ':mapel' => $mapel,
        ':menu_makan' => $menu_makan,
        ':kegiatan_masyarakat' => $kegiatan_masyarakat,
        ':istirahat' => $istirahat,
        ':ortu' => $ortu,
        ':paraf_ortu' => $signature_file
    ]);

    if ($success) {
        echo "Data berhasil disimpan";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Gagal menyimpan: " . $errorInfo[2];
    }
}
?>
