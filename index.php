<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

spl_autoload_register(function($className) {
	//echo "Search class:$className\n";
	
	if($className[0] == '\\') {
		$className = substr($className, 1);
	}
	
	// Leave if class should not be handled by this autoloader
	if(strpos($className, 'framework') !== 0) return;
	
	$classPath = str_replace("\\", "/", $className) .'.php';
	//echo __DIR__ . "/$classPath\n";
	require(__DIR__ . "/$classPath");
},false,true);

$controller = new framework\controller();
$page = $controller->getPage();
$page->addCss($controller->getAppRoot()."css/style1.css");
$page->addCss($controller->getAppRoot()."css/menu.css");
$page->setMenu("menu");
$controller->render();