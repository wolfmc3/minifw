<?php 
use framework\html\dotlist;
use framework\html\anchor;
use framework\app;
$menu = new dotlist("");
$apppath = app::root();
if (isset($_SERVER['HTTP_REFERER'])) $menu->add(new anchor($_SERVER['HTTP_REFERER'], "<")); 
$menu->add(new anchor($apppath, "Home"));
$menu->add(new anchor($apppath."customers/", "Clienti"));
$menu->add(new anchor($apppath."employees/", "Dipendenti"));
$menu->add(new anchor($apppath."offices/", "Sedi"));
$menu->add(new anchor($apppath."products/", "Prodotti"));
echo $menu;
