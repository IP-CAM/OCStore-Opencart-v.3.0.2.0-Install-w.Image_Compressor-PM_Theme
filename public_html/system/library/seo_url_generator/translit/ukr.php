<?php

 /*
 * https://habrahabr.ru/post/187778/ взят за основу, но переделан
 * Поправку на правила транслтерации Яндекса выполнил fildenis https://opencartforum.com/profile/673970-fildenis/
 * Сайт для проверки соответствия правилам Яндекса http://translit-online.ru/yandex.html
 */

function sug_translit_ukr_title() {
	return 'Українська латиницею';
}

function sug_translit_ukr($string) {
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
		"Е"=>"E",
		"е"=>"e",
		"Ё"=>"Yo",
		"ё"=>"yo",
		"Ж"=>"Zh",
		"ж"=>"zh",
		"З"=>"Z",
		"з"=>"z",
		// ukr customized.begin
		"И"=>"Y",
		"и"=>"y",
		"І"=>"I",
		"і"=>"i",
		"Ї"=>"Yi",
		"ї"=>"yi",
		"Є"=>"Ye",
		"є"=>"ye",
		// ukr customized.end
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
		"Я"=>"Ya",
		"я"=>"ya",
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