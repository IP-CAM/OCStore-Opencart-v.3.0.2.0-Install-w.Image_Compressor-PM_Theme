<?php

/*
 * Казахский алфавит взят - https://www.zakon.kz/perevod_na_latinicu.html
 */

function sug_translit_kaz_title() {
	return 'қазақша ішінде латын';
}

function sug_translit_kaz($string) {
	$arStrES = array(
		"цх",
		"сх",
		"ех",
		"хх"
	);
	$arStrRS = array(
		"ц$",
		"с$",
		"е$",
		"х$"
	);

	$replace = array(
		"А"=>"A",
		"а"=>"a",
		"Ә"=>"Ae",
		"ә"=>"ae", // kaz customized
		"Б"=>"B",
		"б"=>"b",
		"В"=>"V",
		"в"=>"v",
		"Г"=>"G",
		"г"=>"g",
		"Ғ"=>"Gh",
		"ғ"=>"gh", // kaz customized
		"Д"=>"D",
		"д"=>"d",
		"Е"=>"E",
		"е"=>"e",
		"Ё"=>"Yo",
		"ё"=>"yo",
		"Ж"=>"Zh",
		"ж"=>"zh",
		"З"=>"Z",
		"з"=>"z",
		"И"=>"I",
		"и"=>"i",
		"Й"=>"J",
		"й"=>"j",
		"К"=>"K",
		"к"=>"k",
		"Қ"=>"Q",
		"қ"=>"q", // kaz customized
		"Л"=>"L",
		"л"=>"l",
		"М"=>"M",
		"м"=>"m",
		"Н"=>"N",
		"н"=>"n",
		"Ң"=>"N",
		"ң"=>"n", // kaz customized
		"О"=>"O",
		"о"=>"o",
		"Ө"=>"Oe",
		"ө"=>"oe", // kaz customized
		"П"=>"P",
		"п"=>"p",
		"Р"=>"R",
		"р"=>"r",
		"С"=>"S",
		"с"=>"s",
		"Т"=>"T",
		"т"=>"t",
		"У"=>"U",
		"у"=>"u",
		"Ұ"=>"U",
		"ұ"=>"u", // kaz customized
		"Ү"=>"U",
		"ү"=>"u", // kaz customized
		"Ф"=>"F",
		"ф"=>"f",
		"Х"=>"H",
		"х"=>"h",
		"Һ"=>"H",
		"һ"=>"h", // kaz customized
		"Ц"=>"C",
		"ц"=>"c",
		"Ч"=>"Ch",
		"ч"=>"ch",
		"Ш"=>"Sh",
		"ш"=>"sh",
		"Щ"=>"Shch",
		"щ"=>"shch",
		"ъ"=>"", // kaz customized
		"Ы"=>"Y",
		"ы"=>"y",
		"І"=>"I",
		"і"=>"i", // kaz customized
		"Э"=>"Eh",
		"э"=>"eh",
		"Ю"=>"Уu",
		"ю"=>"yu",
		"Я"=>"Ja",
		"я"=>"ja",
		"ъ"=>"",
		"ь"=>"",
		"$"=>"kh",
		"«"=>"",
		"»"=>"",
		"„"=>"",
		"“"=>"",
		"“"=>"",
		"”"=>"",
		"\•"=>""
	);

	$string = str_replace($arStrES, $arStrRS, $string);

	return iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $replace));
}
