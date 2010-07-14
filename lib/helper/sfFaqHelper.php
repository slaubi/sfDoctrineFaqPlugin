<?php

function stripText($text)
{ 
	// rewrite critical characters
	// French
	$text = str_replace(array('À', 'Â', 'à', 'â'), 'a', $text);
	$text = str_replace(array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ê', 'ë'), 'e', $text);
	$text = str_replace(array('Î', 'Ï', 'î', 'ï'), 'i', $text);
	$text = str_replace(array('Ô', 'ô'), 'o', $text);
	$text = str_replace(array('Ù', 'Û', 'ù', 'û'), 'u', $text);
	$text = str_replace(array('Ç', 'ç'), 'c', $text);
	// German
	$text = str_replace(array('Ä', 'ä'), 'ae', $text);
	$text = str_replace(array('Ö', 'ö'), 'oe', $text);
	$text = str_replace(array('Ü', 'ü'), 'ue', $text);
	$text = str_replace('ß', 'ss', $text);
	// Spanish
	$text = str_replace(array('Ñ', 'ñ'), 'n', $text);
	$text = str_replace(array('Á', 'á'), 'a', $text);
	$text = str_replace(array('Í', 'í'), 'i', $text);
	$text = str_replace(array('Ó', 'ó'), 'o', $text);
	$text = str_replace(array('Ú', 'ú'), 'u', $text);

	// strip all non word chars
	$text = preg_replace('/[^a-z0-9_-]/i', ' ', $text);

	// strtolower is not utf8-safe, therefore it can only be done after special characters replacement
	$text = strtolower($text);

	// replace all white space sections with a dash
	$text = preg_replace('/\ +/', '-', $text);

	// trim dashes
	$text = preg_replace('/\-$/', '', $text);
	$text = preg_replace('/^\-/', '', $text);

	return $text;
}