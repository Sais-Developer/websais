<?php

function insert($table, $data = []) {
    global $db;
    if (empty($data)) return false;

    $fields = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    $sql = "INSERT INTO `$table` ($fields) VALUES ($placeholders)";

    try {
        $stmt = $db->prepare($sql);
        return $stmt->execute(array_values($data));
    } catch (PDOException $e) {
        error_log("Insert Error: " . $e->getMessage());
        return false;
    }
}

function update($table, $data = [], $where = []) {
    global $db;
    if (empty($data) || empty($where)) return false;

    $set = implode(" = ?, ", array_keys($data)) . " = ?";
    $condition = implode(" = ? AND ", array_keys($where)) . " = ?";
    $sql = "UPDATE `$table` SET $set WHERE $condition";

    try {
        $stmt = $db->prepare($sql);
        return $stmt->execute(array_merge(array_values($data), array_values($where)));
    } catch (PDOException $e) {
        error_log("Update Error: " . $e->getMessage());
        return false;
    }
}

function delete($table, $where = []) {
    global $db;
    if (empty($where)) return false;

    $condition = implode(" = ? AND ", array_keys($where)) . " = ?";
    $sql = "DELETE FROM `$table` WHERE $condition";

    try {
        $stmt = $db->prepare($sql);
        return $stmt->execute(array_values($where));
    } catch (PDOException $e) {
        error_log("Delete Error: " . $e->getMessage());
        return false;
    }
}

function fetch($table, $where = []) {
    $result = select($table, $where, null, 1);
    return $result[0] ?? null;
}

function select($table, $where = [], $order = null, $limit = null) {
    global $db;

    $sql = "SELECT * FROM `$table`";
    $params = [];

    if (!empty($where)) {
        $condition = implode(" = ? AND ", array_keys($where)) . " = ?";
        $sql .= " WHERE $condition";
        $params = array_values($where);
    }

    if ($order) $sql .= " ORDER BY $order";
    if ($limit) $sql .= " LIMIT $limit";

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Select Error: " . $e->getMessage());
        return [];
    }
}

function rowcount($table, $where = []) {
    return count(select($table, $where));
}
function countRows($db, $table) {
    try {
        $stmt = $db->query("SELECT COUNT(*) AS total FROM `$table`");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    } catch (PDOException $e) {
        error_log("CountRows Error: " . $e->getMessage());
        return 0;
    }
}
function rows($table, $where = [])
{
    global $pdo;

    $sql = "SELECT COUNT(*) AS jml FROM $table WHERE 1";
    $params = [];

    foreach ($where as $col => $val) {
        $sql .= " AND $col = ?";
        $params[] = $val;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return (int) ($row['jml'] ?? 0);
}


