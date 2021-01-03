<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Pagination class
*/
class Pagination {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 3;
	public $url = '';
	public $text_first = '|&lt;';
	public $text_last = '&gt;|';
	public $text_prev = '<span class="visually-hidden">Предыдущая страница</span><svg class="pagination__icon-arrow" viewBox="0 0 24 24" width="32" height="32" aria-hidden="true"><polyline points="14 7 10 12 14 17" fill="none" stroke-width="2px" stroke-linecap="round" stroke-linejoin="round"/></svg>';
	public $text_next = '<span class="visually-hidden">Следующая страница</span></span><svg class="pagination__icon-arrow" viewBox="0 0 24 24" width="32" height="32" aria-hidden="true"><polyline points="10 17 14 12 10 7" fill="none" stroke-width="2px" stroke-linecap="round" stroke-linejoin="round"/></svg>';

	/**
     *
     *
     * @return	text
     */
	public function render() {
		$total = $this->total;

		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}

		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}

		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);

		$this->url = str_replace('%7Bpage%7D', '{page}', $this->url);

		$output = '<nav class="pagination" aria-label="Пагинация"><ul class="pagination__list">';


    // * кнопка "назад"
    if ($page === 1) { // если текущая страница первая
      // Если текущая страница первая - выключенная кнопка назад без ссылки
      $output .= '<li class="pagination__item"><a class="pagination__link-arrow pagination__link-arrow--disabled">' . $this->text_prev . '</a></li>';
    } elseif ($page - 1 === 1) { // если текущая страница вторая
      //Выводится кнопка "назад" с ссылкой на 1ю страницу
      $output .= '<li class="pagination__item"><a class="pagination__link-arrow" href="' . str_replace(array('&amp;page={page}', '?page={page}', '&page={page}'), '', $this->url) . '">' . $this->text_prev . '</a></li>';
    } else { // любая другая страница
      //Выводится кнопка "назад" с ссылкой на предыдущую страницу
      $output .= '<li class="pagination__item"><a class="pagination__link-arrow" href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a></li>';
    }

    $prefix = '';
    $postfix = '';

		if ($num_pages > 1) {
      if (($num_pages <= 6) || ($num_pages == 7 && $page == 4)) { // если страниц 6 и менее или страниц 7 и текущая 4
        // выводим все страницы
				$start = 1;
				$end = $num_pages;
			} else {

        $start = $page - floor($num_links / 2);
        $end = $page + floor($num_links / 2);

				if ($page <= 3) {
          $start = 1;
					$end = 4;
        } elseif ($page == 4) {
          $start = 1;
					$end = 5;
        } else {
          $prefix = '<li class="pagination__item"><a class="pagination__link" href="' . str_replace(array('&amp;page={page}', '?page={page}', '&page={page}'), '', $this->url) . '">' . '1' . '</a></li>';
          $prefix .= '<li class="pagination__item"><span class="pagination__dots">' . '...' . '</span></li>';
        }

        if ($page >= $num_pages - 2) {
          $start = $num_pages - 3;
          $end = $num_pages;
        } elseif ($page == $num_pages - 3) {
          $start = $num_pages - 4;
          $end = $num_pages;
        } else {
          $postfix = '<li class="pagination__item"><span class="pagination__dots">' . '...' . '</span></li>';
          $postfix .= '<li class="pagination__item"><a class="pagination__link" href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $num_pages . '</a></li>';
        }
      }

      $output .= $prefix;

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
          // active
					$output .= '<li class="pagination__item"><a class="pagination__link pagination__link--active" aria-current="page"><span class="visually-hidden">страница </span>' . $i . '</a></li>';
				} else {
					if ($i === 1) {
						$output .= '<li class="pagination__item"><a class="pagination__link" href="' . str_replace(array('&amp;page={page}', '?page={page}', '&page={page}'), '', $this->url) . '"><span class="visually-hidden">страница </span>' . $i . '</a></li>';
					} else {
						$output .= '<li class="pagination__item"><a class="pagination__link" href="' . str_replace('{page}', $i, $this->url) . '"><span class="visually-hidden">страница </span>' . $i . '</a></li>';
					}
				}
      }

      $output .= $postfix;

		}


    // * КНОПКА ВПЕРЕД
    if ($page < $num_pages) { // Если номер текущей страницы меньше, чем всего страниц
      $output .= '<li class="pagination__item"><a class="pagination__link-arrow" href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a></li>';
    } else {
      $output .= '<li class="pagination__item"><a class="pagination__link-arrow pagination__link-arrow--disabled">' . $this->text_next . '</a></li>';
    }


		$output .= '</ul></nav>';

		if ($num_pages > 1) {
			return $output;
		} else {
			return '';
		}
	}
}
