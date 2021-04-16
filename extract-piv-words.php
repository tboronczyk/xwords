#! /usr/bin/php
<?php
if (!file_exists('piv2.xml')) {
    file_put_contents('piv2.xml', file_get_contents(
        'http://kursoj.pagesperso-orange.fr/piv2/piv2.xml'
    ));
}

// manually maintained list of roots to remove (plant names, medical terms, etc.)
$removeFilter = file('remove.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$structFilter = array_map(function ($x) { return "{$x}o~"; }, $removeFilter);

// extract adjectives, adverbs, verbs, nouns, and free-standing words
$categories = ['a', 'e', 'i', 'o', 'memstara'];

mb_regex_encoding('UTF-8');
mb_internal_encoding('UTF-8');

$xml = simplexml_load_file('piv2.xml');
foreach ($xml->radiko as $r) {
	if (in_array($r->kap, $removeFilter)) {
	    continue;
	}

    foreach ($r->drv as $drv) {
		$word = (string)$drv['form'];

    	if (!in_array($r['kat'], $categories)) {
    		continue;
    	}

		// skip entries that are capitalized to avoid proper names
		$char = mb_substr($word, 0, 1);
		if ($char == mb_strtoupper($char)) {
			continue;
		}

		// skip entries with punctuation or spaces
		if (mb_ereg_match('.*[-! ]', $word)) {
			continue;
		}

		foreach ($structFilter as $filter) {
			if (mb_ereg_match($filter, (string)$drv['strukt'])) {
				continue 2;
			}
		}

		// output root only for nouns
		$char = mb_substr($word, -1, 1);
		if ($char == 'o') {
			$word = mb_substr($word, 0, -1);
		}

    	echo mb_strtoupper($word) . "\n";
    }
}
