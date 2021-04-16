#! /usr/bin/php
<?php
$filename = $_SERVER['argv'][1];
$size = (int)$_SERVER['argv'][2];
if (empty($filename) || $size == 0) {
	echo "usage: exctract-n-length.php filename size\n";
	exit;
}

$words = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$words = array_unique($words);
foreach ($words as $w) {
	if (mb_strlen($w, 'UTF-8') == $size) {
	    echo "$w\n";
	}
}
