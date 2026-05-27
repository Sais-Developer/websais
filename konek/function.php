<?php
declare(strict_types=1);

const DEFAULT_SECRET_KEY = 'CHANGE_ME_SECRET_KEY';
const DEFAULT_SECRET_IV  = 'CHANGE_ME_SECRET_IV';

function app_secret_key(): string {
    $key = getenv('APP_SECRET_KEY');
    return $key !== false && $key !== '' ? $key : DEFAULT_SECRET_KEY;
}
function app_secret_iv(): string {
    $iv = getenv('APP_SECRET_IV');
    return $iv !== false && $iv !== '' ? $iv : DEFAULT_SECRET_IV;
}


function url_exists(string $url): bool
{
    $validated = filter_var($url, FILTER_VALIDATE_URL);
    if ($validated === false) {
        return false;
    }

    $ch = curl_init($validated);
    curl_setopt_array($ch, [
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_NOBODY         => true,
        CURLOPT_HEADER         => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT      => 'PHP-URL-Checker/1.0'
    ]);

    curl_exec($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpCode >= 200 && $httpCode < 400;
}

/**
 * GET sederhana yang aman: validasi URL, timeout, SSL verified
 */
function http_request(string $url): string
{
    $validated = filter_var($url, FILTER_VALIDATE_URL);
    if ($validated === false) {
        return '';
    }

    $ch = curl_init($validated);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT      => 'PHP-HTTP-Client/1.0'
    ]);

    $output = curl_exec($ch);
    if ($output === false) {
        // log error internal, jangan tampilkan ke user
        error_log('http_request error: ' . curl_error($ch));
        $output = '';
    }
    curl_close($ch);
    return $output;
}

/**
 * ============================
 *  Info Browser (best-effort)
 * ============================
 */
function getBrowser(): array
{
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $platform = 'Unknown';
    if (stripos($ua, 'linux') !== false)       $platform = 'Linux';
    elseif (stripos($ua, 'mac os x') !== false)$platform = 'Mac';
    elseif (stripos($ua, 'windows') !== false) $platform = 'Windows';

    $name = 'Unknown'; $ub = 'other';
    if (preg_match('/Edg/i', $ua))             { $name = 'Edge'; $ub = 'Edg'; }
    elseif (preg_match('/OPR|Opera/i', $ua))   { $name = 'Opera'; $ub = 'OPR'; }
    elseif (preg_match('/Chrome/i', $ua))      { $name = 'Chrome'; $ub = 'Chrome'; }
    elseif (preg_match('/Safari/i', $ua))      { $name = 'Safari'; $ub = 'Version'; } // Safari pakai "Version/"
    elseif (preg_match('/Firefox/i', $ua))     { $name = 'Firefox'; $ub = 'Firefox'; }
    elseif (preg_match('/MSIE|Trident/i', $ua)){ $name = 'Internet Explorer'; $ub = 'MSIE'; }

    $version = '?';
    if (preg_match_all('#(?<browser>'.$ub.'|Version)[/ ]+(?<version>[0-9.]+)#i', $ua, $m)) {
        $i = count($m['browser']);
        if ($i >= 1) {
            // Safari kadang "Version/x.y", lainnya "Name/x.y"
            $idx = ($name === 'Safari' && ($key = array_search('Version', array_map('ucfirst',$m['browser'])) ) !== false)
                ? $key : 0;
            $version = $m['version'][$idx] ?? '?';
        }
    }

    return [
        'userAgent' => $ua,
        'name'      => $name,
        'version'   => $version,
        'platform'  => $platform
    ];
}
/**
 * ============================
 *  Crypto Utilities (AES-256-CBC) - URL Safe
 * ============================
 */
function enkripsi(string $plain): string
{
    $method = 'AES-256-CBC';
    $key    = hash('sha256', app_secret_key(), true); // raw binary
    $iv     = substr(hash('sha256', app_secret_iv(), true), 0, 16);

    $cipher = openssl_encrypt($plain, $method, $key, OPENSSL_RAW_DATA, $iv);
    $b64    = base64_encode($cipher ?: '');

    // ubah ke URL safe
    $urlSafe = strtr(rtrim($b64, '='), '+/', '-_');
    return $urlSafe;
}

function dekripsi(string $cipherUrl): string
{
    $method = 'AES-256-CBC';
    $key    = hash('sha256', app_secret_key(), true);
    $iv     = substr(hash('sha256', app_secret_iv(), true), 0, 16);

    // balikkan ke base64 normal
    $b64 = strtr($cipherUrl, '-_', '+/');
    $pad = strlen($b64) % 4;
    if ($pad > 0) {
        $b64 .= str_repeat('=', 4 - $pad); // tambahkan padding '=' kalau perlu
    }

    $raw = base64_decode($b64, true);
    if ($raw === false) return '';
    $plain = openssl_decrypt($raw, $method, $key, OPENSSL_RAW_DATA, $iv);
    return $plain === false ? '' : $plain;
}

/**
 * ============================
 *  Session Guard
 * ============================
 * Gunakan redirect HTTP, bukan JS.
 */

function cek_session_siswa(): void
{
    if (!isset($_SESSION['id_siswa'])) {
        header('Location: /'); exit;
    }
}

/**
 * Redirect aman
 */
function jump($page)
{
	echo "<script>location=('$page');</script>";
}



/**
 * ============================
 *  Waktu & Tanggal
 * ============================
 */
function timeAgo(string $tanggal): string
{
    $now = time();
    $ts  = strtotime($tanggal);
    if ($ts === false) return $tanggal;

    $diff = $now - $ts;
    if ($diff <= 0) return 'Baru saja';
    if ($diff < 60) return $diff . ' detik';

    $menit = intdiv($diff, 60);
    if ($menit < 60) return $menit . ' menit';

    $jam = intdiv($menit, 60);
    if ($jam < 24) return $jam . ' jam';

    $hari = intdiv($jam, 24);
    if ($hari < 2) return 'Kemarin';
    if ($hari < 3) return $hari . ' hari';

    return date('Y-m-d H:i:s', $ts);
}

function bulan_indo(string $tanggal): string
{
    static $bulan = [
        1=>'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'
    ];
    $pecah = explode('-', $tanggal);
    $idx = isset($pecah[1]) ? (int)$pecah[1] : 0;
    return $bulan[$idx] ?? '';
}

function buat_tanggal(string $format, ?string $time = null): string
{
    $ts  = $time ? strtotime($time) : time();
    $str = date($format, $ts);

    // Hilangkan leading zero untuk 1-9 pada pattern umum
    for ($t = 1; $t <= 9; $t++) {
        $str = str_replace("0{$t} ", "{$t} ", $str);
    }

    // Translate singkatan ENG -> ID
    $rep = [
        'Jan'=>'Januari','Feb'=>'Februari','Mar'=>'Maret','Apr'=>'April','May'=>'Mei','Jun'=>'Juni',
        'Jul'=>'Juli','Aug'=>'Agustus','Sep'=>'September','Oct'=>'Oktober','Nov'=>'Nopember','Dec'=>'Desember',
        'Mon'=>'Senin','Tue'=>'Selasa','Wed'=>'Rabu','Thu'=>'Kamis','Fri'=>'Jumat','Sat'=>'Sabtu','Sun'=>'Minggu'
    ];
    return strtr($str, $rep);
}

/**
 * true/1 -> Ya, selain itu -> Tidak
 */
function enum($bool): string
{
    return ((int)$bool === 1) ? 'Ya' : 'Tidak';
}

/**
 * Escape sederhana ke HTML entities
 */
function html2str(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * ============================
 *  ZIP Utility
 * ============================
 * Menerima array file ATAU satu folder.
 */
function create_zip($files = [], string $destination = '', bool $overwrite = false): bool
{
    if ($destination === '') return false;
    if (file_exists($destination) && !$overwrite) return false;

    $valid_files = [];

    if (is_array($files)) {
        foreach ($files as $file) {
            if (is_string($file) && is_file($file)) {
                $valid_files[] = $file;
            }
        }
    } elseif (is_string($files) && is_dir($files)) {
        $iter = new DirectoryIterator($files);
        foreach ($iter as $fileinfo) {
            if ($fileinfo->isFile()) {
                $valid_files[] = $fileinfo->getPathname();
            }
        }
    }

    if (!count($valid_files)) return false;

    $zip = new ZipArchive();
    $flag = $overwrite ? ZipArchive::OVERWRITE : ZipArchive::CREATE;
    if ($zip->open($destination, $flag) !== true) return false;

    foreach ($valid_files as $file) {
        // path di dalam zip dibuat relatif
        $localName = ltrim(str_replace('\\', '/', $file), '/');
        $zip->addFile($file, $localName);
    }
    $zip->close();

    return file_exists($destination);
}

/**
 * ============================
 *  Generator Password Aman
 * ============================
 */
function genPass(int $panjang): string
{
    $panjang = max(4, min($panjang, 64));
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($chars);
    $out = '';
    for ($i = 0; $i < $panjang; $i++) {
        $out .= $chars[random_int(0, $len - 1)];
    }
    return $out;
}

/**
 * ============================
 *  Pemotong Teks
 * ============================
 * mode:
 * 1 = potong keras di $length
 * 2 = mundur ke spasi terdekat
 * 3 = maju ke spasi terdekat
 */
if (!function_exists('cutText')) {
    function cutText(string $text, int $length, int $mode = 2): string
    {
        $length = max(0, $length);
        if (strlen($text) <= $length || $length === 0) return $text;

        if ($mode === 1) {
            return substr($text, 0, $length);
        }

        if ($mode === 2) { // mundur
            $pos = $length - 1;
            while ($pos > 0 && $text[$pos] !== ' ') {
                $pos--;
            }
            return trim(substr($text, 0, max(0, $pos)));
        }

        // mode 3: maju
        $pos = $length - 1;
        $max = strlen($text) - 1;
        while ($pos < $max && ($text[$pos] ?? ' ') !== ' ') {
            $pos++;
        }
        return trim(substr($text, 0, max(0, $pos)));
    }
}

/**
 * ============================
 *  Format Durasi Ujian
 * ============================
 * $seconds -> "X Hari Y Jam Z Menit" atau '--'
 */
function lamaujian(?int $seconds): string
{
    if (!$seconds || $seconds < 0) return '--';

    $hari  = intdiv($seconds, 86400); $seconds %= 86400;
    $jam   = intdiv($seconds, 3600);  $seconds %= 3600;
    $menit = intdiv($seconds, 60);

    $str = '';
    if ($hari  > 0) $str .= $hari  . ' Hari ';
    if ($jam   > 0) $str .= $jam   . ' Jam ';
    if ($menit > 0 || $str === '') $str .= $menit . ' Menit ';
    return trim($str);
}
function hariIndo($hariInggris) {
    $map = [
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu',
        'Sun' => 'Minggu'
    ];

    return $map[$hariInggris] ?? $hariInggris; 
}