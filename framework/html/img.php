<?php
namespace framework\html; 
	use framework\app;
	/**
	 * img
	 *
	 * Genera un tag immagine specifico per una delle immagini presenti nella cartella /img/<br>
	 * Esempio:
	 * <code>
	 * use framework\html\img;
	 * $logo = new img("logo.png");
	 * $map = new img("other/map.png");
	 * </code>
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 *
	 * @see element
	 *
	 */
	class img extends element {
		/**
		 * Costruttore
		 * 
		 * @param string $img percorso immagine relativa alla cartella /img/*
		 */
		function __construct($img) {
			parent::__construct("img",array("src" => app::root()."img/$img"));
		}
	}	

