<?php
class CustomFields {
	private $types;
	

	public function __construct() {
		$files = glob(DIR_SYSTEM . 'library/custom_fields/*');
	
		if ($files) {
			foreach ($files as $file) {
				$type = basename($file);				
				$this->types[]=$type;
			}
		}
	}
	
	public function getTypes(){
		return $this->types;
	}
	
	public function renderLangTabs($languages, $tab){
		
		$ret = '<ul class="nav nav-tabs" id="language-custom-fields-'.$tab.'">';
		
		foreach ($languages as $language) {
			$ret .= '<li><a href="#language-custom-fields-'.$tab.'-'.$language['language_id'].'" data-toggle="tab"><img src="language/'. $language['code'].'/'.$language['code'].'.png" title="'.$language['name'].'" /> '.$language['name'].'</a></li>';
		}
		$ret .= '</ul>';
		$ret .= '<div class="tab-content">';
		
		
		return $ret;
	}
	
	public function renderLangBegin($language, $tab){
		return '<div class="tab-pane" id="language-custom-fields-'.$tab.'-'.$language['language_id'].'">';
	}
	
	public function renderLangEnd(){
		$ret ='</div>';
		return $ret;
	}
	
	public function renderScript($tab){
	
		$ret ='</div><script type="text/javascript"><!--
		$(\'#language-custom-fields-'.$tab.' a:first\').tab(\'show\');
		//--></script>';
		return $ret;
	}
	
}



?>