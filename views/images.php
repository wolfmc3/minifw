<?php 
namespace views;
use framework\page;
use framework\html\element;
use framework\html\html;
use framework\html\responsive\carousel;
use framework\html\img;
use framework\html\source;
use framework\html\responsive\thumbnails;
use framework\app;

class images extends page {
	protected $title = "Image show";
	function action_def() {
		$imagessize =array(50,100,150,200,250);
		$iconsize = array(12,24,32,64,128,256);
		$imagelist = array(
			"user/minifw.jpg"=>array("T"=>"Mini fw","D"=>"Questo framework fà anche il caffè","S"=>3,"A"=>TRUE,"L"=>"#"),
			"user/castle.jpg"=>array("T"=>"Paesaggi","D"=>"Ho sempre gradito i paesaggi, sono rilassanti","S"=>3,"A"=>FALSE,"L"=>"#"),
			"user/beach.jpg"=>array("T"=>"Natura","D"=>"La natura è un miracolo che si perpetua ogni giorno davanti ai nostri occhi.","S"=>3,"A"=>FALSE,"L"=>"#"),
			"user/animal.jpg/enh"=>array("T"=>"Animali","D"=>"Non importa se sei leone o gazella... inizia a correre","S"=>3,"A"=>FALSE,"L"=>"#"),
		);
		
		$imageeffects = array(
			"user/animal.jpg"=>"Normale",
			"user/animal.jpg/sepia"=>"Seppia",
			"user/animal.jpg/bw"=>"Bianco e nero",
			"user/animal.jpg/enh"=>"Migliorato",
		);
		
		$cont = new element();
		$carousel = new carousel("car1",array("style"=>"margin-left:auto;margin-right:auto;","class"=>"center"),5000);
		foreach ($imagelist as $img => $data) {
			$carousel->addSlide($img, $data["T"],$data["D"],$data["A"]);
		}
		$cont->append($carousel);
		$cont->addBR(2);
		
		$cont->append(new element("h3"))->add("Anteprime con titolo, descrizione e link");
		
		$thu = new thumbnails();
		foreach ($imagelist as $img => $data) {
			$thu->addThumbnail($img."/height/360/box/360/360",$data["L"], $data["T"],$data["D"],$data["S"]);
		}
		$cont->append($thu);
		$cont->addBR(2);
		
		$cont->append(new element("h3"))->add("Effetti");
		
		$thu = new thumbnails();
		foreach ($imageeffects as $img => $title) {
			$thu->addThumbnail($img."/height/250/box/250/190","#",$title,NULL,3);
		}
		$cont->append($thu);
		$cont->addBR(2);
		
		$cont->append(new element("h3"))->add("Ridimensionamento immagini lato server");
		foreach ($imagessize as $size) {
			$cont->append(new img("minifwlogo.jpg/width/$size/box/$size/$size"));
		}
		
		$cont->append(new element("h3"))->add("Sfocature");
		$i = 0;
		foreach ($imagessize as $size) {
			$cont->append(new img("user/castle.jpg/blur/$i/10/box/512/512/width/125"));
			$i += 2;
		}
		
		$cont->append(new element("h3"))->add("Ridimensionamento icone lato server");
		foreach ($iconsize as $size) {
			$cont->append(new img("icon.png/width/$size"));
		}
		
		$cont->addBR(2);
		$cont->append(new source($this->name()));
		return $cont;
	}
}