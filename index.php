<?php
use framework\app;
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

spl_autoload_register(function($className) {
	//echo "Search class:$className\n";
	
	if($className[0] == '\\') {
		$className = substr($className, 1);
	}
	
	// Leave if class should not be handled by this autoloader
	if(strpos($className, 'framework') !== 0 && strpos($className, 'views') !== 0) return;
	
	$classPath = str_replace("\\", "/", $className) .'.php';
	//echo __DIR__ . "/$classPath\n";
	require(__DIR__ . "/$classPath");
},false,true);

app::init();
$controller = app::Controller();
$page = $controller->getPage();
$page->addCss(app::root()."css/style1.css");
$page->addCss(app::root()."css/menu.css");
$page->setMenu("menu");
$controller->render();