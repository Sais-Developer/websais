<?php
require '../../konek/koneksi.php'; 

    $nama_barang  = $_POST['barang'];
    $kategori_id  = $_POST['kate'];
    $jumlah       = $_POST['jumlah'];
    $kondisi      = $_POST['kondisi'];
    $sumber_dana  = $_POST['dana'];
    $lokasi_id    = $_POST['lokasi'];
    $keterangan   = $_POST['ket'];

    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $filename = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../../images/sapras/" . $filename);
        $foto = $filename;
    }

    $sql = "INSERT INTO sapras 
            (nama_barang, idk, jumlah, kondisi, sumber_dana, lokasi_id, foto, keterangan)
            VALUES (:nama_barang, :kategori_id, :jumlah, :kondisi, :sumber_dana, :lokasi_id, :foto, :keterangan)";

    $stmt = $pdo->prepare($sql);

    $exec = $stmt->execute([
        ":nama_barang" => $nama_barang,
        ":kategori_id" => $kategori_id,
        ":jumlah"      => $jumlah,
        ":kondisi"     => $kondisi,
        ":sumber_dana" => $sumber_dana,
        ":lokasi_id"   => $lokasi_id,
        ":foto"        => $foto,
        ":keterangan"  => $keterangan
    ]);

    if ($exec) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan data!";
    }

?>
