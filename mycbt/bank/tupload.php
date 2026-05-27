<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;

$uploadDir = __DIR__ . '/../../files/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

function currentHasContent($c): bool
{
    if (!is_array($c)) return false;
    if (trim($c['soal'] ?? '') !== '') return true;
    if (trim($c['jawaban'] ?? '') !== '') return true;
    foreach ([
        'pilA','pilB','pilC','pilD','pilE',
        'perA','perB','perC','perD','perE',
        'fileSoal','fileA','fileB','fileC','fileD','fileE'
    ] as $f) {
        if (!empty(trim($c[$f] ?? ''))) return true;
    }
    return false;
}

function parseElements($elements, &$soalList, &$current, &$allImages, &$imageIndex)
{
    foreach ($elements as $element) {

        // Jika tabel -> iterasi tiap cell dan rekursif
        if (get_class($element) === 'PhpOffice\PhpWord\Element\Table') {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    parseElements($cell->getElements(), $soalList, $current, $allImages, $imageIndex);
                }
            }
            continue;
        }

        // Jika element punya sub-elemen -> rekursif
        if (method_exists($element, 'getElements')) {
            parseElements($element->getElements(), $soalList, $current, $allImages, $imageIndex);
            continue;
        }

        // Image element
        if (get_class($element) === 'PhpOffice\PhpWord\Element\Image') {
            $imgName = $allImages[$imageIndex] ?? '';
            if ($imgName && isset($current)) {
                $opt = $current['option'] ?? '';
                if ($opt === '') $current['fileSoal'] = $imgName;
                else $current['file' . $opt] = $imgName;
            }
            $imageIndex++;
            continue;
        }

        // Text element
        if (method_exists($element, 'getText')) {
            $text = (string) $element->getText();
            // normalize spaces
            $text = preg_replace('/\xC2\xA0/', ' ', $text);
            $text = preg_replace('/\s+/u', ' ', $text);
            $text = trim($text);
            if ($text === '') continue;

            // 1) Deteksi jenis soal: [JENIS: ...]
            if (preg_match('/\[JENIS\s*:\s*([A-Z0-9]+)\]/iu', $text, $m)) {
                // push current jika ada
                if (isset($current) && currentHasContent($current) && empty($current['added'])) {
                    $soalList[] = $current;
                    $current['added'] = true;
                }

                $jenisStr = strtoupper(trim($m[1]));
                $jenisMap = ['PG' => 1, 'MULTI' => 2, 'BS' => 3, 'JODOH' => 4, 'ESAI' => 5];
                $jenis = $jenisMap[$jenisStr] ?? 0;

                static $nomorCount = [];
                $id_bank = (int)($_POST['id_bank'] ?? 1);
                if (!isset($nomorCount[$id_bank])) $nomorCount[$id_bank] = 1;
                $nomor = $nomorCount[$id_bank]++;

                $current = [
                    'id_bank' => $id_bank,
                    'nomor' => $nomor,
                    'soal' => '',
                    'jenis' => $jenis,
                    'pilA' => '', 'pilB' => '', 'pilC' => '', 'pilD' => '', 'pilE' => '',
                    'perA' => '', 'perB' => '', 'perC' => '', 'perD' => '', 'perE' => '',
                    'jawaban' => '',
                    'fileSoal' => '', 'fileA' => '', 'fileB' => '', 'fileC' => '', 'fileD' => '', 'fileE' => '',
                    'option' => '', 'warna' => '', 'max_skor' => 0, 'added' => false
                ];
                continue;
            }

            // 2) Pertanyaan:
            if (preg_match('/^Pertanyaan\s*:\s*(.*)/iu', $text, $m)) {
                if (isset($current)) $current['soal'] = trim($m[1]);
                continue;
            }

            if (preg_match('/^(\d+)[\.\)\-]\s*(.*)/u', $text, $m)) {
                if (isset($current) && $current['jenis'] == 4) { // hanya JODOH
                    $noSub = (int)$m[1];
                    $subText = trim($m[2]);

                    if (strpos($subText, '#') !== false) {
                        list($left, $right) = explode('#', $subText, 2);
                        $left = trim($left);
                        $right = trim($right);

                        $right = preg_replace('/^(?:#\s*)?([A-E1-5])[\.\)\-]?\s*/iu', '', $right);

                        $letters = ['A','B','C','D','E'];
                        $idx = max(0, $noSub - 1);
                        $key = $letters[$idx] ?? $letters[0];

                        $current['pil' . $key] = trim($left);
                        $current['per' . $key] = trim($right);
                    } else {
                        // tanpa '#' simpan di pil sesuai nomor
                        $letters = ['A','B','C','D','E'];
                        $idx = max(0, $noSub - 1);
                        $key = $letters[$idx] ?? $letters[0];
                        $current['pil' . $key] = trim($subText);
                    }
                }
                continue;
            }

            if (preg_match('/^([A-E1-5])[\.\)\-]\s*(.*)/iu', $text, $m)) {
                if (isset($current)) {
                    $label = strtoupper($m[1]); // 'A' atau '1'
                    $optText = trim($m[2]);

                    if (strpos($optText, '#') !== false) {
                        list($pilText, $perText) = explode('#', $optText, 2);
                        $pilText = trim($pilText);
                        $perText = trim($perText);
                        // Hapus optional '#' dan label di awal perText
                        $perText = preg_replace('/^(?:#\s*)?([A-E1-5])[\.\)\-]?\s*/iu', '', $perText);

                        // Simpan ke pil/per; gunakan label huruf jika label numeric
                        $col = (is_numeric($label)) ? $label : $label; // keep as is; DB columns are pilA..E
                        // If numeric label like '1' we want 'A' mapping? But here common usage: A-E or 1-5 map to same column suffix.
                        // Map numeric 1..5 to A..E for column names:
                        if (is_numeric($col)) {
                            $mapNum = [ '1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E' ];
                            $col = $mapNum[$col] ?? 'A';
                        }

                        $current['pil' . $col] = $pilText;
                        $current['per' . $col] = $perText;
                    } else {
                        // tidak ada '#'
                        $col = (is_numeric($label)) ? $label : $label;
                        if (is_numeric($col)) {
                            $mapNum = [ '1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E' ];
                            $col = $mapNum[$col] ?? 'A';
                        }
                        $current['pil' . $col] = $optText;
                        $current['per' . $col] = '';
                    }

                    $current['option'] = $col;
                }
                continue;
            }

            if (preg_match('/^Jawaban\s*:\s*(.*)/iu', $text, $m)) {
                if (isset($current)) {
                    $jawab = trim($m[1]);
                    switch ($current['jenis']) {
                        case 5:
                             $current['jawaban'] = strtolower($jawab);
                            break;
                        case 4:
                        case 2:
                        case 3:
                            $parts = preg_split('/[,\s]+/u', strtoupper($jawab), -1, PREG_SPLIT_NO_EMPTY);
                            $current['jawaban'] = implode(',', $parts);
                            break;
                        default:
                            $current['jawaban'] = strtoupper($jawab);
                            break;
                    }
                }
                continue;
            }

            if (isset($current)) {
                $opt = $current['option'] ?? '';
                if ($opt === '') {
                    $current['soal'] = trim(($current['soal'] ?? '') . ' ' . $text);
                } else {
                    $field = 'pil' . $opt;
                    $current[$field] = trim(($current[$field] ?? '') . ' ' . $text);
                }
            }
        }
    }
}

if (isset($_FILES['file'])) {
    $fileTmp = $_FILES['file']['tmp_name'];
    $id_bank = (int)($_POST['id_bank'] ?? 1);

    $allImages = [];
    $zip = new ZipArchive;
    if ($zip->open($fileTmp) === TRUE) {
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            if (preg_match('/word\/media\/(.+\.(png|jpg|jpeg|gif|bmp))$/i', $name, $m)) {
                $ext = strtolower($m[2]);
                $imgName = 'img_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                copy("zip://" . $fileTmp . "#" . $name, $uploadDir . $imgName);
                $allImages[] = $imgName;
            }
        }
        $zip->close();
    }

    $phpWord = IOFactory::load($fileTmp);
    $soalList = [];
    $current = null;
    $imageIndex = 0;

    foreach ($phpWord->getSections() as $section) {
        parseElements($section->getElements(), $soalList, $current, $allImages, $imageIndex);
    }

    if (isset($current) && empty($current['added']) && currentHasContent($current)) {
        $soalList[] = $current;
        $current['added'] = true;
    }

    foreach ($soalList as &$s) {
        if ($s['jenis'] == 4) {
            $colors = ['#00BCD4', '#F44336', '#4CAF50', '#FF9800', '#0277BD'];
            $perCount = 0;
            foreach (['perA','perB','perC','perD','perE'] as $p) {
                if (!empty(trim($s[$p] ?? ''))) $perCount++;
            }
            $s['warna'] = implode(',', array_slice($colors, 0, $perCount));
        } else {
            $s['warna'] = '';
        }

        switch ($s['jenis']) {
            case 1: $s['max_skor'] = 1; break;
            case 2:
            case 3:
            case 4:
                $s['max_skor'] = trim($s['jawaban']) !== '' ? count(array_filter(explode(',', $s['jawaban']))) : 0;
                break;
            case 5:
                $s['max_skor'] = 5;
                break;
            default:
                $s['max_skor'] = 0;
        }
    }
    unset($s);

    $columns = [
    'id_bank','nomor','soal','jenis',
    'pilA','pilB','pilC','pilD','pilE',
    'perA','perB','perC','perD','perE',
    'jawaban','fileSoal','fileA','fileB','fileC','fileD','fileE',
    'warna','max_skor'
];
$intCols = ['id_bank','nomor','jenis','max_skor'];

$placeholders = implode(',', array_fill(0, count($columns), '?'));
$query = "INSERT INTO soal (" . implode(',', $columns) . ") VALUES ($placeholders)";
$stmt = $pdo->prepare($query);

$inserted = 0;

foreach ($soalList as $s) {
    if (!currentHasContent($s)) continue;

    $params = [];
    foreach ($columns as $col) {
        if (in_array($col, $intCols)) {
            $params[] = (int)($s[$col] ?? 0);
        } else {
            $params[] = (string)($s[$col] ?? '');
        }
    }

    if ($stmt->execute($params)) {
        $inserted++;
        $idsoal = $pdo->lastInsertId(); 
    }
}

echo "Selesai import. Total soal yang dimasukkan: {$inserted}";
exit;
}


echo "Tidak ada file yang diupload.";
?>
