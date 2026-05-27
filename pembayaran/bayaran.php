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

$pdo->query("TRUNCATE tmpbayar");
$bulan = date('m');
$tahun = date('Y');
$waktu  = date('H:i:s');
$tanggal = date('Y-m-d');
$kartu  = $_POST['uid'];
$besar  = $_POST['besar'];
$idbayar = $_POST['idm'];

$bulanmu = date('YmdHis');
$bukti  = "TRX-$idbayar-$bulanmu";

$stmt = $pdo->prepare("SELECT * FROM m_bayar WHERE id = :id");
$stmt->execute(['id' => $idbayar]);
$jenis = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("
        SELECT d.*, s.id_siswa, s.saldo, s.nama, s.nowa
        FROM datareg d
        LEFT JOIN siswa s ON s.id_siswa = d.idsiswa
        WHERE d.nokartu = :kartu
    ");
    $stmt->execute([':kartu' => $kartu]);
    $datax = $stmt->fetch(PDO::FETCH_ASSOC);

if ($datax && $datax['nokartu'] == $kartu) {

    $ids     = $datax['id_siswa'];
    $saldomu = $datax['saldo'];
    $saldo   = $datax['saldo'] - $besar;
    $nowa = $datax['nowa'];
	
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM trx_bayar 
        WHERE idsiswa = :ids AND idbayar = :idbayar
    ");
    $stmt->execute(['ids' => $ids, 'idbayar' => $idbayar]);
    $jumbayar = $stmt->fetchColumn();

    if ($jumbayar == $jenis['jumlah']) {
        echo "LUNAS";
        exit;
    }

    if ($saldomu < $besar) {
        echo "KURANG";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :ids");
    $stmt->execute(['ids' => $ids]);
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);


    $stmt = $pdo->prepare("
        SELECT * FROM trx_bayar 
        WHERE idsiswa = :ids 
        AND bulan = :bulan
		AND tahun = :tahun		
        AND idbayar = :idbayar
    ");
    $stmt->execute(['ids' => $ids, 'bulan' => $bulan, 'tahun' => $tahun, 'idbayar' => $idbayar]);
    $cek = $stmt->rowCount();

    if ($cek == 0) {
        $stmt = $pdo->prepare("INSERT INTO tmpbayar(nokartu) VALUES(:kartu)");
        $stmt->execute(['kartu' => $kartu]);
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM trx_bayar 
            WHERE idsiswa = :ids AND idbayar = :idbayar
        ");
        $stmt->execute(['ids' => $ids, 'idbayar' => $idbayar]);
        $trx = $stmt->fetchColumn();
        $ke = $trx + 1;

        $stmt = $pdo->prepare("
            INSERT INTO trx_bayar(tanggal,idsiswa,kelas,idbayar,bayar,ke,bukti,bulan,tahun)
            VALUES(:tgl,:ids,:kelas,:idbayar,:bayar,:ke,:bukti,:bulan,:tahun)
        ");

        $simpan = $stmt->execute([
            'tgl' => $tanggal,
            'ids' => $ids,
            'kelas' => $siswa['kelas'],
            'idbayar' => $idbayar,
            'bayar' => $besar,
            'ke' => $ke,
            'bukti' => $bukti,
			'bulan' => $bulan,
			'tahun' => $tahun,
        ]);

        if ($simpan) {

            $stmt = $pdo->prepare("
                INSERT INTO saldo(tanggal,jam,idsiswa,debet,kredit)
                VALUES(:tgl,:jam,:ids,'0',:kredit)
            ");
            $stmt->execute([
                'tgl' => $tanggal,
                'jam' => $waktu,
                'ids' => $ids,
                'kredit' => $besar
            ]);

            $stmt = $pdo->prepare("
                SELECT * FROM trx_bayar 
                WHERE idsiswa = :ids AND idbayar = :idbayar AND bulan = :bulan AND tahun = :tahun
            ");
            $stmt->execute(['ids' => $ids, 'idbayar' => $idbayar, 'bulan' => $bulan, 'tahun' => $tahun]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $pdo->prepare("UPDATE siswa SET saldo = :saldo WHERE id_siswa = :ids");
            $stmt->execute(['saldo' => $saldo, 'ids' => $ids]);

            $nama = (strlen($datax['nama']) > 20)
                ? substr($datax['nama'], 0, 20) . " .."
                : $datax['nama'];


           
            $bulane = fetch('bulan', ['bln' => $bulan]);

            $stmt = $pdo->prepare("SELECT * FROM m_bayar WHERE id = :id");
            $stmt->execute(['id' => $data['idbayar']]);
            $kode = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $pdo->prepare("
                SELECT SUM(bayar) AS jumlah 
                FROM trx_bayar 
                WHERE bulan = :bulan AND tahun = :tahun AND idsiswa = :ids AND idbayar = :idbayar
            ");
            $stmt->execute(['bulan' => $data['bulan'], 'tahun' => $data['tahun'], 'ids' => $data['idsiswa'], 'idbayar' => $data['idbayar']]);
            $Total = $stmt->fetch(PDO::FETCH_ASSOC);


            echo "      SMK SADAM CISURUPAN       \n";
            echo "  Jalan Serang RT. 006 RW. 005  \n";
            echo "================================\n";
            echo "    STRUK BUKTI PEMBAYARAN   \n\n";
            echo "Bulan  : ".$bulane['ket']." ".$tahun."\n";
            echo "Nama   : ".$nama."\n";
            echo "Untuk  : TRX ".$kode['kode']."\n";
            echo "Tgl Byr: ".date('d-m-Y',strtotime($data['tanggal']))."\n";
            echo "Besar  : RP. ".number_format($data['bayar'])."\n";
            echo "Byr Ke : ".$data['ke']."\n";
            echo "Reff   : ".$data['bukti']."\n";
            echo "================================\n";
            echo "Tot Masuk : RP. ".number_format($Total['jumlah'])."\n";
            echo "================================\n";
            echo "        TERIMA KASIH            ";
            echo " Cetak pada ".date('d-m-Y H:i:s')." ";

            if ($data['ke'] != 0) {

                $notif = "Assalamualaikum wr.wb\n\n Kami Sampaikan Informasi bahwa Ananda "
                        .$nama." telah melakukan Pembayaran\n Nama    : ".$kode['nama'].
                        "\n Tanggal : ".date('d-m-Y',strtotime($data['tanggal'])).
                        "\n Besar   : RP. ".number_format($data['bayar']).
                        "\n Byr Ke  : ".$data['ke'].
                        "\n Reff    : ".$data['bukti'].
                        "\n\n Tot Masuk : RP. ".number_format($Total['jumlah']).
                        "\n\n Demikian Informasi ini kami sampaikan kepada Orang Tua Siswa.\n Pesan ini Tidak Perlu dibalas.\n\nWassalamualaikum wr.wb.";

               sendWA($nowa, $notif, $url_api, $token);
            }

        } else {
            echo "GAGAL";
        }

    }

}

?>
