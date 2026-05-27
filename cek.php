<?php
$exts = [
    'curl',
    'dom',
    'fileinfo',
    'filter',
    'gd',
    'intl',
    'json',
    'mbstring',
    'openssl',
    'pdo',
    'pdo_mysql',
    'pdo_pgsql',
    'pdo_sqlite',
    'session',
    'tokenizer',
    'xml',
    'zip',
];

foreach($exts as $e){
    echo $e . ' : ' . (extension_loaded($e) ? 'OK' : 'MISSING') . "<br>";
}
