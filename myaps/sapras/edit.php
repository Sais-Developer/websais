<?php
require '../../konek/koneksi.php'; 

$id = $_POST['id'];

$stmt = $pdo->prepare("SELECT * FROM sapras WHERE id = :id");
$stmt->execute([":id" => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);


    $nama_barang  = $_POST['barang'];
    $jumlah       = $_POST['jumlah'];
    $kondisi      = $_POST['kondisi'];
    $sumber_dana  = $_POST['dana'];
    $lokasi_id    = $_POST['lokasi'];
    $keterangan   = $_POST['ket'];
    $foto         = $data['foto']; 

    if (!empty($_FILES['foto']['name'])) {
        $filename = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../../images/sapras/" . $filename);

        if (!empty($data['foto']) && file_exists("uploads/" . $data['foto'])) {
            unlink("../../images/sapras/" . $data['foto']);
        }

        $foto = $filename;
    }

    $sql = "UPDATE sapras SET
              nama_barang = :nama_barang,
              jumlah = :jumlah,
              kondisi = :kondisi,
              sumber_dana = :sumber_dana,
              lokasi_id = :lokasi_id,
              foto = :foto,
              keterangan = :keterangan
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $exec = $stmt->execute([
        ":nama_barang" => $nama_barang,
        ":jumlah"      => $jumlah,
        ":kondisi"     => $kondisi,
        ":sumber_dana" => $sumber_dana,
        ":lokasi_id"   => $lokasi_id,
        ":foto"        => $foto,
        ":keterangan"  => $keterangan,
        ":id"          => $id
    ]);

    if ($exec) {
        echo "Data berhasil diperbarui!";
    } else {
        echo "Gagal memperbarui data!";
    }

?>
