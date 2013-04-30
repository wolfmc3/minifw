<?php
/**
 *
 * img.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\views;
use framework\page;
use framework\app;
/**
 *
 * Vista per la visualizzazione delle immagini e gestione della cache
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw
 *
 */
class img extends page {
	/**
	 *
	 * @var int Tipo valore di ritorno
	 */
	protected $type = page::TYPE_CUSTOM;
	/**
	 * Azione di default sempre HTTP404
	 * @see \framework\page::action_def()
	 */
	function action_def() {
		header('HTTP/1.0 404 Not Found');
	}
	/**
	 * Risposta a tutte le richieste
	 */
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
		$ext = str_replace("image/", "", $type);
		//$_SESSION["test"] = "CIAAAAOOOOO";
		if (next($uri)) {
			$tmp = app::conf()->system->imagecache;
			$tmpname = $tmp.urlencode(implode("_", $uri).".$ext");
			prev($uri);
			if (!file_exists($tmpname)){
				//PREVENT TOO MANY REQUEST
				if (isset($_SESSION["cacheimgcount"])) {
					if ((time()-$_SESSION["cacheimglast"]) < 60 ) {
						$_SESSION["cacheimgcount"] = $_SESSION["cacheimgcount"]+1;
						if ($_SESSION["cacheimgcount"] > app::conf()->system->maximgrequest) {
							header("HTTP/1.1 429 Too Many Requests");
							return;
						}

					} else {
						$_SESSION["cacheimgcount"] = 0;
					}
				} else {
					$_SESSION["cacheimgcount"] = 0;
				}
				$_SESSION["cacheimglast"] = time();

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
						} elseif (ctype_alpha($operation) && $operation == "sepia") {
							$source->modulateimage(140, 100, 100);
							$source->contrastImage( 1 );
							$source->sepiatoneimage(80);
							$source->adaptiveBlurImage( 1, 1 );
							$source->addnoiseimage(\Imagick::NOISE_GAUSSIAN,\Imagick::CHANNEL_GRAY);
						} elseif (ctype_alpha($operation) && $operation == "enh") {
							$source->normalizeimage();
							$source->modulateimage(130, 155, 100);
							$source->contrastImage( 1 );
						} elseif (ctype_alpha($operation) && $operation == "bw") {
							$source->contrastImage( 1 );
							$source->contrastImage( 1 );
							$source->contrastImage( 0.5 );
							$source->modulateimage(115, 10, 100);
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
				//$source->setImageBackgroundColor(new \ImagickPixel('white'));
				//$source->setimageformat("jpg");
				$source->writeimage($tmpname);

				$img = $tmpname;
				$type = "image/".$source->getimageformat();
			} else  {
				$img = $tmpname;
			}
		}

		$last_modified_time = filemtime($img);
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time) {
			header("HTTP/1.1 304 Not Modified");
			return;
		}

		header('Content-Type:'.$type);
		header('Content-Length: ' . filesize($img));
		header('Cache-control: public, max-age='.(60*60*6).', pre-check='.(60*60*6).'');
		header("Pragma: public");
		header('Expires: '. date(DATE_RFC822,strtotime(" 2 day")));
		header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");

		//header("Cache-Control: max-age=1, private, proxy-revalidate");
		readfile($img);

	}

	/**
	 * loadimage($file)
	 *
	 * Carica l'immagine
	 *
	 * @param string $file
	 * @return \Imagick
	 */
	private function loadimage($file) {
		$source = new \Imagick($file);
		//$source->setimageformat("png");
		return $source;
	}
	/**
	 * resize()
	 *
	 * Ridimensiona l'immagine
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
			$ratio = min(array($ratiow,$ratioy));
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
	 * box()
	 *
	 * Crea un box che include l'immagine centrata
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

		$box->newImage($newwidth, $newheight, $source->getimagebackgroundcolor(), $source->getimageformat() );
		$box->compositeimage($source, \imagick::COMPOSITE_OVER, -($width-$newwidth)/2, -($height-$newheight)/2);
		//$box->setImageBackgroundColor(new \ImagickPixel('white'));

		//$source->cropimage($newwidth, $newheight, 0, 0);
		//$source->extentimage($newwidth, $newheight, 0, 0);

		return $box;
	}
}