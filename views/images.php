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
		$imagessize =[50,100,150,200,250];
		$iconsize = [12,24,32,64,128,256];
		$imagelist = [
			"user/minifw.jpg"=>["T"=>"Mini fw","D"=>"Questo framework fà anche il caffè","S"=>3,"A"=>TRUE,"L"=>"#"],
			"user/castle.jpg"=>["T"=>"Paesaggi","D"=>"Ho sempre gradito i paesaggi, sono rilassanti","S"=>3,"A"=>FALSE,"L"=>"#"],
			"user/beach.jpg"=>["T"=>"Natura","D"=>"La natura è un miracolo che si perpetua ogni giorno davanti ai nostri occhi.","S"=>3,"A"=>FALSE,"L"=>"#"],
			"user/animal.jpg"=>["T"=>"Animali","D"=>"Non importa se sei leone o gazella... inizia a correre","S"=>3,"A"=>FALSE,"L"=>"#"],
		];
		
		$cont = new element();
		$carousel = new carousel("car1",["style"=>"margin-left:auto;margin-right:auto;","class"=>"center"],5000);
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
		
		$cont->append(new element("h3"))->add("Anteprime con link");
		
		$thu = new thumbnails();
		foreach ($imagelist as $img => $data) {
			$thu->addThumbnail($img."/height/160/box/160/160",app::root()."img/".$img."/resize/1024/1024/",NULL,NULL,2);
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
			$cont->append(new img("icon.png/blur/$i/10/width/125"));
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