<?php
$dir_foto = '../foto/';
    function deleteFolder($dir) {
        if (!file_exists($dir)) return;
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $f) {
            $path = "$dir/$f";
            if (is_dir($path)) {
                deleteFolder($path);
            } else {
                unlink($path);
            }
        }
        rmdir($dir);
    }

    $folders = array_filter(glob($dir_foto . '*'), 'is_dir');

    foreach($folders as $folder) {
        deleteFolder($folder);
        echo "Folder " . basename($folder) . " dihapus.<br>";
    }

    if(empty($folders)) {
        echo "Tidak ada folder untuk dihapus.<br>";
    }
?>