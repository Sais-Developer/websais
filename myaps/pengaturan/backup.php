<?php
require("../../konek/koneksi.php"); 

$tables = [];
$stmt = $pdo->query("SHOW TABLES");

while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    $tables[] = $row[0];
}

$sqlScript = "";

foreach ($tables as $table) {
    
    $stmt = $pdo->query("SHOW CREATE TABLE `$table`");
    $row = $stmt->fetch(PDO::FETCH_NUM);
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";

    $stmt = $pdo->query("SELECT * FROM `$table`");
    $rows = $stmt->fetchAll(PDO::FETCH_NUM);
    $columnCount = $stmt->columnCount();

    foreach ($rows as $row) {
        $sqlScript .= "INSERT INTO `$table` VALUES(";

        for ($j = 0; $j < $columnCount; $j++) {
            $value = $row[$j];

            if ($value === null) {
                $sqlScript .= "NULL";
            } else {
                $sqlScript .= $pdo->quote($value);
            }

            if ($j < $columnCount - 1) {
                $sqlScript .= ",";
            }
        }

        $sqlScript .= ");\n";
    }

    $sqlScript .= "\n";
}

if (!empty($sqlScript)) {
    $backupDir = "backup/";
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0777, true);
    }

    $backup_file_name = $backupDir . "newsandik_" . time() . ".sql";
    file_put_contents($backup_file_name, $sqlScript);
}
?>

<div class="alert alert-custom" role="alert">
    Database <strong><?= htmlspecialchars($backup_file_name); ?></strong> telah di-backup.<br>
    Silakan download:
    <a href="pengaturan/download.php?filename=<?= urlencode($backup_file_name) ?>">
        <button class="btn btn-outline-primary">Download</button>
    </a>
</div>
