<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");

$kode = $_POST['idz'];
$filezip = '../../'.$kode.'.zip';
     unlink($filezip); 
		
		