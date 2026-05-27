<?php
require("../konek/koneksi.php");
require("../konek/function.php");
require("../konek/crud.php");
function formatNumber($number) {
    $number = preg_replace('/[^0-9]/', '', $number); 
    if (substr($number, 0, 1) === "0") {
        return "62" . substr($number, 1);
    } elseif (substr($number, 0, 2) === "62") {
        return $number;
    } else {
        return "62" . $number;
    }
}

function sendWA($number, $message, $url_api, $token) {
    $target = formatNumber($number);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url_api . "/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'target' => $target,
            'message' => $message,
        ],
        CURLOPT_HTTPHEADER => [
            "Authorization: $token"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

$token   = $setting['wa_token'];
$url_api = $setting['url_api'];

$tgl = date('Y-m-d');
$waktu = date('H:i:s');
$kartu = $_POST['uid'];

try {
   
    $stmt = $pdo->prepare("
        SELECT d.*, s.id_siswa, s.saldo, s.nama, s.nowa
        FROM datareg d
        LEFT JOIN siswa s ON d.nokartu = :kartu
        WHERE d.nokartu = :kartu
    ");
    $stmt->execute([':kartu' => $kartu]);
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$siswa) {
        echo "GAGAL";
        exit;
    }

    $ids = $siswa['id_siswa'];
    $saldo = $siswa['saldo'];
    $nowa = $siswa['nowa'];
	
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM transaksi_kantin WHERE idsiswa = :idsiswa AND status = '1'");
    $stmt->execute([':idsiswa' => $ids]);
    $jumtrx = $stmt->fetchColumn();

    if ($jumtrx == 0) {
        echo "KOSONG";
    } else {
      
        $stmt = $pdo->prepare("SELECT SUM(total_harga) AS total FROM transaksi_kantin WHERE idsiswa = :idsiswa AND status = '1'");
        $stmt->execute([':idsiswa' => $ids]);
        $trx = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($saldo > $trx['total']) {
            $saldoakhir = $saldo - $trx['total'];

            $stmt = $pdo->prepare("INSERT INTO saldo(tanggal, jam, idsiswa, debet, kredit) VALUES(:tgl, :waktu, :ids, 0, :total)");
            $stmt->execute([
                ':tgl' => $tgl,
                ':waktu' => $waktu,
                ':ids' => $ids,
                ':total' => $trx['total']
            ]);

            $stmt = $pdo->prepare("UPDATE siswa SET saldo = :saldoakhir WHERE id_siswa = :ids");
            $stmt->execute([':saldoakhir' => $saldoakhir, ':ids' => $ids]);

            echo "      SMK SADAM CISURUPAN       \n";
            echo "  Jalan Serang RT. 006 RW. 005  \n";
            echo "================================\n";
            echo "        STRUK TRANSAKSI         \n\n";  
            echo "Nama   : " . substr($siswa['nama'], 0, 22) . "\n";
            echo "Waktu  : " . date('d-m-Y H:i:s') . " \n\n";

            $stmt = $pdo->prepare("SELECT * FROM transaksi_kantin WHERE idsiswa = :ids AND (status = '1' OR status = '3')");
            $stmt->execute([':ids' => $ids]);
            $transaksi = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($transaksi as $data) {
               
                $stmtProd = $pdo->prepare("SELECT * FROM produk WHERE produk_id = :idproduk");
                $stmtProd->execute([':idproduk' => $data['idproduk']]);
                $prod = $stmtProd->fetch(PDO::FETCH_ASSOC);

                $stok = $prod['produk_jumlah'] - $data['jumlah'];
                $stmtUpdate = $pdo->prepare("UPDATE produk SET produk_jumlah = :stok WHERE produk_id = :idproduk");
                $stmtUpdate->execute([':stok' => $stok, ':idproduk' => $data['idproduk']]);

                echo $data['jumlah'] . " " . substr($prod['produk_nama'], 0, 22) . "\n";  
                echo "                    RP " . number_format($data['total_harga']) . "\n";
            }

            echo "================================\n";
            echo "TOTAL               RP " . number_format($trx['total']) . "\n\n";

            $stmt = $pdo->prepare("UPDATE transaksi_kantin SET status = '2', ket = '0' WHERE idsiswa = :ids AND (status = '1' OR status = '3')");
            $stmt->execute([':ids' => $ids]);
		
		$notif = "Nama   : " . substr($siswa['nama'], 0, 22) . "\n" . 
         "Waktu  : " . date('d-m-Y H:i:s') . "\n" . 
         "Telah melakukan transaksi sebesar RP " . number_format($data['total_harga']);

sendWA($nowa, $notif, $url_api, $token);


        } else {
            echo "TIDAK";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
