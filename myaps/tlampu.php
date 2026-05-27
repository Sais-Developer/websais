<?php
require("../konek/koneksi.php"); // pastikan disini $pdo

$pg = isset($_GET['pg']) ? $_GET['pg'] : '';

if ($pg == 'status') {
    if (!isset($_GET['id'])) {
        echo json_encode(['error' => 'ID lampu tidak dikirim']);
        exit;
    }

    $id = intval($_GET['id']); // pastikan integer
    $stmt = $pdo->prepare("SELECT status FROM lampu WHERE id = ?");
    $stmt->execute([$id]);
    $led = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($led) {
        $currentStatus = strtoupper($led['status']);
        $status = ($currentStatus === 'ON') ? 'OF' : 'ON';

        $stmt = $pdo->prepare("UPDATE lampu SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(['id' => $id, 'status' => $status]);
        exit;
    } else {
        echo json_encode(['error' => 'Lampu tidak ditemukan']);
        exit;
    }
}
if($pg == 'getAll'){
    $stmt = $pdo->query("SELECT id, status FROM lampu ORDER BY id ASC");
    $lampu = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($lampu);
    exit;
}



    if($pg == 'edit'){
   
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['id']) && isset($data['nama'])){
        $id = intval($data['id']);
        $nama = trim($data['nama']);

        try{
            $stmt = $pdo->prepare("UPDATE lampu SET nama = ? WHERE id = ?");
            $stmt->execute([$nama, $id]);

            echo json_encode(['success'=>true]);
        } catch(Exception $e){
            echo json_encode(['success'=>false, 'error'=>$e->getMessage()]);
        }
    } else {
        echo json_encode(['success'=>false, 'error'=>'Data tidak lengkap']);
    }
    exit;
}

$stmt = $pdo->query("SELECT id, nama FROM lampu ORDER BY id ASC");
$lampuList = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($pg == 'status2') {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT status FROM lampu_16 WHERE id = ?");
    $stmt->execute([$id]);
    $led = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($led) {
        $status = ($led['status'] == '1') ? '0' : '1';

        $stmt = $pdo->prepare("UPDATE lampu_16 SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
}

if ($pg == 'edit2') {
    $id   = $_POST['id'];
    $nama = $_POST['nama'];

    $stmt = $pdo->prepare("UPDATE lampu_16 SET nama = ? WHERE id = ?");
    $stmt->execute([$nama, $id]);
}

?>
