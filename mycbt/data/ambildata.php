<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';

if ($pg === 'jurusan') {
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);
    $sql = mysqli_query($koneksi, "SELECT jurusan FROM m_kelas WHERE level='$level' GROUP BY jurusan");
    echo "<option value=''>Pilih Jurusan</option>";
    echo "<option value='semua'>semua</option>";
    while ($data = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
        echo "<option value='{$data['jurusan']}'>{$data['jurusan']}</option>";
    }
}
