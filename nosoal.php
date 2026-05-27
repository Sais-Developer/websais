<style>
#nomorsoal {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;  /* Mengatur posisi tombol agar ada di kiri */
    gap: 10px;  /* Memberikan jarak antar tombol */
}

.btn-app {
    font-size: 14px;
    padding: 10px 20px;
    border-radius: 30px;  /* Membuat tombol berbentuk bulat */
    margin-right: 10px;
    margin-left: 10px;	/* Memberikan jarak antar tombol */
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: black;
}

.badge {
    font-size: 14px;
    padding: 5px 10px;
    color: white;
	 min-width: 60px;
}

.bg-green {
    background-color: green !important;
}

.bg-yellow {
    background-color: yellow !important;
}

.bg-gray {
    background-color: gray !important;
}

.bg-black {
    background-color: black !important;
}

.bg-red {
    background-color: red !important;
}
</style>
<?php
session_start();
require("konek/koneksi.php");

$id_bank  = $_POST['id_bank'] ?? 0;
$id_siswa = $_POST['id_siswa'] ?? 0;

$soal_ids = $_SESSION['soal_acak'][$id_bank];
$total = count($soal_ids);

echo "<div class='row' id='nomorsoal'>";

for ($i = 0; $i < $total; $i++) {

    $id_soal = $soal_ids[$i];  // id_soal berdasarkan acakan session

    // Ambil jawaban siswa
    $stmt_jwb = $pdo->prepare("
        SELECT jawaban, ragu, jenis 
        FROM jawaban 
        WHERE id_siswa = ? AND id_soal = ? AND id_bank = ?
    ");
    $stmt_jwb->execute([$id_siswa, $id_soal, $id_bank]);
    $jwb = $stmt_jwb->fetch(PDO::FETCH_ASSOC);

    if ($jwb) {
        $color = ($jwb['ragu'] == 1) ? 'yellow' : 'green';
        $jawabannya = ($jwb['jenis'] == '5') ? 'Esai' : $jwb['jawaban'];
    } else {
        $color = 'gray';
        $jawabannya = 'Blm Jwb';
    }

    $no = str_pad($i + 1, 2, '0', STR_PAD_LEFT);

    echo "
    <a class='btn btn-app bg-$color'
       id='badge$id_soal'
       style='min-width:50px;height:50px;border-radius:50px;border:solid black;font-size:10px'
       onclick='loadsoal($id_bank, $id_siswa, $i)'>

       $no
       <span id='jawabtemp$id_soal' class='badge bg-danger' style='font-size:10px'>
            $jawabannya
       </span>
    </a>
    ";
}

echo "</div>";

?>
