 <?php
 require "../../konek/koneksi.php";
 
 $server = $_POST['server'];

    $sql = "UPDATE pengaturan SET server = :server WHERE id_aplikasi = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':server', $server, PDO::PARAM_STR);
    $stmt->execute();
?>