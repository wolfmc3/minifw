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

		if (next($uri)) {
			$tmp = app::conf()->system->imagecache;
			$tmpname = $tmp.urlencode(implode("_", $uri).".png");
			prev($uri);
			if (!file_exists($tmpname) || TRUE){ 
				$source = $this->loadimage($img);
				$i = 0;
				while (($operation = next($uri)) !== FALSE) {
					/*if (ctype_alpha($operation)) {
						$draw = new \ImagickDraw();
						$draw->setFillColor('white');
						$draw->setFont('Arial');
						$draw->setFontSize( 15 );
						
						$source->annotateimage($draw, 15, 15*$i++, 0, $operation);
					}*/
					try {
						if (ctype_alpha($operation) && $operation == "blur") {
							$sigma = intval(next($uri));
							$radius = intval(next($uri));
							$source->blurimage($radius, $sigma);
						} elseif (ctype_alpha($operation) && $operation == "width") {
							$newwidth = intval(next($uri));
							$source = $this->resize($source, $newwidth);
						} elseif (ctype_alpha($operation) && $operation == "height") {
							$newheight = intval(next($uri));
							$source = $this->resize($source,0, $newheight);
						} elseif (ctype_alpha($operation) && $operation == "resize") {
							$newwidth = intval(next($uri));
							$newheight = intval(next($uri));
							$source = $this->resize($source,$newwidth, $newheight);
						} elseif (ctype_alpha($operation) && $operation == "box") {
							$newwidth = intval(next($uri));
							$newheight = intval(next($uri));
							$source = $this->box($source,$newwidth, $newheight);
						}
					} catch (Exception $e) {
						continue;
					}

				}

				$source->writeimage($tmpname);
				$img = $tmpname;
				$type = "image/png";
			} else  {
				$img = $tmpname;
				$type = "image/png";
			}
		}

		header('Content-Type:'.$type);
		header('Content-Length: ' . filesize($img));
		readfile($img);

	}

	/**
	 * 
	 * @param string $file
	 * @param string $type
	 * @return \Imagick
	 */
	private function loadimage($file) {
		$source = new \Imagick($file);
		$source->setimageformat("png");
		return $source;
	}
/**
 * 
 * @param \Imagick $source
 * @param number $newwidth
 * @param number $newheight
 * @throws \Exception
 * @return \Imagick
 */
	private function resize(&$source,$newwidth = 0,$newheight = 0) {
		list($width,$height) = array_values($source->getimagegeometry());

		if ($newwidth && $newheight == 0) { //COMANDA la larghezza
			$ratio = $newwidth/$width;
			$newwidth = intval($width * $ratio);
			$newheight = intval($height * $ratio);
		} elseif ($newwidth == 0 && $newheight) {
			$ratio = $newheight/$height;
			$newwidth = intval($width * $ratio);
			$newheight = intval($height * $ratio);
		} elseif ($newwidth && $newheight) {
			$ratiow = $newwidth/$width;
			$ratioy = $newheight/$height;
			$ratio = min([$ratiow,$ratioy]);
			$newwidth = intval($width * $ratio);
			$newheight = intval($height * $ratio);
			// ONLY FOR CHECK
		} else {
			throw new \Exception("Required one dimension {$newheight}x{$newwidth}");
		}
		$source->resizeimage($newwidth, $newheight,\Imagick::FILTER_LANCZOS,1);
		return $source;
	}

	/**
	 * 
	 * @param \Imagick $source
	 * @param number $newwidth
	 * @param number $newheight
	 * @throws \Exception
	 */
	private function box(&$source,$newwidth = 0,$newheight = 0) {
		list($width,$height) = array_values($source->getimagegeometry());
		
		if ($newwidth && $newheight) {
			// ONLY FOR CHECK
		} else {
			throw new \Exception("Required one dimension {$newheight}x{$newwidth}");
		}
		$box = new \Imagick();
		$box->newImage($newwidth, $newheight, 'transparent', 'png' );
		$box->compositeimage($source, \imagick::COMPOSITE_OVERLAY, -($width-$newwidth)/2, -($height-$newheight)/2);
		//$source->cropimage($newwidth, $newheight, 0, 0);
		//$source->extentimage($newwidth, $newheight, 0, 0);

		return $box;
	}
}