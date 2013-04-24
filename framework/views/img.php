<?php 
namespace framework\views;
use framework\page;
use framework\app;
class img extends page {
	protected $type = page::TYPE_CUSTOM;
	function action_def() {
		header('HTTP/1.0 404 Not Found');
	}

	function action_other() {
		//echo "\n".__DIR__.app::root()."img/".$this->action.":\n";
		//echo "\nimmagine:".app::Controller()->uri.PHP_EOL;
		$uri = array_slice(app::Controller()->parseduri, 0);
		$img = "img";
		reset($uri);
		while (!is_file($img)) {
			$part = next($uri);
			if ($part === FALSE) {
				echo "\nERROR\n";
				$this->action_def();
				return;
			}
			$img .= "/".$part;
		}
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$type = finfo_file($finfo, $img);

		$operation = next($uri);
		if ($operation) {
			if ($operation == "resize") {
				$newwidth = intval(next($uri));

				list($width, $height) = getimagesize($img);
				$percent = $newwidth/$width;
				$newwidth = intval($width * $percent);
				$newheight = intval($height * $percent);

				$tmp = app::conf()->system->imagecache;
				$tmpname = $tmp.urlencode($img."_resize_".$newwidth."x".$newheight.".png");
				
				if (!file_exists($tmpname)){
					// Load
					$thumb = imagecreatetruecolor($newwidth, $newheight);
					$trans_colour = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
					imagefill($thumb, 0, 0, $trans_colour);
					imagealphablending($thumb, true); // setting alpha blending on
					imagesavealpha($thumb, true);

					if ($type == "image/jpeg") {
						$source = imagecreatefromjpeg($img);
					} elseif ($type == "image/png") {
						$source = imagecreatefrompng($img);
						//$col=imagecolorallocatealpha($thumb,255,255,255,127);
					} elseif ($type == "image/gif") {
						$source = imagecreatefromgif($img);
					}
						
					// Resize
					imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

					// Output
					imagepng($thumb,$tmpname,9);
					imagedestroy($thumb);
					imagedestroy($source);
				}
				header('Content-Type: image/png');
				readfile($tmpname);
			} 
		} else {
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($img));
			readfile($img);
		}
	}

}