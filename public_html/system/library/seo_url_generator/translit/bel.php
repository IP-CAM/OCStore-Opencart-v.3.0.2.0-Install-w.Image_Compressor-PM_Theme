<?php

/*
 * На правила русского языка наложены правила белорусского - https://ru.wikipedia.org/wiki/%D0%A2%D1%80%D0%B0%D0%BD%D1%81%D0%BB%D0%B8%D1%82%D0%B5%D1%80%D0%B0%D1%86%D0%B8%D1%8F_%D0%B1%D0%B5%D0%BB%D0%BE%D1%80%D1%83%D1%81%D1%81%D0%BA%D0%BE%D0%B3%D0%BE_%D0%B0%D0%BB%D1%84%D0%B0%D0%B2%D0%B8%D1%82%D0%B0_%D0%BB%D0%B0%D1%82%D0%B8%D0%BD%D0%B8%D1%86%D0%B5%D0%B9
 */

function sug_translit_bel_title() {
	return 'Беларуская у лацінку';
}

function sug_translit_bel($string) {
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
		"Б"=>"B",
		"б"=>"b",
		"В"=>"V",
		"в"=>"v",
		"Г"=>"G",
		"г"=>"g",
		"Д"=>"D",
		"д"=>"d",
		"Е"=>"Je",
		"е"=>"je", // bel customized
		"Ё"=>"Jo",
		"ё"=>"jo", // bel customized
		"Ж"=>"Zh",
		"ж"=>"zh", // Под вопросом
		"З"=>"Z",
		"з"=>"z",
		"І"=>"I",
		"і"=>"i", // bel customized
		"Й"=>"J",
		"й"=>"j",
		"К"=>"K",
		"к"=>"k",
		"Л"=>"L",
		"л"=>"l",
		"М"=>"M",
		"м"=>"m",
		"Н"=>"N",
		"н"=>"n",
		"О"=>"O",
		"о"=>"o",
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
		"Ў"=>"U",
		"ў"=>"u", // bel customized
		"Ф"=>"F",
		"ф"=>"f",
		"Х"=>"H",
		"х"=>"h",
		"Ц"=>"C",
		"ц"=>"c",
		"Ч"=>"Ch",
		"ч"=>"ch",
		"Ш"=>"Sh",
		"ш"=>"sh",
		"Щ"=>"Shch",
		"щ"=>"shch",
		"Ы"=>"Y",
		"ы"=>"y",
		"Э"=>"Eh",
		"э"=>"eh",
		"Ю"=>"Yu",
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
