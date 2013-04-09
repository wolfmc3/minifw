<?php
use framework\app;
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

spl_autoload_register(function($className) {
	//echo "\nSearch class: $className = ";
	if($className[0] == '\\') {
		$className = substr($className, 1);
	}
	if(strpos($className, 'framework') !== 0 && strpos($className, 'views') !== 0) return;
	
	$classPath = str_replace("\\", "/", $className) .'.php';

	$file = __DIR__ . "/$classPath";
	//echo "$file";
	if (file_exists($file)) {
		//echo " OK ";
		require($file);
	}
	//echo "\n";
	/*echo $className.":";
	print_r(get_class_methods($className));*/
	
},true,true);

app::init();
$controller = app::Controller();
$page = $controller->getPage();
$page->addCss(app::root()."css/style1.css");
$page->addCss(app::root()."css/menu.css");
$page->setMenu("menu");
$controller->render();