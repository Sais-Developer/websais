<?php
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if(!$data){
    die("Tidak ada data diterima! Raw input: $raw");
}

if(isset($data['image']) && isset($data['peserta'])){
    $img = preg_replace('#^data:image/\w+;base64,#i', '', $data['image']);
    $img = str_replace(' ', '+', $img);
    $decoded = base64_decode($img);

    if(!$decoded){
        die("Gagal decode gambar!");
    }

    $peserta = preg_replace('/[^a-zA-Z0-9_-]/', '_', $data['peserta']);
    $dir = 'foto/' . $peserta;

    if(!is_dir($dir)){
        if(!mkdir($dir, 0777, true)){
            die("Gagal membuat folder: $dir");
        }
    }

    // Simpan foto terbaru
    $file = $dir . '/terbaru.jpg';
    file_put_contents($file, $decoded);

    // Simpan log dengan timestamp
   // $timestamp = date('Ymd_His');
   // $log_file = $dir . '/log.txt';
    //$log_entry = "Foto diambil: $timestamp, type: " . ($data['type'] ?? "unknown") . PHP_EOL;
   // file_put_contents($log_file, $log_entry, FILE_APPEND);

    echo "Foto terbaru berhasil disimpan: $file";
} else {
    echo "Data foto atau peserta tidak lengkap!";
}
?>
