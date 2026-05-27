<?php
session_start();
require("konek/koneksi.php");  
require("konek/function.php");

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$level    = $_POST['level'] ?? '';

if ($username === '' || $password === '') {
    echo "td";
    exit;
}

$allowed_tables = ['users', 'guru', 'siswa', 'staff'];
if (!in_array($level, $allowed_tables)) {
    echo "td";
    exit;
}

$sql = "SELECT * FROM `$level` WHERE username = ? LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "td";
    exit;
}
if ($level === 'users') {
    if (!password_verify($password, $user['password'])) {
        echo "nopass";
        exit;
    }

    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['level']   = 'users';
    echo "ok";
    exit;
}

if ($level === 'guru') {
    if ($password === $user['password']) {
        $_SESSION['id_guru'] = $user['id_guru'];
        $_SESSION['level']   = 'guru';
        echo "gr";
    } else {
        echo "nopass";
    }
    exit;
}

if ($level === 'siswa') {
    if ($password === $user['password']) {
        $_SESSION['id_siswa'] = $user['id_siswa'];
        $_SESSION['level']   = 'siswa';
        echo "ss";
    } else {
        echo "nopass";
    }
    exit;
}

if ($level === 'staff') {
    if ($password === $user['password']) {
        $_SESSION['id_staff'] = $user['id_staff'];
        $_SESSION['level']    = 'staff';
        echo "st";
    } else {
        echo "nopass";
    }
    exit;
}

echo "td";
