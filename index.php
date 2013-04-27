<?php
//error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);

spl_autoload_register(function($className) {
	//echo "\nSearch class: $className = ";
	if($className[0] == '\\') {
		$className = substr($className, 1);
	}
	if(
		strpos($className, 'framework') !== 0 && 
		strpos($className, 'views') !== 0 && 
		strpos($className, 'modules') !== 0
	) return;
	
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
use framework\app;
use menu\mainmenu;
	
app::init();
$page = app::Controller()->getPage();

$page->addCss(app::conf()->system->maincss);
$page->addJavascript(app::conf()->system->mainjs);
app::Controller()->addModule("applink", "\\modules\\applink");
app::Controller()->addModule("footer", "\\modules\\footer");
app::Controller()->addModule("themeswitch", "\\modules\\themeswitch");
app::Controller()->addModule("logincontrol", "\\modules\\logincontrol");
app::Controller()->addModule("menu", "\\modules\\mainmenu");
app::Controller()->render();

