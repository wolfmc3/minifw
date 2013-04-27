<?php 
namespace framework\views;
use framework\page;
use framework\app;
class themeswitcher extends page {
	protected $type = self::TYPE_REDIRECT;
	function action_def() {
		$url = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:app::root();
		$theme = $_POST["newtheme"];
		if (file_exists("themes/$theme")){
			$_SESSION["theme"] =  $theme;			
		}
		return $url;
	}
}