<?php 
use framework\html\dotlist;
use framework\html\anchor;
use framework\app;
use framework\html\element;
use framework\html\logincontrol;
use framework\html\img;
$cont = new element();
$cont->add(new img("icon.png"));
$menu = new dotlist("");
$apppath = app::root();
if (isset($_SERVER['HTTP_REFERER'])) $menu->add(new anchor($_SERVER['HTTP_REFERER'], "<")); 
$menu->add(new anchor($apppath, "Home"));
$menu->add(new anchor($apppath."customers/", "Clienti"));
$menu->add(new anchor($apppath."employees/", "Dipendenti"));
$menu->add(new anchor($apppath."offices/", "Sedi"));
$menu->add(new anchor($apppath."products/", "Prodotti"));
$menu->add(new anchor($apppath."login/", "Login"));
$cont->add($menu);

$cont->add(new logincontrol());
echo $cont;
