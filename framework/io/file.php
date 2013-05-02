<?php
/**
 *
 * file.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\io;
/**
 *
 * Classe file
 *
 * Questa classe raccoglie le operazioni comuni su file di testo
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/io
 *
 */
class file {
	/**
	 *
	 * @var string Nomefile
	 */
	private $name;
	/**
	 *
	 * @var string Nome completo del file incluso percorso
	 */
	private $filepath;
	/**
	 *
	 * @var boolean Indica se il file usa la cache in lettura
	 */
	private $usecache;
	/**
	 *
	 * @var string[] Contenitore cache dei file
	 */
	private static $cache = array();
	/**
	 *
	 * @var number Dimensione a scalare della cache
	*/
	public static $cachelen = 100000;

	/**
	 * file::file(...)
	 *
	 * Inizializza un  oggetto file senza gestione della cache
	 *
	 * @param string $file nome del file nella cartella /usr/[file]
	 * @return \framework\io\file
	 */
	static function file($file) {
		return new file($file,FALSE);
	}

	/**
	 * file::cache(...)
	 *
	 * Inizializza un oggetto file con gestione della cache
	 *
	 * @param string $file nome del file nella cartella /usr/[file]
	 * @return \framework\io\file
	 */
	static function cache($file) {
		return new file($file,TRUE);
	}

	/**
	 * Costruttore
	 *
	 * Apre un file
	 *
	 * @param string $file Nome del file senza percorso
	 * @param boolean $usecache optional Se TRUE usa la cache in lettura per le letture successive
	 * @param string $basefolder optional se non specificato apre il file nella cartella /usr/[nomefile]
	 */
	function __construct($file,$usecache = FALSE,$basefolder = "") {
		if ($basefolder) {
			$this->filepath = file::get_absolute_path(__DIR__."/../../$basefolder".$file);
		} else {
			$this->filepath = file::get_absolute_path(__DIR__."/../../usr/".$file);
		}
		$this->name = $file;
		$this->usecache = ($usecache && self::$cachelen > 0 && $this->exist() && filesize($this->filepath) < 10000);
	}

	/**
	 * exist()
	 *
	 * Controlla se il file esiste
	 *
	 * @return boolean
	 */
	function exist() {
		return file_exists($this->filepath);
	}
	/**
	 * lastedit()
	 *
	 * Ritorna la data dell'ultima modifica al file
	 *
	 * @return number
	 */
	function lastedit() {
		return filemtime($this->filepath);
	}

	/**
	 * delete()
	 *
	 * Cancella il file
	 *
	 * @return boolean
	 */
	function delete() {
		return unlink($this->filepath);
	}

	/**
	 * read()
	 * Legge il file e ritorna il contenuto. questo metodo utilizza la cache se attivata
	 * @return string
	 */
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

	/**
	 * write()
	 *
	 * Sostituisce il contenuto del file con il contenuto della variabile $string
	 *
	 * @param string $string Stringa da scrivere nel file
	 * @return number
	 */
	function write($string) {
		return file_put_contents($this->filepath, $string);
	}
	/**
	 * append()
	 *
	 * Aggiunge alla fine del file il contenuto di $string
	 *
	 * @param string $string
	 * @return number
	 */
	function append($string) {
		return file_put_contents($this->filepath, $string, FILE_APPEND);
	}
	/**
	 * setValues()
	 *
	 * Scrive il valore della variabile $data tramite serializzazione
	 *
	 * @param mixed $data Oggetto serializzabile
	 */
	function setValues($data) {
		return $this->write(serialize($data));
	}
	/**
	 * getValues()
	 *
	 * Legge il valore memorizzato tramite la funzione setValues($data)
	 *
	 * @return mixed
	 */
	function getValues() {
		//var_dump(unserialize($this->read()));
		return unserialize($this->read());
	}
	function iniRead() {
		return parse_ini_string($this->read());
	}
	/**
	 * get_absolute_path($path)
	 *
	 * Ritorna il percorso assoluto specificato. rimuove . e ..
	 *
	 * @param string $path
	 * @return string
	 */
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
	/**
	 * toString()
	 *
	 * Legge il contenuto del file
	 *
	 * @return string
	 */
	function __toString() {
		return $this->read();
	}
}