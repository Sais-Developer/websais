<?php
require("konek/koneksi.php"); 
require("konek/function.php");
require("konek/crud.php");

$ac        = enkripsi($_POST['idm']);
$id_siswa  = enkripsi($_POST['ids']);
$idu       = $_POST['idm'];   
$ids       = $_POST['ids'];   

$sekarang  = date('Y-m-d H:i:s');
$ip_address = $_SERVER['REMOTE_ADDR'];

try {

    $stmt_cek = $pdo->prepare("
        SELECT id_nilai, ujian_selesai 
        FROM nilai 
        WHERE id_siswa = :ids AND id_ujian = :idu
        LIMIT 1
    ");

    $stmt_cek->execute([
        ':ids' => $ids,
        ':idu' => $idu
    ]);

    $nilai = $stmt_cek->fetch(PDO::FETCH_ASSOC);

    if ($nilai) {
        if (empty($nilai['ujian_selesai'])) {

            $pg = enkripsi('asesmen');
            jump("?pg=$pg&idu=$ac&ids=$id_siswa");
            exit;
        } else {

            die("Ujian sudah diselesaikan. Tidak dapat mengulang.");
        }
    }

    $stmt_bank = $pdo->prepare("
        SELECT idbank 
        FROM ujian 
        WHERE id_jadwal = :idu
        LIMIT 1
    ");

    $stmt_bank->execute([':idu' => $idu]);
    $idbank = $stmt_bank->fetchColumn();


    $nilaidata = [
        'id_bank'           => $idbank,
        'id_ujian'          => $idu,
        'id_siswa'          => $ids,
        'ujian_mulai'       => $sekarang,
        'ujian_berlangsung' => $sekarang,
        'ipaddress'         => $ip_address,
        'online'            => 1
    ];

    $columns = implode(", ", array_keys($nilaidata));
    $placeholders = ":" . implode(", :", array_keys($nilaidata));

    $sql_insert = "INSERT INTO nilai ($columns) VALUES ($placeholders)";
    $stmt_insert = $pdo->prepare($sql_insert);

    $stmt_insert->execute($nilaidata);

    $stmt_log = $pdo->prepare("
        INSERT INTO log_ujian (id_siswa, id_bank, aktivitas, waktu) 
        VALUES (:ids, :idbank, :aktivitas, :waktu)
    ");

    $stmt_log->execute([
        ':ids'       => $ids,
        ':idbank'    => $idbank,
        ':aktivitas' => "Mulai Ujian",
        ':waktu'     => $sekarang
    ]);


    $pg = enkripsi('asesmen');
    jump("?pg=$pg&idu=$ac&ids=$id_siswa");
    exit;


} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
