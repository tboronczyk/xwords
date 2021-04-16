#! /usr/bin/php
<?php
$filename = $_SERVER['argv'][1];
if (empty($filename)) {
	echo "usage: clean-dupes.php filename\n";
	exit;
}

$words = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$words = array_unique($words);
foreach ($words as $w) {
	echo "$w\n";
}
