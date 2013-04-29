<?php 
namespace framework\views;
use framework\page;
use framework\io\file;
use framework\html\element;
use framework\html\responsive\textblock;
use framework\app;
use framework\html\anchorbutton;
class admin_update extends page {
	protected $title = "Aggiornamenti";
	function action_def() {
		$cont = new element();
		$file = file::cache("checksums.dat");
		$data = array();
		if ($file->exist()) {
			$data = $file->getValues();
		}
		$current = $this->createMap();
		if (count($data) == 0) {
			$data = $current;
			$file->setValues($data);
		}
		$diffs = array_diff_assoc($current,$data);
		$filecont = $cont->append(new textblock("File modificati dal " . date(app::conf()->format->date,$file->lastedit())));
		foreach ($diffs as $key => $value) {
			$filecont->append(array(new element("strong",array(),$key) ," checksum:".$value) );
		}
		if (!$diffs && count($diffs) == 0) {
			$filecont->append("Tutti i file corrispondono");
		}
		$cont->append(new anchorbutton($this->url("reset"), "Aggiorna la mappa"));
		return $cont;
	}
	
	function action_reset() {
		$this->type = page::TYPE_REDIRECT;
		file::file("checksums.dat")->delete();
		return $this->url();
	}
	
	private function createMap() {
		$files = $this->glob_recursive("*");
		$data = array();
		foreach ($files as $file) {
			$data[$file] = md5_file($file);
		}
		unset($data["./usr/checksums.dat"]);
		return $data;
	}
	
	private function glob_recursive($pattern, $flags = 0) {
		$files = glob($pattern, $flags);
		foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
			$files = array_merge($files, $this->glob_recursive($dir.'/'.basename($pattern), $flags));
		}
		return $files;
	}
	
}