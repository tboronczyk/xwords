#! /usr/bin/php
<?php
$filename = $_SERVER['argv'][1];
if (empty($filename)) {
	echo "usage: clean-sort.php filename\n";
	exit;
}

$values = [
	'a' => 1,    'g' => 8,     'k' => 15,    's' => 22,
	'b' => 2,    'ĝ' => 9,     'l' => 16,    'ŝ' => 23,
	'c' => 3,    'h' => 10,    'm' => 17,    't' => 24,
	'ĉ' => 4,    'ĥ' => 11,    'n' => 18,    'u' => 25,
	'd' => 5,    'i' => 12,    'o' => 19,    'ŭ' => 26,
	'e' => 6,    'j' => 13,    'p' => 20,    'v' => 27,
	'f' => 7,    'ĵ' => 14,    'r' => 21,    'z' => 28,
];

$words = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

usort($words, function ($word1, $word2) use ($values) {
	$max = min(mb_strlen($word1), mb_strlen($word2));
	for ($i = 0; $i < $max; $i++) {
		$a = $values[mb_substr($word1, $i, 1)] ?? 0;
		$b = $values[mb_substr($word2, $i, 1)] ?? 0;
		if ($a == $b) {
			continue;
		}
		return ($a > $b) ? 1 : -1;
	}
	return -1;
});

echo join("\n", $words) . "\n";
