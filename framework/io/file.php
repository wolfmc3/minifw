<?php
namespace framework\io; 
class file {
	private $name;
	private $filepath;
	private $usecache;
	private static $cache = array();
	public static $cachelen = 100000;
	//TODO:GESTIONE CACHE IN LETTURA 
	
	static function file($file) {
		return new file($file,FALSE);
	}
	
	static function cache($file) {
		return new file($file,TRUE);
	}
	
	function __construct($file,$usecache = FALSE,$basefolder = "") {
		if ($basefolder) {
			$this->filepath = file::get_absolute_path(__DIR__."/../../$basefolder".$file);
		} else {
			$this->filepath = file::get_absolute_path(__DIR__."/../../usr/".$file);
		}
		$this->name = $file;
		$this->usecache = ($usecache && self::$cachelen > 0 && $this->exist() && filesize($this->filepath) < 10000);
	}
	
	function exist() {
		return file_exists($this->filepath);
	}
	
	function lastedit() {
		return filemtime($this->filepath);
	}
	
	function delete() {
		return unlink($this->filepath);
	}
	
	function read() {
		$res = "";
		if ($this->usecache) {
			if (array_key_exists($this->filepath, self::$cache)) {
				$res = self::$cache[$this->filepath];
			} else {
				self::$cache[$this->filepath] = file_get_contents($this->filepath);
				$res = &self::$cache[$this->filepath];
				self::$cachelen -= strlen($res);
			}
		} else {
			$res = file_get_contents($this->filepath);
		}
		return $res;
	}
	
	function write($string) {
		return file_put_contents($this->filepath, $string);
	}
	
	function setValues($data) {
		return $this->write(serialize($data));
	}
	
	function getValues() {
		//var_dump(unserialize($this->read()));
		return unserialize($this->read());
	}
	
	static function get_absolute_path($path) {
		$path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
		$parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
		$absolutes = array();
		if (substr($path, 0,1) == DIRECTORY_SEPARATOR) $absolutes[] = "";
		foreach ($parts as $part) {
			if ('.' == $part) continue;
			if ('..' == $part) {
				array_pop($absolutes);
			} else {
				$absolutes[] = $part;
			}
		}
		return implode(DIRECTORY_SEPARATOR, $absolutes);
	}
	
	function __toString() {
		return $this->read();
	}
}