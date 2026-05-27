<?php
session_start();
require("../konek/koneksi.php"); 
require("../konek/function.php");
require("../konek/crud.php");
require("../konek/apk.php");

if (!isset($_SESSION['level'])) {
    header('Location: ../login');
    exit;
}
$level = $_SESSION['level'];
if (!in_array($level, ['users', 'guru'])) {
    session_destroy();
    header('Location: ../login?error=not_authorized');
    exit;
}
$user = null;
if ($level === 'users') {
    $id_user = $_SESSION['id_user'] ?? 0;
    $user = fetch("users", ["id_user" => $id_user]);

    if (!$user) {
        session_destroy();
        header("Location: ../login?error=user_not_found");
        exit;
    }
}
if ($level === 'guru') {
    $id_guru = $_SESSION['id_guru'] ?? 0;
    $user = fetch("guru", ["id_guru" => $id_guru]);

    if (!$user) {
        session_destroy();
        header("Location: ../login?error=guru_not_found");
        exit;
    }
}
$pg = $_GET['pg'] ?? '';
$ac = $_GET['ac'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    
    <title><?= $setting['sekolah'] ?></title>
    <link href="<?= $baseurl ?>/font/material.css" rel="stylesheet">
     <link href="<?= $baseurl ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/pace/pace.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/highlight/styles/github-gist.css" rel="stylesheet">
	<link href="<?= $baseurl ?>/assets/plugins/datatables/datatables.min.css" rel="stylesheet">
	<link href="<?= $baseurl ?>/assets/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link rel='stylesheet' href='<?= $baseurl ?>/assets/datetimepicker/jquery.datetimepicker.css' />
	<link rel="stylesheet" href="<?= $baseurl ?>/assets/css/sweetalert2.min.css">
	<link href="<?= $baseurl ?>/assets/css/main.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/css/custom.css" rel="stylesheet">
    <link id="darkTheme" href="<?= $baseurl ?>/assets/css/darktheme.css" rel="stylesheet" disabled>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" />
   <script src='<?= $baseurl ?>/assets/tinymce/tinymce.min.js'></script>
    <script src="<?= $baseurl ?>/assets/plugins/jquery/jquery-3.5.1.min.js"></script>

</head>
<body>