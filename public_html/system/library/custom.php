<?php
// подключите в system/framework.php например так
// $custom = new custom();
// $registry->set('custom', $custom);

// затем можете из любой точки добавлять окончание
// 'товар' . $this->custom->convertEnding( $кол-товара );
// 'рубл' . $this->custom->convertEnding( $кол-товара, array('ь','я','ей') ); // или так если например необходимо нестандартное окончание в примере для рублей

class Custom {

	public function convertEnding($value = 1, $status = array('','а','ов')) {
		$array = array(2,0,1,1,1,2);
		return $status[($value % 100 > 4 && $value % 100 < 20)? 2 : $array[($value % 10 < 5) ? $value % 10 : 5]];
  }


  public function validateDate($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }

}
