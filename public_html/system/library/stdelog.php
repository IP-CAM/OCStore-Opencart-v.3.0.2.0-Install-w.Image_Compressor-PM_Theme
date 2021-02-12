<?php

/**
 * @category OpenCart
 * @package StdeLog
 * @description Amateur Log for OpenCart
 * @version 0.9.0
 * @copyright © Serge Tkach, 2020, http://sergetkach.com/
 */

class StdeLog {
	private $filename = 'StdeLog';
	private $debug = 1;

	public function __construct($filename) {
		$this->setFilename($filename);
	}

	public function setFilename($filename) {
		$this->filename = $filename;
	}

	public function setDebug($debug) {
		$this->debug = $debug;
	}

	/*
	 * Используется следующая классификация логов:
	 * 1 (error) - логируем только ошибки (хотя также бывают еще и fatal и warning)
	 * 2 (info) - логируем только крупные операции, которые проявляются редко (нажатие на кнопку генерации к пример...)
	 * 3 (debug) - логируем крупные операции + данные в запросах пользователя + другие доп сведения...
	 * 4 (trace) - логируем все подряд, если дебаг не помогает
	 * По мотивам https://habr.com/ru/post/135242/
	 */
	
	/*
	 * $this->stdelog->write(2, 'generateProductKeyword() is called'); // Запишет переданный текст, если debug будет >= 2
	 * $this->stdelog->write(4, $a_data, 'generateProductKeyword() : $a_data'); // Запишет переменную переданный текст, если debug будет >= 2
	 */

	// TODO
	// Q??
	// Может сделать так, чтобы в случае ERROR, они бы записывались еще и в отдельный файл??
	function write($level, $data, $title = false, $filename = false) {
		if ($level > $this->debug) {
			return false;
		}

		$levels = array(
			1	=>'ERROR',
			2	=>'INFO',
			3	=>'DEBUG',
			4	=>'TRACE'
		);

		// TODO
		// Тут можно дописать удаление вчерашних логов

		if (!$filename) {
			$filename = $this->filename;
		}

		if (is_string($data)) {
			$str = '';

			if ($title) {
				$str = "$title : ";
			}

			$str .= $data;

			file_put_contents(DIR_LOGS . $filename . '_' . date("Y-m-d") . '.log', $levels[$level] . ' -- [' . date("Y/m/d H:i:s") . '] -- ' . $str . "\r\n------------------------------------------------------------------------------------\r\n", FILE_APPEND | LOCK_EX);
		} else {
			ob_start();

			if ($title) {
				echo "$title:\r\n";
			} else {
				echo "Array\r\n";
			}

			print_r($data);
			$c = ob_get_contents();
			ob_clean();

			file_put_contents(DIR_LOGS . $filename . '_' . date("Y-m-d") . '.log', $levels[$level] . ' -- [' . date("Y/m/d H:i:s") . '] -- ' . "$c" . "\r\n------------------------------------------------------------------------------------\r\n", FILE_APPEND | LOCK_EX);
		}
	}

}
