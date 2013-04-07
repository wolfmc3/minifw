<?php 
use framework\html\dotlist;
use framework\html\anchor;
use framework\app;
$menu = new dotlist("");
$apppath = app::root();
if (isset($_SERVER['HTTP_REFERER'])) $menu->addElement(new anchor($_SERVER['HTTP_REFERER'], "<")); 
$menu->addElement(new anchor($apppath, "Home"));
$menu->addElement(new anchor($apppath."customers/", "Clienti"));
$menu->addElement(new anchor($apppath."employees/", "Dipendenti"));
$menu->addElement(new anchor($apppath."offices/", "Sedi"));
$menu->addElement(new anchor($apppath."products/", "Prodotti"));
echo $menu;
